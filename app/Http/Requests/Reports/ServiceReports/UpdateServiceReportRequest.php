<?php

namespace APO\Http\Requests\Reports\ServiceReports;

use APO\Http\Requests\Request;

class UpdateServiceReportRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //TODO update permissions once the access system is in place.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'approved' => ['sometimes', 'required', 'boolean']
        ];
    }
}
