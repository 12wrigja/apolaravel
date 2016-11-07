<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 9/24/15
 * Time: 11:54 PM
 */

namespace APOSite\ContractFramework\Requirements;

use APOSite\Models\Semester;

class AssociateMemberDuesRequirement extends DuesBaseRequirement
{
    public static $name = "Dues";
    public static $description = "Will pay membership dues of one-half (1/2) an active brother's dues by the sixth (6th) chapter meeting of each academic semester, or as specifically arranged by the Treasurer.";

    protected $threshold = 35;
    protected $comparison = 'GEQ';

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
