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
    public static $name;
    public static $description;

    protected $user;
    protected $semester;
    protected $threshold;
    protected $comparison;
    protected $value;
    protected $pendingValue;

    function __construct(User $user, Semester $semester)
    {
        $this->user = $user;
        $this->semester = $semester;
    }

    public static function getMetadata()
    {
        return static::$description;
    }

    public function getUser()
    {
        return $this->user;
    }

    public final function isComplete()
    {
        return $this->compareAgainstThreshold($this->getValue());
    }

    private final function compareAgainstThreshold($value)
    {
        $threshold = $this->getThreshold();

        switch ($this->comparison) {
            case 'EQ':
                return $value == $threshold;
            case 'GEQ':
                return $value >= $threshold;
            case 'LEQ' :
                return $value <= $threshold;
            case 'GE' :
                return $value > $threshold;
            case 'LE' :
                return $value < $threshold;
            case 'NEQ' :
                return $value != $threshold;
            default:
                return false;
        }
    }

    public final function getThreshold()
    {
        $threshold = $this->threshold;
        if (method_exists($this, 'getDynamicThreshold')) {
            $threshold = $this->getDynamicThreshold();
        }
        return $threshold;
    }

    public final function getValue()
    {
        if ($this->value == null) {
            $this->value = $this->computeValue();
        }
        return $this->value;
    }

    public final function getComparison(){
        return $this->comparison;
    }

    public abstract function computeValue();

    public final function getPendingValue()
    {
        if ($this->pendingValue == null) {
            $this->pendingValue = $this->computePendingValue();
        }
        return $this->pendingValue;
    }

    public function computePendingValue()
    {
        return 0.0;
    }

    public final function getPercentDone()
    {
        if ($this->getThreshold() == 0) {
            return 100;
        }
        $ratio = $this->getValue() / $this->getThreshold();
        if ($ratio >= 1) {
            return 100;
        } else {
            return intval(floor($ratio * 100));
        }
    }

    public final function getDetails($pending = false)
    {
        if ($pending) {
            return $this->getDetailsView()->with('reports', $this->getPendingReports())->with('user', $this->user);
        } else {
            return $this->getDetailsView()->with('reports', $this->getReports())->with('user', $this->user);
        }
    }

    public abstract function getDetailsView();

    public function getPendingReports()
    {
        return collect([]);
    }

    public abstract function getReports();
}
