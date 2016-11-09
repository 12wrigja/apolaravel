<?php

use Illuminate\Database\Seeder;
use APOSite\Models\Users\Family;

class FamilySeeder extends Seeder
{
    public function run()
    {
	factory(Family::class, 5)->create();
    }
}
