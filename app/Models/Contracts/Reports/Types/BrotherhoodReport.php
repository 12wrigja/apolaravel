<?php namespace APOSite\Models\Reports\Types;

use APOSite\Http\Controllers\AccessController;
use APOSite\Http\Transformers\BrotherhoodReportTransformer;
use APOSite\Jobs\ProcessEvent;
use APOSite\Models\Reports\BaseModel;
use APOSite\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Request;
use League\Fractal\Manager;

class BrotherhoodReport extends BaseModel
{

    protected $fillable = [
        'location',
        'type'
    ];

    public function transformer(Manager $manager)
    {
        return new BrotherhoodReportTransformer($manager);
    }

    public function computeValue(array $brotherData)
    {
        $hours = array_key_exists('hours', $brotherData) ? $brotherData['hours'] : 0;
        $minutes = array_key_exists('minutes', $brotherData) ? $brotherData['minutes'] : 0;
        return $hours * 60 + $minutes;
    }

    public function updateRules()
    {
        return [
            'approved' => ['sometimes', 'required', 'boolean']
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
        return true;
    }

    public static function applyRowLevelSecurity(QueryBuilder $query, User $user)
    {
        if (!AccessController::isMembership($user)) {
            return $query->join('report_user', 'brotherhood_reports.id', '=', 'report_user.report_id')->whereIn('report_user.report_id',function($q) use ($user){
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

    public function createRules()
    {
        $rules = [
            //Rules for the core report data
            'display_name' => ['required', 'min:10'],
            'description' => ['required', 'min:40'],
            'event_date' => ['required', 'date'],
            'location' => ['required'],
            'type'=>['required','in:fellowship,pledge,other'],
            'brothers' => ['required', 'array'],
            //Rules specific to the brotherhood report
        ];
        $extraRules = [];
        if(Request::has('brothers')) {
            foreach (Request::get('brothers') as $index => $brother) {
                $extraRules['brothers.' . $index . '.id'] = ['required', 'exists:users,id'];
                $extraRules['brothers.' . $index . '.hours'] = ['sometimes', 'required', 'integer', 'min:0'];
                $extraRules['brothers.' . $index . '.minutes'] = ['sometimes', 'required', 'integer', 'min:0','max:59'];
                //Other rules for the specific join data go here.
            }
        }
        $newRules = array_merge($rules, $extraRules);
        return $newRules;
    }

    public function errorMessages()
    {
        $messages = [
            'display_name.required'=>'The event name field is required.',
            'type.required'=>'The project type field is required.'
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

    public function updatable()
    {
        return ['approved'];
    }
}
