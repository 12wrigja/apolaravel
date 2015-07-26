<?php

namespace APOSite\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Semester extends Model
{
    public static function semesterForDate($date){
        return Semester::whereNotNull('start_date')->where('start_date','<=',$date)->where(function($query) use ($date){
           $query->whereNull('end_date')->orWhere('end_date','>=',$date);
        })->orderBy('start_date','DESC')->first();
    }

    public static function currentSemester(){
        return static::semesterForDate(Carbon::now());
    }
}
