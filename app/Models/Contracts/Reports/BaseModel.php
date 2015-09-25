<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 7/16/15
 * Time: 8:37 PM
 */

namespace APOSite\Models\Reports;

use APOSite\Models\Report;
use Eloquent;
use Input;
use DB;
use Exception;
use Log;
use APOSite\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Request;
use APOSite\Models\User;
use Illuminate\Database\Query\Builder as QueryBuilder;
use League\Fractal\Manager;

abstract class BaseModel extends Eloquent implements \ReportInterface
{

    public $errors;

    protected static function boot()
    {
        parent::boot();
        self::created(function($model){
            $updateMethod = 'onCreate';
            if (method_exists($model, $updateMethod)) {
                $model->$updateMethod();
            }
        });
        self::saved(function($model){
            $updateMethod = 'onUpdate';
            if (method_exists($model, $updateMethod)) {
                $model->$updateMethod();
            }
        });
    }


    public static function create(array $attributes = [])
    {
        DB::beginTransaction();
        $specific = new static($attributes);
        $coreEvent = new Report();
        $user = LoginController::currentUser();
        if (!isset($attributes['creator_id'])) {
            $attributes['creator_id'] = $user->id;
        }
        $coreEvent->fill($attributes);
        $coreEvent->save();

        $specific->save();
        $specific->core()->save($coreEvent);
        $brothers = $attributes['brothers'];
        if ($brothers != null) {
            foreach ($brothers as $index => $brother) {
                try {
                    $value = $specific->computeValue($brother);
                    $tag = $specific->getTag($brother);
                    $coreEvent->linkedUsers()->attach($brother['id'], ['value' => $value,'tag'=>$tag]);
                } catch (Exception $e) {
                    Log::error("Unable to link brother " . $brother['id'] . " to report with ID " . $coreEvent->getKey());
                    Log::error($e);
                    DB::rollBack();
                }
            }
        }
        $coreEvent->save();
        $specific->save();
        DB::commit();

        return $specific;
    }

    public function core()
    {
        return $this->morphOne('APOSite\Models\Report', 'report_type');
    }

    public function update(array $attributes = [])
    {
        $updatable = method_exists($this, 'updatable') ? $this->updatable() : array();
        foreach ($attributes as $key => $value) {
            if (in_array($key, $updatable)) {
                $this->setAttribute($key, $value);
            }
        }
        $this->save();
    }
}