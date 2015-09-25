<?php

namespace APO\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceReport extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'event_name',
        'description',
        'event_date',
        'service_type',
        'location',
        'project_type',
        'off_campus',
        'travel_time'
    ];

    public static function create(array $attributes = [])
    {
        $base = parent::create($attributes);
        if (array_key_exists('brothers', $attributes)) {
            foreach ($attributes['brothers'] as $brotherData) {
                $hours = array_key_exists('hours', $brotherData) ? $brotherData['hours'] : 0;
                $minutes = array_key_exists('minutes', $brotherData) ? $brotherData['minutes'] : 0;
                $value = $hours * 60 + $minutes;
                $tag = array_key_exists('tag', $brotherData) ? $brotherData['tag'] : null;
                $base->linkedBrothers()->attach($brotherData->id, ['value' => $value, 'tag' => $tag]);
            }
        }
        return $base;
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
        if (Request::has('brothers')) {
            foreach (Request::get('brothers') as $index => $brother) {
                $extraRules['brothers.' . $index . '.id'] = ['required', 'exists:users,id'];
                $extraRules['brothers.' . $index . '.hours'] = ['sometimes', 'required', 'integer', 'min:0'];
                $extraRules['brothers.' . $index . '.minutes'] = ['sometimes', 'required', 'integer', 'min:0', 'max:59'];
            }
        }
        $newRules = array_merge($rules, $extraRules);
        return $newRules;
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

    public static function applyRowLevelSecurity(QueryBuilder $query, User $user)
    {
        if (!AccessController::isMembership($user)) {
            return $query->join('report_user', 'service_reports.id', '=', 'report_user.report_id')->whereIn('report_user.report_id', function ($q) use ($user) {
                $q->select('id')->from('reports')->where('report_user.report_id', 'id')->orWhere('reports.creator_id', $user->id);
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

    public function linkedBrothers()
    {

    }
}
