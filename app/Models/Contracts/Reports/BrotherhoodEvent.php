<?php namespace APOSite\Models\Reports;

use Illuminate\Database\Eloquent\Model;

class BrotherhoodEvent extends BaseModel {

	protected $fillable = ['location'];

    public static function createEvent($attributes = array()){
        $meeting = new BrotherhoodEvent;
        $meeting->fill($attributes);
        $meeting->save();
        $eventData = new ContractEvent;
        $eventData->fill($attributes);
        $eventData->EventType()->associate($meeting);
        $eventData->save();
        return $meeting;
    }

}
