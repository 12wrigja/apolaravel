<?php

namespace APOSite\Models\Reports\Types;

use APOSite\Http\Controllers\AccessController;
use APOSite\Jobs\ProcessEvent;
use APOSite\Models\Reports\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use League\Fractal\Manager;
use APOSite\Http\Transformers\ServiceReportTransformer;
use Request;
use Illuminate\Support\Facades\Queue;
use APOSite\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Input;

class ServiceReport extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'service_type',
        'location',
        'project_type',
        'off_campus',
        'travel_time'
    ];

    public function transformer(Manager $manager)
    {
        return new ServiceReportTransformer($manager);
    }

    public function computeValue(array $brotherData)
    {
        $hours = array_key_exists('hours', $brotherData) ? $brotherData['hours'] : 0;
        $minutes = array_key_exists('minutes', $brotherData) ? $brotherData['minutes'] : 0;
        return $hours * 60 + $minutes;
    }

    public function createRules()
    {
        $rules = [
            //Rules for the core report data
            'display_name' => ['required', 'min:10'],
            'description' => ['required', 'min:40'],
            'event_date' => ['required', 'date'],
            'brothers' => ['required', 'array'],
            //Rules specific to the service report
            'location' => ['required', 'min:10'],
            'service_type' => ['required', 'in:chapter,country,community,campus'],
            'project_type' => ['required', 'in:inside,outside'],
            'off_campus' => ['required', 'boolean'],
            'travel_time' => ['required_if:off_campus,true', 'integer']
        ];
        $extraRules = [];
        if(Request::has('brothers')) {
            foreach (Request::get('brothers') as $index => $brother) {
                $extraRules['brothers.' . $index . '.id'] = ['required', 'exists:users,id'];
                $extraRules['brothers.' . $index . '.hours'] = ['sometimes', 'required', 'integer', 'min:0'];
                $extraRules['brothers.' . $index . '.minutes'] = ['sometimes', 'required', 'integer', 'min:0','max:59'];
            }
        }
        $newRules = array_merge($rules, $extraRules);
        return $newRules;
    }

    public function updateRules()
    {
        return [
            'approved' => ['sometimes', 'required', 'boolean']
        ];
    }

    public function errorMessages()
    {
        $messages = [
            'off_campus.in' => 'off_campus should be either true or false',
            'travel_time' => 'travel time is required if the event is off-campus'
        ];
        $extraMessages = [];
        if (Request::has('brothers')) {
            foreach (Request::get('brothers') as $index => $brother) {
                $extraMessages['brothers.' . $index . '.id.exists'] = 'The cwru id :input is not valid.';
            }
        }
        $allMessages = array_merge($messages, $extraMessages);
        return $allMessages;
    }

    public function updatable()
    {
        return [
            'approved'
        ];
    }

    public function onCreate()
    {
    }

    public function onUpdate()
    {
        if ($this->approved) {
            $event = new ProcessEvent($this->id, get_class($this));
            Queue::push($event);
        }
    }

    public function canStore(User $user)
    {
        if ($user != null) {
            return true;
        } else {
            return false;
        }
    }

    public static function applyRowLevelSecurity(QueryBuilder $query, User $user)
    {
        if (!AccessController::isMembership($user)) {
            return $query->join('report_user', 'service_reports.id', '=', 'report_user.report_id')->whereIn('report_user.report_id',function($q) use ($user){
                $q->select('id')->from('reports')->where('report_user.report_id','id')->orWhere('reports.creator_id', $user->id);
            });
        } else {
            return $query;
        }
    }

    public function canUpdate(User $user)
    {
        if ($user != null && AccessController::isMembership($user)) {
            return true;
        } else {
            return false;
        }
    }

    public function canRead(User $user)
    {
        //Add in logic so not everyone can see the service reports that aren't theirs unless they are the service? vp or webmaster.
        if ($user != null) {
            return true;
        } else {
            return false;
        }
    }

    public function scopeNotApproved(QueryBuilder $query)
    {
        return $query->whereApproved(false);
    }

    public function scopeApproved(QueryBuilder $query)
    {
        return $query->whereApproved(true);
    }

    public static function applyReportFilters(QueryBuilder $query)
    {
        if (Input::has('approved')) {
            if (Input::get('approved') == 'true') {
                $query = $query->Approved();
            } else if (Input::get('approved') == 'false') {
                $query = $query->NotApproved();
            }
        }
        return $query;
    }
}
