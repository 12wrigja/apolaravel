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

    public static function getOtherSigningRequirements()
    {
        return [
            'Must have been initiated into the brotherhood.',
            'Will be on leave from the university for an extended period of time for reasons including, but not limited to, co-op, study abroad, medical condition, or personal problems.',
            'Will be able to run for office in general elections for the chapter semester that the member returns from being a member-in-absentia, if that member fulfilled his or her contractual obligations for an active membership contract the chapter semester immediately prior to becoming a member-in-absentia.',
            'Will be able to carry over hours and meeting credits from the chapter semester in which the member is a member-in-absentia into the chapter semester in which the member returns from being a member-in absentia.',
            'Shall be considered active in matters pertaining to the Distinguished Service Key if the member-in-absentia returns a vote and has fulfilled his or her contractual obligations for an active membership contract the chapter semester immediately prior to becoming a member-in-absentia.'
        ];
    }

    public static function getSigningView()
    {
        return view('contracts.signingpartials.memberinabsentia');
    }


}