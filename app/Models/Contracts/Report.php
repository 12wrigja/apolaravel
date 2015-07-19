<?php

namespace APOSite\Models;

use APOSite\Models\Reports\ValidatingModel;

class Report extends ValidatingModel
{

    protected $fillable = [
        'display_name',
        'description',
        'event_date'
    ];

    public $timestamps = false;

    public function EventType(){
        return $this->morphTo('report_type');
    }

    public function linkedUsers(){
        return $this->belongsToMany('APOSite\Models\User');
    }

}
