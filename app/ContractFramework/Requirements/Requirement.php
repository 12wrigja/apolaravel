<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 9/24/15
 * Time: 12:17 AM
 */

namespace APOSite\ContractFramework\Requirements;

use APOSite\Models\Semester;
use APOSite\Models\Users\User;

abstract class Requirement
{

    public $description;

    protected $user;
    protected $semester;
    protected $thresholdValue;
    protected $comparison;

    function __construct(User $user, Semester $semester)
    {
        $this->user = $user;
        $this->semester = $semester;
    }

    public final function isComplete()
    {
        return $this->compareAgainstThreshold($this->getValue());
    }

    public abstract function getReports();

    public abstract function getValue();

    private final function compareAgainstThreshold($value)
    {
        switch ($this->comparison) {
            case 'EQ':
                return $value == $this->thresholdValue;
            case 'GEQ':
                return $value >= $this->thresholdValue;
            case 'LEQ' :
                return $value <= $this->thresholdValue;
            case 'GE' :
                return $value > $this->thresholdValue;
            case 'LE' :
                return $value < $this->thresholdValue;
            case 'NEQ' :
                return $value != $this->thresholdValue;
            default:
                return false;
        }
    }
}
