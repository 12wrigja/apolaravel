<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 9/25/15
 * Time: 2:32 PM
 */

namespace APOSite\ContractFramework\Contracts;

use APOSite\ContractFramework\Requirements\ActiveMemberBrotherhoodHoursRequirement;
use APOSite\ContractFramework\Requirements\ActiveMemberChapterMeetingRequirement;
use APOSite\ContractFramework\Requirements\ActiveMemberDuesRequirement;
use APOSite\ContractFramework\Requirements\ActiveMemberInsideHoursRequirement;
use APOSite\ContractFramework\Requirements\ActiveMemberPledgeMeetingRequirement;
use APOSite\ContractFramework\Requirements\ActiveMemberTotalHoursRequirement;

class ActiveV2Contract extends ActiveContract
{
    public static function getRequirementClasses()
    {
        return [
            ActiveMemberChapterMeetingRequirement::class,
            ActiveMemberPledgeMeetingRequirement::class,
            ActiveMemberTotalHoursRequirement::class,
            ActiveMemberInsideHoursRequirement::class,
            ActiveMemberDuesRequirement::class,
            ActiveMemberBrotherhoodHoursRequirement::class
        ];
    }
}