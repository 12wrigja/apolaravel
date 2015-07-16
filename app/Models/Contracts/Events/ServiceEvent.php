<?php namespace APOSite\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceEvent extends Model {

	protected $fillable = [
        'service_type',
        'location',
        'project_type',
        'off_campus',
        'travel_time'
    ];

    public static function createEvent($attributes = array()){
        $meeting = new ServiceEvent;
        $meeting->fill($attributes);
        $meeting->save();
        $eventData = new ContractEvent;
        $eventData->fill($attributes);
        $eventData->EventType()->associate($meeting);
        $eventData->save();
        return $meeting;
    }

    public function coreEvent(){
        $coreEvent = $this->morphMany('APOSite\Models\ContractEvent','event_type');
        return $coreEvent;
    }

}
