<?php

namespace APOSite\Http\Requests\Contracts;

use APOSite\Http\Controllers\AccessController;
use APOSite\Http\Controllers\LoginController;
use APOSite\Models\Semester;
use APOSite\Models\Users\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Factory as ValidationFactory;
use APOSite\Http\Requests\Request;
use APOSite\ContractFramework\Contracts\Contract;

class ContractModifyRequest extends Request
{
    /**
     * ContractModifyRequest constructor.
     */
    public function __construct(ValidationFactory $validationFactory)
    {
        $validationFactory->extend('signed', function ($attribute, $value, $parameters, $validator) {
            $user = User::find($value);
            if ($user != null) {
                $contractName = $parameters[0];
                $semesterID = Semester::currentSemester()->id;
                if (count($parameters) > 1) {
                    $semesterID = $parameters[1];
                }
                $res = DB::table('contract_user')->select('contract_id')->where('user_id',
                    $user->id)->where('semester_id', $semesterID)->get();
                $value = $res[0]->contract_id;
                if (strtolower($value) == $contractName) {
                    return true;
                }
            }
            return false;
        },
            "This user did not sign that contract in that semester.");
    }


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = LoginController::currentUser();
        return $user != null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = LoginController::currentUser();
        $contractTypes = implode(',',Contract::getAllContractTypes()->map(function($item){
            if($item->version > 1){
                return $item->contract_name.'V'.$item->version;
            } else {
                return $item->contract_name;
            }
        })->toArray());
        if (!$this->has('contract') && (AccessController::isMembership($user) || AccessController::isPledgeEducator($user))) {
            //This is a special request from the membership or pledge educators who want to bulk - update contracts.
            if (AccessController::isMembership($user)) {
                $rules = ['brothers' => 'required|array'];
                if ($this->has('brothers')) {
                    foreach ($this->get('brothers') as $index => $brother) {
                        $rules['brothers.' . $index . '.id'] = ['required', 'exists:users,id'];
                        $rules['brothers.' . $index . '.contract'] = ['required', 'in:' . $contractTypes];
                    }
                }
                return $rules;
            } else {
                if (AccessController::isPledgeEducator($user)) {
                    $rules = ['brothers' => 'required|array'];
                    if ($this->has('brothers')) {
                        foreach ($this->get('brothers') as $index => $brother) {
                            $rules['brothers.' . $index . '.id'] = ['required', 'exists:users,id', 'signed:pledge'];
                            $rules['brothers.' . $index . '.contract'] = ['required', 'in:' . $contractTypes];
                        }
                    }
                    return $rules;
                }
            }
        } else {
            if(!AccessController::isMembership($user)){
                $contractTypes = implode(',',Contract::getCurrentSignableContracts()->map(function($item){
                    if($item->version > 1){
                        return $item->contract_name.'V'.$item->version;
                    } else {
                        return $item->contract_name;
                    }
                    })->toArray());
            }
            $base = ['contract' => 'required|in:' . $contractTypes];
            if($this->has('contract')){
                $contract = $this->get('contract');
                if($contract == 'Active' || $contract == 'Associate'){
                    //Rules go here to validate that we are getting in committe rankings.
                    $base = array_merge($base,['committees'=>['required','array']]);
                }
                else if ($contract == "Inactive"){
                    $base = array_merge($base,['reason'=>'required|string']);
                }
            }
            return $base;
        }
    }

}