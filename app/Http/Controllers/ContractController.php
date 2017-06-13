<?php

namespace APOSite\Http\Controllers;

use APOSite\ContractFramework\Contracts\Contract;
use APOSite\GlobalVariable;
use APOSite\Mail\ContractSigned;
use APOSite\Mail\ContractSignResults;
use Illuminate\Support\Facades\Auth;
use APOSite\Http\Requests\Contracts\ContractManageRequest;
use APOSite\Http\Requests\Contracts\ContractModifyRequest;
use APOSite\Models\Semester;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;

class ContractController extends Controller
{

    /**
     * ContractController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Displays the contract signing page
     *
     * @return Response
     */
    public function index()
    {
        $existingContract = Auth::user()->contractForSemester(null);
        $signableContracts = Contract::getCurrentSignableContracts();
        $signableContracts->transform(function ($item) {
            if ($item->version > 1) {
                $contractVersionCode = $item->contract_name . 'V' . $item->version;
            } else {
                $contractVersionCode = $item->contract_name;
            }
            $actualName = Contract::ContractHome . $contractVersionCode . 'Contract';
            $meta = $actualName::getMetadata();
            $item->code = $contractVersionCode;
            $item->metadata = $meta;
            return $item;
        });
//        dd($signableContracts);
        return view('contracts.sign')->with(compact('existingContract', 'signableContracts'));
    }

    public function manage(ContractManageRequest $request)
    {
        return view('contracts.manage');
    }

    //To use used by membership vp to change contracts, and by pledge ed to advance pledges. NOT for signing contracts
    public function modifyContract(ContractModifyRequest $request)
    {
        $user = Auth::user();
        if (!$request->has('contract') && (AccessController::isMembership($user) || AccessController::isPledgeEducator($user))) {
            //Process bulk transactions
            $brothers = $request->get('brothers');
            $failedBrothers = [];
            $successBrothers = [];
            foreach ($brothers as $brother) {
                $id = $brother['id'];
                $newContract = $brother['contract'];
                if (!$this->changeContract($id, $newContract)) {
                    array_push($brothers, $brother->id);
                } else {
                    array_push($successBrothers, ['id' => $id, 'contract' => $newContract]);
                }
            }
            if (count($failedBrothers) == 0) {
                return Response::json(['message' => 'OK', 'brothers' => $successBrothers], 200);
            } else {
                return Response::json([
                    'errors' => [
                        'general' => [
                            'An error occured signing contracts for users: .' . join(',', $failedBrothers)
                        ]
                    ]
                ], 500);
            }
        } else {
            //Process a personal transaction. Check to make sure that contract signing is enabled.
            if (GlobalVariable::ContractSigning()->value) {
                $newContract = $request->get('contract');
                if ($this->changeContract($user->id, $newContract)) {
                    //Send responses to committees to membership vp and the person who signed.
                    $semester = Semester::currentSemester();
                    $contract = $user->contractForSemester($semester);
                    $contractName = $contract::$name;
                    $userFullName = $user->getFullDisplayName();
                    $userId = $user->id;
                    $semesterText = ucwords($semester->semester) . ' ' . $semester->year;
                    $reason = null;
                    if ($newContract == 'Active' || $newContract == 'Associate') {
                        $committees = $request->get('committees');
                        $committees = collect($committees)->sortBy(function ($item) {
                            return $item['rating'];
                        });
                        $committees->transform(function ($item) {
                            return $item['name'];
                        });
                    } else {
                        $committees = null;
                    }
                    if ($newContract == 'Inactive') {
                        $reason = $request->get('reason');
                    }
                    Mail::to($userId . '@case.edu')->queue(new ContractSigned($userId, $userFullName, $contractName, $semesterText, $committees, $reason));
//                    Mail::queue('emails.contracts.contract_signed',
//                        compact('contractName', 'userFullName', 'semesterText', 'committees', 'reason', 'userId'),
//                        function ($message) use ($userId, $userFullName, $semesterText) {
//                            $message->to(,
//                                $userFullName)->subject('Contract Signed for ' . $semesterText);
//                        });
//                    Mail::queue('emails.contracts.contract_sign_results',
//                        compact('contractName', 'userFullName', 'semesterText', 'committees', 'reason', 'userId'),
//                        function ($message) use ($userId, $userFullName, $semesterText) {
//                            $message->to('membership@apo.case.edu',
//                                $userFullName)->subject('Contract Signed for ' . $userFullName . ' (' . $userId . ') ' . $semesterText);
//                        });
                    Mail::to('membership@apo.case.edu')->queue(new ContractSignResults($userId, $userFullName, $contractName, $semesterText, $committees, $reason));
                    return Response::json(['message' => 'OK'], 200);
                } else {
                    return Response::json(['errors' => ['general' => ['An error occurred signing your contract.']]],
                        500);
                }
            } else {
                return Response::json(['errors' => ['general' => ['Contract signing is not enabled at this time.']]],
                    403);
            }
        }
    }

    private function changeContract($user, $newContract)
    {
        //Contract signing is enabled. Sign the given contract for the current semester
        //Check and see if they have already signed a contact for this semester:
        $sem = Semester::currentSemester();
        $existing = DB::table('contract_user')->where('user_id', $user)->where('semester_id',
            $sem->id)->select('contract_id')->get();
        if (count($existing) > 0) {
            try {
                DB::table('contract_user')->where('user_id', $user)->where('semester_id',
                    $sem->id)->update(['contract_id' => $newContract]);
                return true;
            } catch (Exception $e) {
                return false;
            }
        } else {
            try {
                DB::table('contract_user')->insert([
                    'contract_id' => $newContract,
                    'user_id' => $user,
                    'semester_id' => $sem->id
                ]);
                return true;
            } catch (Exception $e) {
                return false;
            }
        }
    }

    public function changeContractSigning(ContractManageRequest $request)
    {
        $cs = GlobalVariable::ContractSigning();
        $mi = GlobalVariable::ShowInactive();
        $cs->value = ($request->get('contract_signing') == "1");
        $mi->value = ($request->get('mark_inactive') == "1");
        $cs->save();
        $cs->fresh();
        $mi->save();
        $mi->fresh();
        return redirect()->route('contract_manage');
    }
}
