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

    public function computeForUser($user)
    {
        return Report::whereRaw('id in (select report_id from report_user where user_id = ? and report_id in (select report_id from report_requirement where requirement_id = ?))', [$user->id, $this->id]);
    }
}
