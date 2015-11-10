<?php namespace APOSite\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Redirect;

abstract class Request extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public abstract function authorize();

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public abstract function rules();

    public function forbiddenResponse()
    {
        if($this->wantsJson()){
            return Request::json(['error'=>'403','message'=>'You are not authorized to do that action.']);
        } else {
            return Redirect::route('error_show',['id'=>403]);
        }
    }


}
