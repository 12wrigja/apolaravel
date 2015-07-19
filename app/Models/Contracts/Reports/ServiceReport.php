<?php

namespace APOSite\Models\Reports;

use League\Fractal\Manager;
use APOSite\Http\Transformers\ServiceReportTransformer;

class ServiceReport extends BaseModel
{

    protected static $baseRules = [
        //Rules for the core report data
        'display_name' => ['required', 'min:10'],
        'description' => ['required', 'min:40'],
        'event_date' => ['required', 'date'],
    ];

    protected static $rules = [
        //Rules specific to the service report
        'location' => ['required', 'min:10'],
        'service_type' => ['required', 'in:chapter,country,community,campus'],
        'project_type' => ['required', 'in:inside,outside'],
        'off_campus' => ['required', 'in:false,true'],
        'travel_time' => ['required_if:off_campus,true','integer']
    ];

    protected static $messages = [
        'off_campus.in' => 'off_campus should be either true or false',
        'travel_time.required_if' => 'travel time is required if off_campus is true'
    ];

    protected $fillable = [
        'service_type',
        'location',
        'project_type',
        'off_campus',
        'travel_time'
    ];

    public function transformer(Manager $manager)
    {
        return new ServiceReportTransformer($manager);
    }

}
