<?php

use Illuminate\Database\Seeder;

use APOSite\Models\Semester;

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
