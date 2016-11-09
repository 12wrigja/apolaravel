<?php

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
        $this->call(SemesterTableSeeder::class);
        $this->call(GlobalVariablesSeeder::class);
        $this->call(FamilySeeder::class);
        $this->call(OfficesTableSeeder::class);

    }
}
