<?php

namespace APOSite\Models\Contracts;

use APOSite\Models\Contracts\Reports\Types\BrotherhoodReport;
use APOSite\Models\Contracts\Reports\Types\ChapterMeeting;
use APOSite\Models\Contracts\Reports\Types\DuesReport;
use APOSite\Models\Contracts\Reports\Types\ExecMeeting;
use APOSite\Models\Contracts\Reports\Types\PledgeMeeting;
use APOSite\Models\Contracts\Reports\Types\ServiceReport;
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

    public function scopeServiceReports($query)
    {
        return $query->whereReportTypeType(ServiceReport::class);
    }

    public function scopeBrotherhoodReports($query)
    {
        return $query->whereReportTypeType(BrotherhoodReport::class);
    }

    public function scopeChapterMeetings($query)
    {
        return $query->whereReportTypeType(ChapterMeeting::class);
    }

    public function scopePledgeMeetings($query)
    {
        return $query->whereReportTypeType(PledgeMeeting::class);
    }

    public function scopeExecMeetings($query)
    {
        return $query->whereReportTypeType(ExecMeeting::class);
    }

    public function scopeDuesReports($query)
    {
        return $query->whereReportTypeType(DuesReport::class);
    }

}
