<?php namespace APOSite\Http\Requests;

use APOSite\Http\Requests\Request;

class StoreContractRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
        //TODO add in authorization for contract storing requests.
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
            'display_name'=>['required','min:10'],
            'description'=>['required','min:40']
        ];
	}

}
