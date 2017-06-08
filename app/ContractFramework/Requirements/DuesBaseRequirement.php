<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 9/24/15
 * Time: 12:17 AM
 */

namespace APOSite\ContractFramework\Requirements;

use APOSite\Models\Semester;

abstract class DuesBaseRequirement extends Requirement
{
    public final function getDetailsView()
    {
        return view('reports.duesreports.dueseventlist');
    }

    public function computeValue()
    {
        $reports = $this->getReports($this->semester);
        if ($reports->isEmpty()) {
            return 0;
        } else {
            return $reports->last()->pivot->value;
        }
    }

    public function getReports()
    {
        $dues_reports = $this->user->reports()->DuesReports()->get();
        $semester = Semester::currentSemester();
        $dues_reports = $dues_reports->filter(function ($report) use ($semester) {
            $val = $semester->dateInSemester($report->report_type->report_date);
            return $val;
        });
        return $dues_reports;
    }
}
