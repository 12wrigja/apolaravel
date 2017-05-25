<?php

use APOSite\Models\Users\Family;
use Illuminate\Database\Seeder;

class FamilySeeder extends Seeder
{
    public function run()
    {
        factory(Family::class, 5)->create();
    }
}
