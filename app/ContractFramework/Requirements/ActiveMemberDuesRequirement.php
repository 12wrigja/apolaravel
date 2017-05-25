<?php

namespace APOSite\ContractFramework\Requirements;

class ActiveMemberDuesRequirement extends DuesBaseRequirement
{
    public static $name = "Dues";
    public static $description = "Will pay membership dues by the sixth (6th) chapter meeting of each academic semester or as specifically arranged by the treasurer.";

    protected $threshold = 70;
    protected $comparison = 'GEQ';
}
