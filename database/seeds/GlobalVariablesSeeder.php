<?php

use Illuminate\Database\Seeder;

class GlobalVariablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Clear existing variables
        \APOSite\GlobalVariable::truncate();

        //Contract signing variable
        \APOSite\GlobalVariable::create(['key'=>'contract_signing','value'=>'0']);

        \APOSite\GlobalVariable::create(['key'=>'showInactive','value'=>'0']);
    }
}
