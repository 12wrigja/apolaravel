<?php

use Illuminate\Database\Seeder;

use APO\Models\User;
use Illuminate\Support\Facades\DB;

class SeedOldUsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        User::truncate();
        DB::statement("SET foreign_key_checks=1");
        $oldUsers = DB::connection('apo')->table('tblmembers')->select('cwruID as id','firstName as first_name','lastName as last_name','nickName as nickname','email','phone as phone_number','address','city','state','zip as zip_code','campusResidence as campus_residence','pledgeSem as pledge_semester','initSem as initiation_semester','FamilyID as family_id','big','bio as biography','whyJoin as join_reason','major','minor','gradSem as graduation_semester','hometown')->get();
        Eloquent::reguard();
        DB::beginTransaction();
        foreach($oldUsers as $oldUser){
            $user = new User();

            $user->id = $oldUser->id;
            unset($oldUser->id);

            $user->pledge_semester = $oldUser->pledge_semester;
            unset($oldUser->pledge_semester);

            $user->initiation_semester = $oldUser->initiation_semester;
            unset($oldUser->initiation_semester);

            $user->graduation_semester = $oldUser->graduation_semester;
            unset($oldUser->graduation_semester);

            $user->big = $oldUser->big;
            unset($oldUser->big);

            $user->fill((array)$oldUser);
            if($user->last_name == 'Founder'){
                $user->first_name = 'Founder';
            }
            if($user->id == 'mxm763'){
                $user->first_name = 'Meletke';
                $user->last_name = 'Melaku';
            }
            $user->save();
        }
        DB::commit();
        Eloquent::unguard();
    }
}
