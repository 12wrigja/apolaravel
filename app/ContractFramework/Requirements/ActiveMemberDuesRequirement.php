<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 9/24/15
 * Time: 11:54 PM
 */

namespace APOSite\ContractFramework\Requirements;

class ActiveMemberDuesRequirement extends Requirement
{
    public static $name = "Dues";
    public static $description = "As an Active APO Brother, you are required to pay dues for the semester.";

    protected $threshold = 70;
    protected $comparison = 'GEQ';

    public function getReports()
    {
        $semester = $this->semester;

        $dues_reports = $this->user->reports()->DuesReports()->get();
        return $dues_reports->last();
    }

    public function computeValue()
    {
        $report = $this->getReports($this->semester);
        if($report != null) {
            return $report->pivot->value;
        } else {
            return 0;
        }
    }
}
