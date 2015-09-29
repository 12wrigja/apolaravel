<?php

namespace APOSite\ContractFramework\Contracts;

use APOSite\ContractFramework\Requirements\BrotherhoodHoursRequirement;
use APOSite\ContractFramework\Requirements\PledgeMemberChapterMeetingRequirement;
use APOSite\ContractFramework\Requirements\PledgeMemberDuesRequirement;
use APOSite\ContractFramework\Requirements\PledgeMemberPledgeMeetingRequirement;
use APOSite\ContractFramework\Requirements\PledgeMemberTotalHoursRequirement;
use APOSite\ContractFramework\Requirements\PledgeMemberInsideHoursRequirement;

class PledgeContract extends Contract
{
    public static $name = "Pledge Contract";

    protected function getRequirementClasses()
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
}