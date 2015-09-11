<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();
        $this->call('CarouselItemTableSeeder');
        $this->call('SemesterTableSeeder');
        $this->call('SeedOldUsersTableSeeder');
        $this->call('FamilySeeder');
        $this->call('OfficesTableSeeder');
        $this->call('AllOfficersTableSeeder');
        $this->call('OldContractStatusSeeder');
        $this->call('RequirementTableSeeder');
        $this->call('OldServiceReportsSeeder');
        $this->call('OldMeetingSeeder');
	}

}
