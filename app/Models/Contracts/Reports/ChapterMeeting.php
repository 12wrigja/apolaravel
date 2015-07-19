<?php namespace APOSite\Models;

use Illuminate\Database\Eloquent\Model;

class ChapterMeeting extends Model {

    public static function createMeeting($attributes = array()){
        $meeting = new ChapterMeeting;
        $meeting->fill($attributes);
        $meeting->save();
        $eventData = new ContractEvent;
        $eventData->fill($attributes);
        $eventData->EventType()->associate($meeting);
        $eventData->save();
        return $meeting;
    }

    public function ContractEvent(){
        return $this->morphOne('APOSite\Models\ContractEvent','event_type');
    }

}
