<?php namespace APOSite\Models;

use Illuminate\Database\Eloquent\Model;

class ContractEvent extends Model {

    protected $table = "c_events";

    protected $fillable = [
        'display_name',
        'description',
        'event_date'
    ];

    public $timestamps = false;

    public function EventType(){
        return $this->morphTo('event_type');
    }
//
//    public function getDisplayName(){
//        return $this->display_name;
//    }
//
//    public function getDescription(){
//        return $this->description;
//    }
//
//    public function getEventDate(){
//        return $this->event_date;
//    }

}
