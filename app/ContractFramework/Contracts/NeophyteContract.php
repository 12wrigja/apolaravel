<?php

namespace APOSite\ContractFramework\Contracts;

use APOSite\ContractFramework\Requirements\BrotherhoodHoursRequirement;
use APOSite\ContractFramework\Requirements\PledgeMemberChapterMeetingRequirement;
use APOSite\ContractFramework\Requirements\PledgeMemberDuesRequirement;
use APOSite\ContractFramework\Requirements\PledgeMemberPledgeMeetingRequirement;
use APOSite\ContractFramework\Requirements\PledgeMemberTotalHoursRequirement;
use APOSite\ContractFramework\Requirements\PledgeMemberInsideHoursRequirement;

class NeophyteContract extends Contract
{
    public static $name = "Neophyte Contract";

    public static function getRequirementClasses()
    {
        return [
            PledgeMemberPledgeMeetingRequirement::class,
            PledgeMemberChapterMeetingRequirement::class,
            PledgeMemberTotalHoursRequirement::class,
            PledgeMemberInsideHoursRequirement::class,
            PledgeMemberDuesRequirement::class,
            BrotherhoodHoursRequirement::class
        ];
    }

    public static function getReportTable($brothers)
    {
        return "";
    }


}