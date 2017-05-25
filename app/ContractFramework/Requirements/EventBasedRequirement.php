<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 9/24/15
 * Time: 12:17 AM
 */

namespace APOSite\ContractFramework\Requirements;

abstract class EventBasedRequirement extends Requirement
{
    public final function getDetailsView()
    {
        return view('reports.eventlist');
    }

    public final function computeValue()
    {
        $service_reports = $this->getReports($this->semester);
        $value = 0;
        foreach ($service_reports as $report) {
            if ($report->report_type->approved) {
                $value += $report->pivot->value;
            }
        }
        return $value / 60;
    }

    public final function computePendingValue()
    {
        $service_reports = $this->getPendingReports($this->semester);
        $value = 0;
        foreach ($service_reports as $report) {
            if (!$report->report_type->approved) {
                $value += $report->pivot->value;
            }
        }
        return $value / 60;
    }
}
