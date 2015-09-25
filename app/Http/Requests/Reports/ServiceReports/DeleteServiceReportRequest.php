<?php

namespace APO\Http\Requests\Reports\ServiceReports;

use APO\Http\Requests\Request;

class DeleteServiceReportRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //Todo update to change permissions once access control is implemented
        return false;
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
