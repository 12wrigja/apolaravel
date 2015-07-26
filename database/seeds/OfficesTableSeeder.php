<?php

use Illuminate\Database\Seeder;

use APOSite\Models\Office;

class OfficesTableSeeder extends Seeder
{
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        Office::truncate();
        DB::statement("SET foreign_key_checks=1");
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
