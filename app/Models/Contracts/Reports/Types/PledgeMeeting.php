<?php

namespace APOSite\Models\Contracts\Reports\Types;

use APOSite\Http\Controllers\AccessController;
use APOSite\Http\Transformers\PledgeMeetingTransformer;
use APOSite\Models\Contracts\Reports\BaseModel;
use APOSite\Models\Users\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Request;
use League\Fractal\Manager;

class PledgeMeeting extends BaseModel
{

    protected $fillable = ['minutes','event_date','creator_id'];
    protected $dates = ['event_date','created_at','updated_at','deleted_at'];

    public function transformer(Manager $manager)
    {
        return new PledgeMeetingTransformer($manager);
    }

    public function computeValue(array $brotherData)
    {
        return 1;
    }

    public function getTag(array $brotherData)
    {
        return array_key_exists('count_for',$brotherData)?$brotherData['count_for']:'pledge';
    }

    public function createRules()
    {
        $rules = [
            //Rules for the core report data
            'minutes' => ['sometimes', 'required', 'min:40'],
            'event_date' => ['required', 'date'],
            'brothers' => ['required', 'array']
        ];
        $extraRules = [];
        if (Request::has('brothers')) {
            foreach (Request::get('brothers') as $index => $brother) {
                $extraRules['brothers.' . $index . '.id'] = ['required', 'exists:users,id'];
                $extraRules['brothers.' . $index . '.count_for'] = ['sometimes','required','in:chapter,pledge,exec'];
            }
        }
        $newRules = array_merge($rules, $extraRules);
        return $newRules;
    }

    public function updateRules()
    {
        $rules = [
            //Rules for the core report data
            'minutes' => ['sometimes', 'required', 'min:40'],
            'event_date' => ['sometimes','required', 'date'],
            'brothers' => ['sometimes','required', 'array']
        ];
        $extraRules = [];
        if (Request::has('brothers')) {
            foreach (Request::get('brothers') as $index => $brother) {
                $extraRules['brothers.' . $index . '.id'] = ['required', 'exists:users,id'];
                $extraRules['brothers.' . $index . '.count_for'] = ['sometimes','required','in:chapter,pledge,exec'];
            }
        }
        $newRules = array_merge($rules, $extraRules);
        return $newRules;
    }

    public function errorMessages()
    {
        $extraMessages = [];
        if (Request::has('brothers')) {
            foreach (Request::get('brothers') as $index => $brother) {
                $extraMessages['brothers.' . $index . '.id.exists'] = 'The cwru id :input is not valid.';
            }
        }
        return $extraMessages;
    }

    public function canStore(User $user)
    {
        return AccessController::isSecretary($user);
    }

    public function canManage(User $user){
        return AccessController::isMembership($user) || AccessController::isSecretary($user);
    }

    public static function applyRowLevelSecurity(QueryBuilder $query, User $user)
    {
        return $query;
        // TODO: Implement applyRowLevelSecurity() method.
    }

    public static function applyReportFilters(QueryBuilder $query)
    {
        return $query;
    }

    public function canUpdate(User $user)
    {
        return AccessController::isSecretary($user);
    }

    public function canRead(User $user)
    {
        return $user != null;
    }

    public function updatable()
    {
        return ['event_date', 'brothers','minutes'];
    }
}
