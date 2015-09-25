<?php

namespace APO\Http\Requests\Reports\ServiceReports;

use APO\Http\Controllers\Auth\LoginController;
use APO\Http\Requests\Request;

class CreateServiceReportRequest extends Request
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
        $rules = [
            //Rules for the core report data
            'event_name' => ['required', 'min:10'],
            'description' => ['required', 'min:40'],
            'event_date' => ['required', 'date'],
            'brothers' => ['required', 'array'],
            //Rules specific to the service report
            'location' => ['required', 'min:10'],
            'service_type' => ['required', 'in:chapter,country,community,campus'],
            'project_type' => ['required', 'in:inside,outside'],
            'off_campus' => ['required', 'boolean'],
            'travel_time' => ['required_if:off_campus,true', 'integer']
        ];
        $extraRules = [];
        if(Request::has('brothers')) {
            foreach (Request::get('brothers') as $index => $brother) {
                $extraRules['brothers.' . $index . '.id'] = ['required', 'exists:users,id'];
                $extraRules['brothers.' . $index . '.hours'] = ['sometimes', 'required', 'integer', 'min:0'];
                $extraRules['brothers.' . $index . '.minutes'] = ['sometimes', 'required', 'integer', 'min:0','max:59'];
            }
        }
        $newRules = array_merge($rules, $extraRules);
        return $newRules;
    }


    public function messages(){
        $messages = [
            'off_campus.in' => 'off_campus should be either true or false',
            'travel_time' => 'travel time is required if the event is off-campus'
        ];
        $extraMessages = [];
        if (Request::has('brothers')) {
            foreach (Request::get('brothers') as $index => $brother) {
                $extraMessages['brothers.' . $index . '.id.exists'] = 'The cwru id :input is not valid.';
            }
        }
        $allMessages = array_merge($messages, $extraMessages);
        return $allMessages;
    }

}
