<?php

use APOSite\Models\Office;
use Illuminate\Database\Seeder;

class OfficesTableSeeder extends Seeder
{
    public function run()
    {
        factory(Office::class, 10)->create();
    }
}
