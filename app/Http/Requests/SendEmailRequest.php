<?php

namespace APOSite\Http\Requests;

use APOSite\Http\Controllers\AccessController;
use Illuminate\Support\Facades\Auth;

class SendEmailRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return AccessController::isWebmaster(Auth::user());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'to' => 'required|exists:users,id'
        ];
    }
}
