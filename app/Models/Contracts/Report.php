<?php

namespace APOSite\Models\Contracts;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{

    public $timestamps = false;
    protected $fillable = [];

    public function EventType()
    {
        return $this->morphTo('report_type');
    }

    public function linkedUsers()
    {
        return $this->belongsToMany('APOSite\Models\Users\User')->withPivot('value', 'tag');
    }

    public function scopeServiceReports($query){
        return $query->whereReportTypeType('APOSite\Models\Contracts\Reports\Types\ServiceReport');
    }

    public function scopeBrotherhoodReports($query){
        return $query->whereReportTypeType('APOSite\Models\Contracts\Reports\Types\BrotherhoodReport');
    }

    public function scopeChapterMeetings($query){
        return $query->whereReportTypeType('APOSite\Models\Contracts\Reports\Types\ChapterMeeting');
    }

    public function scopePledgeMeetings($query){
        return $query->whereReportTypeType('APOSite\Models\Contracts\Reports\Types\PledgeMeeting');
    }

    public function scopeExecMeetings($query){
        return $query->whereReportTypeType('APOSite\Models\Contracts\Reports\Types\ExecMeeting');
    }

    public function scopeDuesReports($query){
        return $query->whereReportTypeType('APOSite\Models\Contracts\Reports\Types\DuesReport');
    }

}
