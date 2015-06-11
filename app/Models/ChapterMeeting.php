<?php namespace APOSite\Models;

use Illuminate\Database\Eloquent\Model;

class ChapterMeeting extends Model {

    protected $fillable = [
        'display_name',
        'description',
        'event_date',
        'location'
    ];

    public function ContractEvent(){
        return $this->morphMany('APOSite\Models\ContractEvent','event_type');
    }

}
