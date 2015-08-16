<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use APOSite\Models\Contract;
use APOSite\Models\Semester;
use APOSite\Models\User;

class OldContractStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        Contract::truncate();
        DB::statement("SET foreign_key_checks=1");
        //Import old contract names from the status tables.
        $oldContracts = DB::connection('apo')->table('tblstatus')->select('id','status')->get();
        foreach ($oldContracts as $oldContract){
            $contract = new Contract();
            $contract->id = $oldContract->id;
            $contract->display_name = $oldContract->status;
            $contract->save();
        }

        $oldUsers = DB::connection('apo')->table('tblmembers')->select('cwruID as id', 'status')->get();
        Eloquent::reguard();
        DB::statement("SET foreign_key_checks=0");
        DB::table('contract_user')->truncate();
        DB::statement("SET foreign_key_checks=1");

        DB::beginTransaction();
        $semester = Semester::currentSemester();
        foreach ($oldUsers as $oldUser) {
            $user = User::find($oldUser->id);
            if($oldUser->status != null) {
                $contract = Contract::find($oldUser->status);
                $user->contracts()->attach($contract, ['semester_id'=>$semester->id]);
                $user->save();
            }
        }
        DB::commit();
        Eloquent::unguard();
    }
}
