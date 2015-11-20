<?php

namespace APOSite\ContractFramework\Contracts;

use APOSite\ContractFramework\Requirements\BrotherhoodHoursRequirement;
use APOSite\ContractFramework\Requirements\PledgeMemberChapterMeetingRequirement;
use APOSite\ContractFramework\Requirements\PledgeMemberDuesRequirement;
use APOSite\ContractFramework\Requirements\PledgeMemberPledgeMeetingRequirement;
use APOSite\ContractFramework\Requirements\PledgeMemberTotalHoursRequirement;
use APOSite\ContractFramework\Requirements\PledgeMemberInsideHoursRequirement;

class InactiveContract extends Contract
{
    public static $name = "Inactive Contract";

    public static function getRequirementClasses()
    {
        return [
        ];
    }

}