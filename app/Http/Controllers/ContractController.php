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
use Exception;

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
        $existingContract = LoginController::currentUser()->contractForSemester(null);
        return view('contracts.sign')->with(compact('existingContract'));
    }

    public function manage(ContractManageRequest $request)
    {
        return view('contracts.manage');
    }

    //To use used by membership vp to change contracts, and by pledge ed to advance pledges. NOT for signing contracts
    public function modifyContract(ContractModifyRequest $request)
    {
        $user = LoginController::currentUser();
        if (!$request->has('contract') && (AccessController::isMembership($user) || AccessController::isPledgeEducator($user))) {
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
                    return Response::json(['errors' => ['general' => ['An error occurred signing your contract.']]],500);
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
        $existing = DB::table('contract_user')->where('user_id', $user)->where('semester_id', $sem->id)->select('contract_id')->get();
        if (count($existing) > 0) {
            try{
                DB::table('contract_user')->where('user_id', $user)->where('semester_id', $sem->id)->update(['contract_id'=>$newContract]);
                return true;
            } catch (Exception $e){
                return false;
            }
        } else {
            try{
                DB::table('contract_user')->insert(['contract_id'=>$newContract,'user_id'=>$user,'semester_id'=>$sem->id]);
                return true;
            }catch(Exception $e){
                return false;
            }
        }
    }

    public function changeContractSigning(ContractModifyRequest $request){
        dd("Made it to the right function.");
        $this->toggleContractSigning();
        if(!GlobalVariable::ContractSigning()->value && $request->has('markInactive')){
            //Mark anyone here who should have signed a contract to be inactive
            $si = GlobalVariable::ShowInactive();
            $si->value =  ($request->get('markInactive') == 1);
            $si->save();
        }
        return view('contracts.manage');
    }

    private function toggleContractSigning(){
        $cs = GlobalVariable::ContractSigning();
        $cs->value = !$cs->value;
        dd($cs);
        $cs->save();
    }
}
