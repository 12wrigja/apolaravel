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

    protected $fillable = ['minutes'];

    public static function applyRowLevelSecurity(QueryBuilder $query, User $user)
    {
        return $query;
        // TODO: Implement applyRowLevelSecurity() method.
    }

    public static function applyReportFilters(QueryBuilder $query)
    {
        return $query;
    }

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
        return $brotherData['count_for'];
    }

    public function createRules()
    {
        $rules = [
            //Rules for the core report data
            'description' => ['sometimes', 'required', 'min:40'],
            'event_date' => ['required', 'date'],
            'brothers' => ['required', 'array']
        ];
        $extraRules = [];
        if (Request::has('brothers')) {
            foreach (Request::get('brothers') as $index => $brother) {
                $extraRules['brothers.' . $index . '.id'] = ['required', 'exists:users,id'];
            }
        }
        $newRules = array_merge($rules, $extraRules);
        return $newRules;
    }

    public function updateRules()
    {
        $rules = [
            'event_date' => ['sometimes', 'required'],
            'brothers' => ['sometimes', 'required', 'array']
        ];
        $extraRules = [];
        if (Request::has('brothers')) {
            foreach (Request::get('brothers') as $index => $brother) {
                $extraRules['brothers.' . $index . '.id'] = ['required', 'exists:users,id'];
            }
        }
        return array_merge($rules, $extraRules);
    }

    public function errorMessages()
    {
        $extraMessages = [
            'description.required' => 'Minutes are required.',
            'description.min:40' => 'The minutes have to be at least 40 characters long'
        ];
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

    public function canUpdate(User $user)
    {
        return AccessController::isSecretary($user);
    }

    public function canRead(User $user)
    {
        return true;
    }

    public function updatable()
    {
        return ['event_date', 'brothers'];
    }
}
