<?php

namespace APOSite\Http\Requests\Users;

use APOSite\Http\Controllers\AccessController;
use APOSite\Http\Requests\Request;
use APOSite\Http\Controllers\LoginController;
use APOSite\Models\Users\User;

class UserDeleteRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = User::find($this->route('cwruid'));
        if($user->isPledge() && AccessController::isPledgeEducator(LoginController::currentUser())){
            return true;
        } else {
            return AccessController::isWebmaster(LoginController::currentUser());
        }
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
