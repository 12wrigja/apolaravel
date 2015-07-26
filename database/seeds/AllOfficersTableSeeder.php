<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class AllOfficersTableSeeder extends Seeder
{
    public function run()
    {
        $oldOffices = DB::connection('apo')->table('tblofficers')->select('displayOrder as display_order','Office as email','Display as display_name','type')->get();
        Eloquent::reguard();
        DB::beginTransaction();
        foreach($oldOffices as $oldOffice){
            $office = new Office();
            $office->fill((array)$oldOffice);
            $office->save();
        }
        DB::commit();
        Eloquent::unguard();
    }
}
