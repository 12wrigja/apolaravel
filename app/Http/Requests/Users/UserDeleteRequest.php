<?php namespace APOSite\Http\Requests;


use APOSite\Http\Controllers\AccessController;

class UserDeleteRequest extends \Request {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(){
        return AccessController::isWebmaster(LoginController::currentUser());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(){
        return [];
    }

}
