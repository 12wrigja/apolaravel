<?php

namespace APOSite\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
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
        return $this->belongsToMany('APOSite\Models\User')->withPivot('value');
    }

}
