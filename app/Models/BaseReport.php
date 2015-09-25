<?php

namespace APO\Models;

use Illuminate\Database\Eloquent\Model;

abstract class BaseReport extends Model
{

    public function listEntry()
    {
        return $this->belongsToMany('APO\Models\User', 'report_user')->withPivot('value', 'tag');
    }

}