<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 9/24/15
 * Time: 11:54 PM
 */

namespace APOSite\ContractFramework\Requirements;

class ActiveMemberTotalHoursRequirement extends Requirement
{
    public static $name = "Total Service Hours";
    public static $description = "As an Active APO Brother, you have to do at least 20 hours of service each semester.";

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

    public function computeValue()
    {
        $service_reports = $this->getReports($this->semester);
        $value = 0;
        foreach($service_reports as $report){
            if($report->report_type->approved){
                $value += $report->pivot->value;
            }
        }
        return $value / 60;
    }
}
