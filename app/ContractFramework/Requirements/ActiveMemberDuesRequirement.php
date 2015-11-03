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
        $dues_reports = $this->user->reports()->DuesReports()->get();
        return $dues_reports;
    }

    public function computeValue()
    {
        $reports = $this->getReports($this->semester);
        if($reports->isEmpty()){
            return 0;
        } else {
            return $reports->last()->pivot->value;
        }
    }

    public function getDetails(){
        return view('reports.duesreports.dueseventlist')->with('reports',$this->getReports());
    }
}
