<?php

namespace APOSite\Http\Requests;

use APOSite\Http\Controllers\LoginController;

class ImageStoreRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return LoginController::currentUser() != null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image'=>'required|mimes:jpg,jpeg,png'
        ];
    }
}
