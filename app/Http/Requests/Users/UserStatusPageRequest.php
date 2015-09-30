<?php namespace APOSite\Http\Requests\Users;

use APOSite\Http\Controllers\AccessController;
use APOSite\Http\Requests\Request;
use APOSite\Http\Controllers\LoginController;

class UserStatusPageRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->route('cwruid') == LoginController::currentUser()->id || AccessController::isMembership(LoginController::currentUser());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

}
