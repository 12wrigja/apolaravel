<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use APOSite\Models\Office;
use APOSite\Models\User;
use APOSite\Models\Semester;

class FamilySeeder extends Seeder
{
    public function run()
    {
        $oldFamilies = DB::connection('apo')->table('tblfamilyid')->get();
        Eloquent::reguard();
        DB::beginTransaction();
        foreach ($oldFamilies as $oldFamily) {
            $newFamily = \APOSite\Models\Family::create((array)$oldFamily);
        }
        DB::commit();
        Eloquent::unguard();
    }
}
