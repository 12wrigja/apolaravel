<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 9/25/15
 * Time: 2:32 PM
 */

namespace APOSite\ContractFramework\Contracts;

use APOSite\ContractFramework\Requirements\ActiveMemberChapterMeetingRequirement;
use APOSite\ContractFramework\Requirements\ActiveMemberPledgeMeetingRequirement;
use APOSite\ContractFramework\Requirements\ActiveMemberTotalHoursRequirement;
use APOSite\ContractFramework\Requirements\ActiveMemberInsideHoursRequirement;
use APOSite\ContractFramework\Requirements\ActiveMemberDuesRequirement;
use APOSite\ContractFramework\Requirements\BrotherhoodHoursRequirement;

class ActiveContract extends Contract
{
    public static $name = "Active Contract";

    protected function getRequirementClasses()
    {
        return [
            ActiveMemberChapterMeetingRequirement::class,
            ActiveMemberPledgeMeetingRequirement::class,
            ActiveMemberTotalHoursRequirement::class,
            ActiveMemberInsideHoursRequirement::class,
            ActiveMemberDuesRequirement::class,
            BrotherhoodHoursRequirement::class
        ];
    }
}