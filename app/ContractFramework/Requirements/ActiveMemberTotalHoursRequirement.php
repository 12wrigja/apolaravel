<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 9/24/15
 * Time: 11:54 PM
 */

namespace APOSite\ContractFramework\Requirements;

class ActiveMemberTotalHoursRequirement extends EventBasedRequirement
{
    public static $name = "Total Service Hours";
    public static $description = "Will complete a minimum of twenty (20) hours of service each chapter semester, ten (10) of which must be completed with ALPHA PHI OMEGA.";

    protected $threshold = 20;
    protected $comparison = 'GEQ';

    public function getReports()
    {
        $service_reports = $this->user->reports()->ServiceReports()->get();
        $semester = $this->semester;
        $service_reports = $service_reports->filter(function($report) use ($semester){
            $val = $semester->dateInSemester($report->report_type->event_date);
            $val = $val && $report->report_type->approved;
            return $val;
        });
        return $service_reports;
    }

    public function getPendingReports()
    {
        $service_reports = $this->user->reports()->ServiceReports()->get();
        $semester = $this->semester;
        $service_reports = $service_reports->filter(function($report) use ($semester){
            $val = $semester->dateInSemester($report->report_type->event_date);
            $val = $val && !$report->report_type->approved;
            return $val;
        });
        return $service_reports;
    }

}
