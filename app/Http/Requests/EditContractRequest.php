<?php namespace APOSite\Http\Requests;

use APOSite\Http\Requests\Request;

class EditContractRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
        //TODO Add in authorization for editing of contracts.
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
        $rules = [
            'display_name'=>['sometimes','min:10'],
            'description'=>['sometimes','min:40']
        ];
        //TODO add in validation of new contract requirements.
        return $rules;
	}

}
