<?php
/**
 * Created by PhpStorm.
 * User: James
 * Date: 11/07/2015
 * Time: 23:21
 */

namespace APOSite\Http\Requests;


class StoreContractRequirementRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'display_name' => ['required', 'min:10'],
            'description' => ['required', 'min:40'],
            'threshold' => ['required', 'integer'],
            'comparison' => ['required', 'in:EQ,NEQ,GEQ,GT,LT,LEQ']
        ];
        return $rules;
    }
}