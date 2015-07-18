<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 7/16/15
 * Time: 8:37 PM
 */

namespace APOSite\Models;

use Illuminate\Database\Eloquent\Model;
use League\Fractal\Manager;

abstract class BaseModel extends Model
{

    public $transformer;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }


    public static function create(array $attributes=[])
    {
        $specific = parent::create($attributes);
        $coreEvent = Report::create($attributes);
        $coreEvent->EventType()->associate($specific);
        $coreEvent->save();
        return $specific;
    }


    public function coreEvent()
    {
        return $this->morphOne('APOSite\Models\Report', 'report_type');
    }

}