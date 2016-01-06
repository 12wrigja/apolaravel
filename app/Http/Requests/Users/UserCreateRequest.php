<?php

namespace APOSite\Http\Requests\Users;

use APOSite\Http\Controllers\AccessController;
use APOSite\Http\Controllers\LoginController;

use APOSite\Http\Requests\Request;

class UserCreateRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = LoginController::currentUser();
        return AccessController::isWebmaster($user) || AccessController::isPledgeEducator($user);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'cwru_id' => 'required|unique:users,id',
        ];
    }
}
