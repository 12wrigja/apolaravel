<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 9/24/15
 * Time: 11:54 PM
 */

namespace APOSite\ContractFramework\Requirements;

class ActiveMemberBrotherhoodHoursRequirement extends BrotherhoodHoursRequirement
{
    public static $description = "Will complete a minimum of four (4) hours of brotherhood with ALPHA PHI OMEGA each chapter semester.";

    protected $threshold = 4;
    protected $comparison = 'GEQ';

}
