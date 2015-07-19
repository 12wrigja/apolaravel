<?php namespace APOSite\Http\Requests;

use APOSite\Http\Controllers\EventPipelineController;
use APOSite\Http\Requests\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class StoreReportRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
        $type = Request::input('type');
		if(EventPipelineController::getClass($type) == null){
			return false;
		}
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
        dd(Input::all());
		$type = Request::input('type');
		$class = EventPipelineController::getClass($type);
		if($class == null){
			return [];
		} else {
			return $class->getMethod('rules')->invoke(null);
		}
//		$rules = [
//            'display_name'=>['required','min:10'],
//            'description'=>['required','min:40']
//        ];
//        return $rules;
//        //TODO finish validation rules to validate all incoming requirement id's
	}

}
