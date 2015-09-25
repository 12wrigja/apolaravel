<?php

namespace APO\Http\Requests\Reports\ServiceReports;

use APO\Http\Controllers\Auth\LoginController;
use APO\Http\Requests\Request;

class ReadServiceReportRequest extends Request
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
        ];
    }
}
