<?php

namespace APO\Contracts;

abstract class Contract {

    public $requirements = [];
    public $name;
    public $description;

    protected $requirementClasses = [];

    private $user;

    function __construct($user)
    {
        $this->user = $user;
        foreach($this->requirementClasses as $class){
            $this->requirements[] = new $class($user);
        }
    }

    public function isComplete(){
        $complete = true;
        foreach($this->requirements as $requirement){
            $complete = $complete && $requirement->isComplete();
        }
        return $complete;
    }

}