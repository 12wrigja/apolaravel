<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 9/24/15
 * Time: 11:54 PM
 */

namespace APOSite\ContractFramework\Requirements;

class ActiveMemberPledgeMeetingRequirement extends MeetingBasedRequirement
{
    public static $name = "Pledge Meetings";
    public static $description = "Will attend at least one pledge meeting each chapter semester, unless excused by the Executive Committee.";

    protected $threshold = 1;
    protected $comparison = 'GEQ';

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

}
