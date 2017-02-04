<?php

use APOSite\Models\Semester;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SemesterTableSeeder extends Seeder
{
    public function run()
    {
        // Start in $year
        $year = 2016;
        // And generate fake semester data for $time years around it (split evenly, rounded down)
        $time = 25;

        $startYear = $year - ($time/2);
        $previousStartDate = null;
        for ($i = 0; $i<$time; $i++) {
            $currentYear = floor($startYear + $i);
            $this->command->info('Year: '+$currentYear);
            if($previousStartDate == null){
                $previousStartDate = Carbon::parse($currentYear.'-01-01');
            }
            $currentYearStart = $previousStartDate;
            $currentYearSplit = Carbon::parse($currentYear.'-06-15');
            $currentYearEnd = Carbon::parse($currentYear.'-12-25');

            $springSemester = new Semester();
            $springSemester->id = $currentYear << 1;
            $springSemester->year = $currentYear;
            $springSemester->semester = 'spring';
            $springSemester->start_date = $currentYearStart;
            $springSemester->end_date = $currentYearSplit;

            $fallSemester = new Semester();
            $fallSemester->id = ($currentYear << 1) + 1;
            $fallSemester->year = $currentYear;
            $fallSemester->semester = 'fall';
            $fallSemester->start_date = $currentYearSplit;
            $fallSemester->end_date = $currentYearEnd;

            $springSemester->save();
            $fallSemester->save();

            $previousStartDate = $currentYearEnd;

        }
    }
}
