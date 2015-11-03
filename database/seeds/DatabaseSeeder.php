<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call('SemesterTableSeeder');
        $this->call('SeedOldUsersTableSeeder');
        $this->call('CarouselItemTableSeeder');
        $this->call('FamilySeeder');
        $this->call('OfficesTableSeeder');
        $this->call('AllOfficersTableSeeder');
        $this->call('OldContractStatusSeeder');
        $this->call('OldServiceReportsSeeder');
        $this->call('OldMeetingSeeder');
        $this->call('DuesSeeder');
    }

}
