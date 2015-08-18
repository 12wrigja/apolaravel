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

    public static function create(array $attributes = [])
    {
        DB::beginTransaction();
        $specific = new static($attributes);
        $coreEvent = new Report();
        $user = LoginController::currentUser();
        if (!isset($attributes['creator_id'])) {
            $attributes['creator_id'] = LoginController::currentUser()->id;
        }

        $coreEvent->fill($attributes);
        $coreEvent->save();
        $specific->save();
        $specific->core()->save($coreEvent);
        $brothers = Input::get('brothers');
        if ($brothers != null) {
            foreach ($brothers as $index => $brother) {
                try {
                    $value = $specific->computeValue($brother);
                    $coreEvent->linkedUsers()->attach($brother['id'], ['value' => $value]);
                } catch (Exception $e) {
                    Log::error("Unable to link brother " . $brother['id'] . " to report with ID " . $coreEvent->getKey());
                    DB::rollBack();
                }
            }
        }
        $coreEvent->save();
        $specific->save();
        DB::commit();
        $updateMethod = 'onCreate';
        if (method_exists($specific, $updateMethod)) {
            $specific->$updateMethod();
        }
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
        $updateMethod = 'onUpdate';
        if (method_exists($this, $updateMethod)) {
            $this->$updateMethod();
        }
    }
}