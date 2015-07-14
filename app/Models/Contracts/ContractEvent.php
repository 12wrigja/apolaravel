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
}
