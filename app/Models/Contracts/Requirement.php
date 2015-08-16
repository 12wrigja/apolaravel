<?php

namespace APOSite\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Requirement extends Model
{
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

    public function getReportsForUser($user)
    {
        return Report::whereRaw('id in (select report_id from report_user where user_id = ? and report_id in (select report_id from report_requirement where requirement_id = ?))', [$user->id, $this->id]);
    }

    public function computeForUser($user){
        $val = 0;
        $reports = $this->getReportsForUser($user);
        foreach($reports as $index=>$report){
            $val += $report->linkedUsers()->where('user_id',$user->id)->value;
        }
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
