<?php

namespace APOSite\ContractFramework\Requirements;

class AssociateMemberDuesRequirement extends DuesBaseRequirement
{
    public static $name = "Dues";
    public static $description = "Will pay membership dues of one-half (1/2) an active brother's dues by the sixth (6th) chapter meeting of each academic semester, or as specifically arranged by the Treasurer.";

    protected $threshold = 35;
    protected $comparison = 'GEQ';
}
