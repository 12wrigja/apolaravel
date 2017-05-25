<?php

namespace APOSite\Http\Requests\Contracts;

use APOSite\Http\Controllers\AccessController;
use Illuminate\Support\Facades\Auth;
use APOSite\Http\Requests\Request;

class ContractManageRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() && AccessController::isMembership(Auth::user());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
