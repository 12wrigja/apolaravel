<?php

namespace APOSite\ContractFramework\Requirements;

use APOSite\Models\Contracts\Reports\Types\PledgeMeeting;

class PledgeMemberPledgeMeetingRequirement extends MeetingBasedRequirement
{
    public static $name = "Pledge Meetings";
    public static $description = "As an APO Pledge, you have to to attend all pledge meetings this semester.";

    protected $threshold = null;
    protected $comparison = 'EQ';

    public function computeValue()
    {
        $reports = $this->getReports($this->semester);
        return $reports->count();
    }

    public function getReports()
    {
        $semester = $this->semester;

        $chapter_meetings = $this->user->reports()->ChapterMeetings()->get();
        $chapter_meetings = $chapter_meetings->filter(function ($report) use ($semester) {
            $val = $semester->dateInSemester($report->report_type->event_date);
            $val = $val && $report->pivot->tag == 'pledge';
            return $val;
        });

        $exec_meetings = $this->user->reports()->ExecMeetings()->get();
        $exec_meetings = $exec_meetings->filter(function ($report) use ($semester) {
            $val = $semester->dateInSemester($report->report_type->event_date);
            $val = $val && $report->pivot->tag == 'pledge';
            return $val;
        });

        $pledge_meetings = $this->user->reports()->PledgeMeetings()->get();
        $pledge_meetings = $pledge_meetings->filter(function ($report) use ($semester) {
            $val = $semester->dateInSemester($report->report_type->event_date);
            $val = $val && $report->pivot->tag == 'pledge';
            return $val;
        });

        return $chapter_meetings->merge($exec_meetings)->merge($pledge_meetings);;
    }

    public function getDynamicThreshold()
    {
        return PledgeMeeting::currentSemester()->count();
    }

}
