<?php

namespace APOSite\Models;

use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    protected $fillable = [
        'display_name',
        'description',
        'threshold',
        'comparison'
    ] ;

    public function Contract(){
        return $this->belongsToMany('APOSite\Models\Contract');
    }

    public function Reports(){
        return $this->belongsToMany('APOSite\Models\Report');
    }

    public function Filters(){
        return $this->belongsToMany('APOSite\Models\Filter');
    }
}
