<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;
use APOSite\Semester;

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
            $semester->save();

            $semester = new Semester;
            $semester->id = ($currentYear<<1)+1;
            $semester->year = $currentYear;
            $semester->semester = 'fall';
            $semester->save();
        }
    }
}
