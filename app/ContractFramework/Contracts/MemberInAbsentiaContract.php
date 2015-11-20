<?php

namespace APOSite\ContractFramework\Contracts;

use APOSite\ContractFramework\Requirements\BrotherhoodHoursRequirement;
use APOSite\ContractFramework\Requirements\PledgeMemberChapterMeetingRequirement;
use APOSite\ContractFramework\Requirements\PledgeMemberDuesRequirement;
use APOSite\ContractFramework\Requirements\PledgeMemberPledgeMeetingRequirement;
use APOSite\ContractFramework\Requirements\PledgeMemberTotalHoursRequirement;
use APOSite\ContractFramework\Requirements\PledgeMemberInsideHoursRequirement;

class MemberInAbsentiaContract extends Contract
{
    public static $name = "Member In Absentia Contract";

    public static function getRequirementClasses()
    {
        return [
        ];
    }

}