<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 7/16/15
 * Time: 8:37 PM
 */

namespace APOSite\Models\Contracts\Reports;

use APOSite\Models\Contracts\ReportInterface;
use APOSite\Http\Controllers\LoginController;
use APOSite\Models\Contracts\Report;
use Illuminate\Support\Facades\DB;
use Eloquent;
use Exception;
use Illuminate\Support\Facades\Log;

abstract class BaseModel extends Eloquent implements ReportInterface
{

    public $errors;

    public static function create(array $attributes = [])
    {
        DB::beginTransaction();
        $specific = new static($attributes);
        $coreEvent = new Report();
        $user = LoginController::currentUser();
        if (!isset($attributes['creator_id'])) {
            $attributes['creator_id'] = $user->id;
        }
        $coreEvent->save();
        $specific->save();
        $specific->core()->save($coreEvent);
        $brothers = $attributes['brothers'];
        if ($brothers != null) {
            foreach ($brothers as $index => $brother) {
                try {
                    $value = $specific->computeValue($brother);
                    $tag = $specific->getTag($brother);
                    $coreEvent->linkedUsers()->attach($brother['id'], ['value' => $value, 'tag' => $tag]);
                } catch (Exception $e) {
                    Log::error("Unable to link brother " . $brother['id'] . " to report with ID " . $coreEvent->getKey());
                    Log::error($e);
                    throw $e;
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
        return $this->morphOne('APOSite\Models\Contracts\Report', 'report_type');
    }

    public function UUID()
    {
        return $this->core->id;
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