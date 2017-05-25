<?php

namespace APOSite\ContractFramework\Contracts;

use APOSite\ContractFramework\Requirements\PledgeMemberChapterMeetingRequirement;
use APOSite\ContractFramework\Requirements\PledgeMemberDuesRequirement;
use APOSite\ContractFramework\Requirements\PledgeMemberInsideHoursRequirement;
use APOSite\ContractFramework\Requirements\PledgeMemberPledgeMeetingRequirement;
use APOSite\ContractFramework\Requirements\PledgeMemberTotalHoursRequirement;

class PledgeContract extends Contract
{
    public static $name = "Pledge Contract";

    public static function getRequirementClasses()
    {
        return [
            PledgeMemberPledgeMeetingRequirement::class,
            PledgeMemberChapterMeetingRequirement::class,
            PledgeMemberTotalHoursRequirement::class,
            PledgeMemberInsideHoursRequirement::class,
            PledgeMemberDuesRequirement::class
        ];
    }
}