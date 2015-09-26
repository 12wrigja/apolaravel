<?php

namespace APOSite\ContractFramework\Contracts;

use APOSite\Models\Users\User;
use APOSite\Models\Semester;

abstract class Contract
{

    public $requirements = [];
    public $name;
    public $description;

    private $user;
    private $semester;

    function __construct(User $user, Semester $semester)
    {
        $this->user = $user;
        $this->semester = $semester;
        foreach ($this->getRequirementClasses() as $class) {
            $this->requirements[] = new $class($user,$semester);
        }
    }

    protected function getRequirementClasses()
    {
        return [];
    }

    public final function isComplete()
    {
        $complete = true;
        foreach ($this->requirements as $requirement) {
            $complete = $complete && $requirement->isComplete();
        }
        return $complete;
    }

}