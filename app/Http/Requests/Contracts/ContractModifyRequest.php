<?php

namespace APOSite\Http\Requests\Contracts;

use APOSite\Http\Controllers\AccessController;
use APOSite\Http\Controllers\LoginController;
use APOSite\Http\Requests\Request;
use Illuminate\Validation\Factory as ValidationFactory;
use APOSite\Models\Users\User;
use APOSite\Models\Semester;
use Illuminate\Support\Facades\DB;

class ContractModifyRequest extends Request
{
    /**
     * ContractModifyRequest constructor.
     */
    public function __construct(ValidationFactory $validationFactory)
    {
        $validationFactory->extend('signed',function($attribute, $value, $parameters, $validator){
            $user = User::find($value);
            if($user != null){
                $contractName = $parameters[0];
                $semesterID = Semester::currentSemester()->id;
                if(count($parameters) > 1){
                    $semesterID = $parameters[1];
                }
                $res = DB::table('contract_user')->select('contract_id')->where('user_id',$user->id)->where('semester_id',$semesterID)->get();
                $value = $res[0]->contract_id;
                if(strtolower($value) == $contractName){
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
        $contractTypes = 'Active,Associate,Inactive,MemberInAbsentia,Alumni,Advisor,Pledge';
        if(AccessController::isMembership($user)){
            $rules = ['brothers'=>'required|array'];
            if (Request::has('brothers')) {
                foreach (Request::get('brothers') as $index => $brother) {
                    $rules['brothers.' . $index . '.id'] = ['required', 'exists:users,id'];
                    $rules['brothers.' . $index . '.contract'] = ['required','in:'.$contractTypes];
                }
            }
            return $rules;
        } else if (AccessController::isPledgeEducator($user)){
            $rules = ['brothers'=>'required|array'];
            if (Request::has('brothers')) {
                foreach (Request::get('brothers') as $index => $brother) {
                    $rules['brothers.' . $index . '.id'] = ['required', 'exists:users,id','signed:pledge'];
                    $rules['brothers.' . $index . '.contract'] = ['required','in:'.$contractTypes];
                }
            }
            return $rules;
        } else {
            return ['contract'=>'required|in:'.$contractTypes];
        }
    }
}
