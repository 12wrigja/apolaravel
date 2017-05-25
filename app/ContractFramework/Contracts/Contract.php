<?php

namespace APOSite\ContractFramework\Contracts;

use APOSite\Models\Semester;
use APOSite\Models\Users\User;
use DB;

abstract class Contract
{

    public $requirements = [];
    public static $name;
    public static $description;

    const ContractHome = 'APOSite\ContractFramework\Contracts\\';

    private $user;
    private $semester;

    function __construct(User $user, Semester $semester)
    {
        $this->user = $user;
        $this->semester = $semester;
        foreach ($this::getRequirementClasses() as $class) {
            $this->requirements[] = new $class($user, $semester);
        }
        $this->requirements = collect($this->requirements);
    }

    public static function getRequirementClasses()
    {
        return [];
    }

    public static function getMetadata()
    {
        $metadata = [];
        $metadata['name'] = static::$name;
        $metadata['description'] = static::$description;
        $metadata['signingview'] = static::getSigningView();
        $requirements = [];
        foreach (static::getRequirementClasses() as $class) {
            if (method_exists($class, 'getMetadata')) {
                $requirementMeta = $class::getMetadata();
                if ($requirementMeta != null) {
                    $requirements[] = $requirementMeta;
                }

            }
        }
        $requirements = array_merge($requirements, static::getOtherSigningRequirements());
        $metadata['requirements'] = $requirements;
        return $metadata;
    }

    public final function isComplete()
    {
        $complete = true;
        foreach ($this->requirements as $requirement) {
            $complete = $complete && $requirement->isComplete();
        }
        return $complete;
    }

    public static final function getReportTable($brothers)
    {
        return view('contracts.tables.table')->with('contractType', static::class)->with('brothers', $brothers);
    }

    public static final function getCurrentSignableContracts()
    {
        return DB::table('contracts')->where('display_order', '>=', 0)->orderBy('display_order', 'asc')->get();
    }

    public static final function getAllContractTypes()
    {
        return DB::table('contracts')->orderBy('display_order', 'asc')->get();
    }

    public static function getOtherSigningRequirements()
    {
        return [];
    }

    public static function getSigningView()
    {
        return null;
    }

}