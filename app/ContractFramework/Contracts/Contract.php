<?php

namespace APOSite\ContractFramework\Contracts;

use APOSite\Models\Users\User;
use APOSite\Models\Semester;

abstract class Contract
{

    public $requirements = [];
    public static $name;
    public static $description;

    private $user;
    private $semester;

    function __construct(User $user, Semester $semester)
    {
        $this->user = $user;
        $this->semester = $semester;
        foreach ($this::getRequirementClasses() as $class) {
            $this->requirements[] = new $class($user,$semester);
        }
        $this->requirements = collect($this->requirements);
    }

    public static function getRequirementClasses()
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

    public static final function getReportTable($brothers){
        return view('contracts.tables.table')->with('contractType',static::class)->with('brothers',$brothers);
    }
}