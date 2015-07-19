<?php namespace APOSite\Models;

use Illuminate\Database\Eloquent\Model;

class ExecMeeting extends Model {

	protected $fillable = [

    ];


    public static function createMeeting($attributes = array()){
        $meeting = new ExecMeeting;
        $meeting->fill($attributes);
        $meeting->save();
        $eventData = new ContractEvent;
        $eventData->fill($attributes);
        $eventData->EventType()->associate($meeting);
        $eventData->save();
        return $meeting;
    }
}
