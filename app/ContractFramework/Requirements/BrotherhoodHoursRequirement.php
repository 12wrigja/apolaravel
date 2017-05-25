<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 9/24/15
 * Time: 11:54 PM
 */

namespace APOSite\ContractFramework\Requirements;

class BrotherhoodHoursRequirement extends EventBasedRequirement
{
    public static $name = "Brotherhood Hours";
    public static $description = "Will complete a minimum of two (2) hours of brotherhood with ALPHA PHI OMEGA each chapter semester.";

    protected $threshold = 2;
    protected $comparison = 'GEQ';

    public function getReports()
    {
        $service_reports = $this->user->reports()->BrotherhoodReports()->get();
        $semester = $this->semester;
        $service_reports = $service_reports->filter(function ($report) use ($semester) {
            $val = $semester->dateInSemester($report->report_type->event_date);
            $val = $val && $report->report_type->approved;
            return $val;
        });
        return $service_reports;
    }

    public function getPendingReports()
    {
        $service_reports = $this->user->reports()->BrotherhoodReports()->get();
        $semester = $this->semester;
        $service_reports = $service_reports->filter(function ($report) use ($semester) {
            $val = $semester->dateInSemester($report->report_type->event_date);
            $val = $val && !$report->report_type->approved;
            return $val;
        });
        return $service_reports;
    }

}
