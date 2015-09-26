<?php

use Illuminate\Database\Seeder;
use APOSite\Models\Users\Family;

class FamilySeeder extends Seeder
{
    public function run()
    {
        $oldFamilies = DB::connection('apo')->table('tblfamilyid')->get();
        Eloquent::reguard();
        DB::beginTransaction();
        foreach ($oldFamilies as $oldFamily) {
            $newFamily = Family::create((array)$oldFamily);
        }
        DB::commit();
        Eloquent::unguard();
    }
}
