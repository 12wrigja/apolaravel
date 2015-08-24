<?php

namespace APOSite\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use SuperClosure\Serializer;

class Requirement extends Model
{

    public static function createFromValues($display_name, $description, $threshold, $comparison, $computeFunction){
        $requirement = new Requirement;
        $requirement->display_name = $display_name;
        $requirement->description = $description;
        $requirement->threshold = $threshold;
        $requirement->comparison = $comparison;
        //$packagedFunction = App::make('EncrypterContract')->encrypt((new Serializer)->serialize($computeFunction));
        $packagedFunction = (new Serializer)->serialize($computeFunction);
        $requirement->compute_function = $packagedFunction;
        $requirement->save();
        return $requirement;
    }

    protected $fillable = [
        'display_name',
        'description',
        'threshold',
        'comparison'
    ];

    public function Contract()
    {
        return $this->belongsToMany('APOSite\Models\Contract');
    }

    public function Reports()
    {
        return $this->belongsToMany('APOSite\Models\Report');
    }

    public function Filters()
    {
        return $this->belongsToMany('APOSite\Models\Filter');
    }

    public function getReportsForUser($user, $semester = null)
    {
        $query = Report::whereRaw('id in (select report_id from report_user where user_id = ? and report_id in (select report_id from report_requirement where requirement_id = ?))', [$user->id, $this->id]);
        if($semester == null){
            return $query->get();
        } else {
            if($semester->end_date == null){
               return $query->where('event_date','>=',$semester->start_date)->get();
            } else {
                return $query->whereBetween('event_date', array($semester->start_date, $semester->end_date))->get();
            }
        }
    }

    public function getComputeFunctionAttribute($value){
        return (new Serializer())->unserialize($value);
    }

    public function computeForUser($user,$semester){

        $reports = $this->getReportsForUser($user,$semester);
        $reportValues = [];
        foreach($reports as $report){
            $reportValues[$report->id] = $report->linkedUsers()->where('user_id',$user->id)->first()->pivot->value;
        }
        $compute_fn = $this->compute_function;
        $val = $compute_fn($reports,$reportValues);
        $res = [];
        $res['value'] = $val;
        $res['passing'] = $this->isPassingForValue($val);
        return $res;
    }

    private function isPassingForValue($value){
        switch($this->comparison){
            case 'LT':
                return $value < $this->threshold;
            case 'LEQ':
                return $value <= $this->threshold;
            case 'GT':
                return $value > $this->threshold;
            case 'GEQ':
                return $value >= $this->threshold;
            case 'EQ':
                return $value == $this->threshold;
            default:
                return false;
        }
    }
}
