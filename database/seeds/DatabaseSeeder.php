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
        $this->call('SeedOldUsersTableSeeder');
        $this->call('SemesterTableSeeder');
        $this->call('OfficesTableSeeder');
        $this->call('AllOfficersTableSeeder');
	}

}
