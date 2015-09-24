<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 9/24/15
 * Time: 12:17 AM
 */

namespace APO\Contracts\Requirements;

abstract class Requirement {

    public $description;

    protected $user;
    protected $thresholdValue;
    protected $comparison;

    function __construct($user)
    {
        $this->user = $user;
    }

    public abstract function isComplete();
}