<?php

use Illuminate\Database\Seeder;

use APOSite\Models\Semester;
use Carbon\Carbon;

class SemesterTableSeeder extends Seeder
{
    public function run()
    {
        $year = 2016;
        $time = 25;
        for($i = 0; $i<$time; $i++){
            $currentYear = $year - $i;
            $semester = new Semester;
            $semester->id = $currentYear<<1;
            $semester->year = $currentYear;
            $semester->semester = 'spring';
            if($currentYear == '2015'){
                $semester->end_date = Carbon::parse('2015-04-06');
            }
            $semester->save();

            $semester = new Semester;
            $semester->id = ($currentYear<<1)+1;
            $semester->year = $currentYear;
            $semester->semester = 'fall';
            if($currentYear == '2015'){
                $semester->start_date = Carbon::parse('2015-04-06');
            }
            $semester->save();
        }
    }
}
