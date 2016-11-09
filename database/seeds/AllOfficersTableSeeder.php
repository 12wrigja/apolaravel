<?php

use APOSite\Models\Office;
use APOSite\Models\Semester;
use APOSite\Models\Users\User;
use Illuminate\Database\Seeder;

class AllOfficersTableSeeder extends Seeder
{
    public function run()
    {
        $semester = Semester::currentSemester();
       	$this->command->error('AllOfficersTableSeeder not implemented.'); 
    }
}
