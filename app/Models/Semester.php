<?php

namespace APOSite\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $dates = ['start_date','end_date'];

    public static function currentSemester()
    {
        return static::semesterForDate(Carbon::now());
    }

    public static function semesterForDate($date)
    {
        return Semester::whereNotNull('start_date')->where('start_date', '<=', $date)->where(function ($query) use (
            $date
        ) {
            $query->whereNull('end_date')->orWhere('end_date', '>=', $date);
        })->orderBy('start_date', 'DESC')->first();
    }

    public function next()
    {
        return Semester::find($this->id + 1);
    }

    public function dateInSemester(Carbon $date){
        $start = $this->start_date;
        $end = $this->end_date;
        if($start == null && $end == null){
            return false;
        } else {
            $gate = true;
            if($start != null){
                $gate = $gate && $start <= $date;
            } if($end != null){
                $gate = $gate && $end >= $date;
            }
            return $gate;
        }
    }

    public static function SemesterFromText($semester, $year, $shouldCreate = false){
        $base = $year << 1;
        if($semester == 'fall'){
            $base += 1;
        }
        $sem = static::find($base);
        if($sem == null && $shouldCreate){
            $newSem = new Semester();
            $newSem->id = $base;
            $newSem->semester = $semester;
            $newSem->year = $year;
            $newSem->save();
            return $newSem;
        } else {
            return $sem;
        }
    }
}
