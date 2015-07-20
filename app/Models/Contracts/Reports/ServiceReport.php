<?php

namespace APOSite\Models\Reports;

use League\Fractal\Manager;
use APOSite\Http\Transformers\ServiceReportTransformer;
use Request;

class ServiceReport extends BaseModel
{

    protected $rules = [
        //Rules for the core report data
        'display_name' => ['required', 'min:10'],
        'description' => ['required', 'min:40'],
        'event_date' => ['required', 'date'],
        'brothers' => ['required', 'array'],
        //Rules specific to the service report
        'location' => ['required', 'min:10'],
        'service_type' => ['required', 'in:chapter,country,community,campus'],
        'project_type' => ['required', 'in:inside,outside'],
        'off_campus' => ['required', 'in:false,true'],
        'travel_time' => ['required_if:off_campus,true','integer']
    ];

    protected $messages = [
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

    public function computeValue(array $brotherData){
        $hours = array_key_exists('hours',$brotherData)?$brotherData['hours']:0;
        $minutes = array_key_exists('minutes',$brotherData)?$brotherData['minutes']:0;
        return $hours * 60 + $minutes;
    }

    public function rules(){
        $extraRules = [];
        foreach(Request::get('brothers') as $index=>$brother){
            $extraRules['brothers.'.$index.'.id'] = ['required','exists:users,id'];
            $extraRules['brothers.'.$index.'.hours'] = ['sometimes','required','integer','min:0'];
            $extraRules['brothers.'.$index.'.minutes'] = ['sometimes','required','integer','min:0'];
        }
        $newRules = array_merge($this->rules,$extraRules);
        return $newRules;
    }

}
