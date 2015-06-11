<?php namespace APOSite\Models;

use Illuminate\Database\Eloquent\Model;

class CEvent extends Model {

    protected $fillable = [
        'display_name',
        'description',
        'event_date'
    ];

    public function EventType(){
        return $this->morphTo();
    }

}
