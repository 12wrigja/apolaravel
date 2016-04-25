<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 9/25/15
 * Time: 2:32 PM
 */

namespace APOSite\ContractFramework\Contracts;

use APOSite\ContractFramework\Requirements\AssociateMemberDuesRequirement;
use APOSite\ContractFramework\Requirements\AssociateMemberInsideHoursRequirement;
use APOSite\ContractFramework\Requirements\BrotherhoodHoursRequirement;
use APOSite\ContractFramework\Requirements\AssociateMemberChapterMeetingRequirement;

class AssociateContract extends Contract
{
    public static $name = "Associate Contract";

    public static function getRequirementClasses()
    {
        return [
            AssociateMemberInsideHoursRequirement::class,
            AssociateMemberDuesRequirement::class,
            BrotherhoodHoursRequirement::class,
            AssociateMemberChapterMeetingRequirement::class
        ];
    }

    public static function getOtherSigningRequirements()
    {
        return [
            'Must have been initiated into the brotherhood.',
            'Must have requested associate membership status and been approved by the Executive Committee.',
            'Will be permitted to hold office or vote in the next chapter general elections if they have attended at least Four regular chapter meetings during the previous chapter semester and pass membership review (see Section 13), or if they, with approval of the executive committee, have completed a minimum of twenty service hours, serve on one committee and have passed membership review (see Section 13).',
            'Will have voice but no voting privileges.'
        ];
    }


    public static function getSigningView()
    {
        return view('contracts.signingpartials.active');
    }


}