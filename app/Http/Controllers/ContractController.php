<?php

namespace APOSite\Http\Controllers;

use APOSite\GlobalVariable;
use APOSite\Http\Requests;
use APOSite\Http\Requests\Contracts\ContractManageRequest;
use APOSite\Http\Requests\Contracts\ContractModifyRequest;
use APOSite\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ContractController extends Controller
{

    /**
     * ContractController constructor.
     */
    public function __construct()
    {
        $this->middleware('SSOAuth');
    }


    /**
     * Displays the contract signing page
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    public function manage(ContractManageRequest $request)
    {
        return view('contracts.manage');
    }

    public function modifyContract(ContractModifyRequest $request)
    {
        $user = LoginController::currentUser();
        if (AccessController::isMembership($user) || AccessController::isPledgeEducator($user) && !$request->has('contract')) {
            //Process bulk transactions
            $brothers = $request->get('brothers');
            $failedBrothers = [];
            $successBrothers = [];
            foreach($brothers as $brother){
                $id = $brother['id'];
                $newContract = $brother['contract'];
                if(!$this->changeContract($id,$newContract)){
                    array_push($brothers,$brother->id);
                } else {
                    array_push($successBrothers,['id'=>$id,'contract'=>$newContract]);
                }
            }
            if(count($failedBrothers) == 0){
                return Response::json(['message' => 'OK','brothers'=>$successBrothers], 200);
            } else {
                return Response::json(['errors' => ['general' => ['An error occured signing contracts for users: .'.join(',',$failedBrothers)]]],500);
            }
        } else {
            //Process a personal transaction. Check to make sure that contract signing is enabled.
            if (GlobalVariable::ContractSigning()->value) {
                if($this->changeContract($user->id,$request->get('contract'))){
                    return Response::json(['message' => 'OK'], 200);
                } else {
                    return Response::json(['errors' => ['general' => ['An error occured signing your contract.']]],500);
                }

            } else {
                return Response::json(['errors' => ['general' => ['Contract signing is not enabled at this time.']]],403);
            }
        }
    }

    private function changeContract($user, $newContract)
    {
        //Contract signing is enabled. Sign the given contract for the current semester
        //Check and see if they have already signed a contact for this semester:
        $sem = Semester::currentSemester();
        $queryBase = DB::table('contract_user')->where('user_id', $user)->where('semester_id', $sem->id);
        $existing = with(clone $queryBase)->select('contract_id')->get();
        if (count($existing) > 0) {
            return with(clone $queryBase)->update(['contract_id'=>$newContract]);
        } else {
            return with(clone $queryBase)->insert(['contract_id'=>$newContract]);
        }
    }
}
