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
        // Core backing data.
        $this->call(SemesterTableSeeder::class);
        $this->call(GlobalVariablesSeeder::class);
        $this->call(OfficesTableSeeder::class);

        // User Base Data
        $this->call(FamilySeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
