<?php

namespace APOSite\Http\Requests\Users;

use APOSite\Http\Controllers\AccessController;
use Illuminate\Support\Facades\Auth;
use APOSite\Http\Requests\Request;
use APOSite\Models\Users\User;

class UserPersonalPageRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $pageUser = User::find($this->route('cwruid'));
        if ($pageUser == null) {
            return true;
        } else {
            if ($pageUser->id == Auth::user()->id) {
                return true;
            } elseif (AccessController::isMembership(Auth::user())) {
                return true;
            } elseif ($pageUser->isPledge() && AccessController::isPledgeEducator(Auth::user())) {
                return true;
            } else {
                return false;
            }
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
