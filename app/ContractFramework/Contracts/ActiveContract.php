<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 9/25/15
 * Time: 2:32 PM
 */

namespace APOSite\ContractFramework\Contracts;

use APOSite\ContractFramework\Requirements\ActiveMemberTotalHoursRequirement;

class ActiveContract extends Contract
{

    protected function getRequirementClasses()
    {
        // TODO: finish implementing what classes are needed by this contract.
        return [
            ActiveMemberTotalHoursRequirement::class
        ];
    }
}