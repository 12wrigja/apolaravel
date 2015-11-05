<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 9/25/15
 * Time: 2:32 PM
 */

namespace APOSite\ContractFramework\Contracts;

use APOSite\ContractFramework\Requirements\BrotherhoodHoursRequirement;
use APOSite\ContractFramework\Requirements\AssociateMemberDuesRequirement;
use APOSite\ContractFramework\Requirements\AssociateMemberInsideHoursRequirement;

class AssociateContract extends Contract
{
    public static $name = "Associate Contract";
    public static function getRequirementClasses()
    {
        return [
            AssociateMemberInsideHoursRequirement::class,
            AssociateMemberDuesRequirement::class,
            BrotherhoodHoursRequirement::class
        ];
    }
}