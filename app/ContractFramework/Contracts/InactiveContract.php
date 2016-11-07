<?php

namespace APOSite\ContractFramework\Contracts;

class InactiveContract extends Contract
{
    public static $name = "Inactive Contract";

    public static $requiresReason = true;
    public static $reasonText = 'Please explain why you are going inactive this semester, or what could have been done better by the chapter.';

    public static function getRequirementClasses()
    {
        return [
        ];
    }

    public static function getOtherSigningRequirements()
    {
        return [
            'Must have been initiated into the brotherhood.',
            'Will not have any voting privileges or the ability to hold any office.',
            'Will not be required to pay dues or be subject to any other contractual obligations of an active brother.'
        ];
    }

    public static function getSigningView()
    {
        return view('contracts.signingpartials.inactive');
    }


}