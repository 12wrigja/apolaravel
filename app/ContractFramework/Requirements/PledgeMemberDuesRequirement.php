<?php

namespace APOSite\ContractFramework\Requirements;

class PledgeMemberDuesRequirement extends DuesBaseRequirement
{
    public static $name = "Dues";
    public static $description = "As an APO Pledge, you are required to pay dues for the semester.";

    protected $threshold = 70;
    protected $comparison = 'GEQ';
}
