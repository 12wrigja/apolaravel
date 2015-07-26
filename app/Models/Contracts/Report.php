<?php

namespace APOSite\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use SoftDeletes;
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
