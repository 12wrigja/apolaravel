<?php namespace APOSite\Models\Reports;

use APOSite\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use League\Fractal\Manager;
use Illuminate\Support\Facades\Request;

class BrotherhoodEvent extends BaseModel
{

    protected $fillable = [
        'location'
    ];

    public function transformer(Manager $manger)
    {
        return null;
    }

    public function computeValue(array $brotherData)
    {
        $hours = array_key_exists('hours', $brotherData) ? $brotherData['hours'] : 0;
        $minutes = array_key_exists('minutes', $brotherData) ? $brotherData['minutes'] : 0;
        return $hours * 60 + $minutes;
    }

    public function updateRules()
    {
        return array();
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
        return true;
    }

    public static function applyRowLevelSecurity(QueryBuilder $query, User $user)
    {
        return $query;
    }

    public function canUpdate(User $user)
    {
        return false;
    }

    public function canRead(User $user)
    {
        return true;
    }

    public function createRules()
    {
        $rules = [
            //Rules for the core report data
            'display_name' => ['required', 'min:10'],
            'description' => ['required', 'min:40'],
            'event_date' => ['required', 'date'],
            'brothers' => ['required', 'array'],
            //Rules specific to the brotherhood report
        ];
        $extraRules = [];
        foreach (Request::get('brothers') as $index => $brother) {
            $extraRules['brothers.' . $index . '.id'] = ['required', 'exists:users,id'];
            //Other rules for the specific join data go here.
        }
        $newRules = array_merge($rules, $extraRules);
        return $newRules;
    }

    public function errorMessages()
    {
        $messages = [
            //Error messages specific to this report type go here.
        ];
        $extraMessages = [];
        if (Request::has('brothers')) {
            foreach (Request::get('brothers') as $index => $brother) {
                $extraMessages['brothers.' . $index . '.id.exists'] = 'The cwru id :input is not valid.';
                //Error messages specific to the specific join data for this report type go here.
            }
        }
        $allMessages = array_merge($messages, $extraMessages);
        return $allMessages;
    }


    public static function applyReportFilters(Builder $query)
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

    public function updatable()
    {
        return ['approved'];
    }
}
