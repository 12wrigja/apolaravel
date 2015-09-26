<?php

use APOSite\Models\Semester;
use APOSite\Models\Users\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OldContractStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $oldUsers = DB::connection('apo')->table('tblmembers')->select('cwruID as id', 'status')->get();
        Eloquent::reguard();
        DB::statement("SET foreign_key_checks=0");
        DB::table('contract_user')->truncate();
        DB::statement("SET foreign_key_checks=1");

        DB::beginTransaction();
        $semester = Semester::currentSemester();
        $map = [];
        $oldStatuses = DB::connection('apo')->table('tblstatus')->select('id', 'status')->get();
        foreach ($oldStatuses as $oldStatus) {
            $map[$oldStatus->id] = $this->convertStatus($oldStatus->status);
        }
        foreach ($oldUsers as $oldUser) {
            $user = User::find($oldUser->id);
            if ($oldUser->status != null) {
                $contract = $map[$oldUser->status];
                DB::table('contract_user')->insert([
                    'user_id' => $user->id,
                    'contract_id' => $contract,
                    'semester_id' => $semester->id
                ]);
            }
        }
        DB::commit();
        Eloquent::unguard();
    }

    private function convertStatus($status)
    {
        return str_replace(' ', '', ucwords($status));
    }
}
