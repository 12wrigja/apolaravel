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
use APOSite\Models\Semester;
use Illuminate\Support\Facades\DB;
use Eloquent;
use Exception;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use APOSite\Models\Users\User;

abstract class BaseModel extends Eloquent implements ReportInterface
{
    protected $dates = ['created_at','updated_at','event_date','deleted_at'];

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
            BaseModel::updateBrothers($specific,$coreEvent,$brothers);
        }
        $coreEvent->save();
        $specific->save();
        DB::commit();

        return $specific;
    }

    private static function updateBrothers($specific, $coreEvent, $brothers){
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
            if ($key != 'brothers' && in_array($key, $updatable)) {
                $this->setAttribute($key, $value);
            }
        }
        if(array_key_exists('brothers',$attributes)){
            //Re-sync all brothers attached to this event.
            $core = $this->core;
            $core->linkedUsers()->detach();
            BaseModel::updateBrothers($this,$core,$attributes['brothers']);
        }
        return $this->save();
    }

    public function scopeCurrentSemester($query){
        $semester = Semester::currentSemester();
        if($semester->end_date == null){
            return $query->where('event_date','>=',$semester->start_date);
        } else {
            return $query->whereBetween('event_date', array($semester->start_date, $semester->end_date));
        }
    }

    public function setEventDateAttribute($value){
        $this->attributes['event_date'] = new Carbon($value);
    }

    public function getValueForUser(User $user){
        $pivotData = $brothers = $this->core->linkedUsers()->where('user_id',$user->id)->first();
        return $pivotData->pivot->value;
    }

    public function getTagForUser(User $user){
        $pivotData = $brothers = $this->core->linkedUsers()->where('user_id',$user->id)->first();
        return $pivotData->pivot->tag;
    }
}