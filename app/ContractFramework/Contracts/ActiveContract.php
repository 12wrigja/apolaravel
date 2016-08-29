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

    public static function getRequirementClasses()
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

    public static function getOtherSigningRequirements() {
        return [
            'Must have been initiated into the brotherhood.',
            'Will be active on at least one (1) standing committee each chapter semester.',
            'Will have full voting privileges and ability to hold any elected or appointed office.',
            'Will hold no more then one elected office at a time.',
            'Must be in good academic standing as defined by the University.'
        ];
    }

    public static function getSigningView()
    {
        return view('contracts.signingpartials.active');
    }


}