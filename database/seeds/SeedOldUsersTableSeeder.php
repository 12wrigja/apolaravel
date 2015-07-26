<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;
use APOSite\Models\User;
class SeedOldUsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        User::truncate();
        DB::statement("SET foreign_key_checks=1");
        $oldUsers = DB::connection('apo')->table('tblmembers')->select('cwruID as id','firstName as first_name','lastName as last_name','nickName as nickname','email','phone as phone_number','address','city','state','zip as zip_code','campusResidence as campus_residence','pledgeSem as pledge_semester','initSem as initiation_semester','familyID as family_id','big','bio as biography','whyJoin as join_reason','major','minor','gradSem as graduation_semester','hometown')->get();
        Eloquent::reguard();
        DB::beginTransaction();
        foreach($oldUsers as $oldUser){
            $user = new User();


            $user->id = $oldUser->id;
            unset($oldUser->id);

            $user->pledge_semester = $oldUser->pledge_semester;
            unset($oldUser->pledge_semester);

            $user->graduation_semester = $oldUser->graduation_semester;
            unset($oldUser->graduation_semester);

            $user->big = $oldUser->big;
            unset($oldUser->big);

            $user->fill((array)$oldUser);
            $user->save();
        }
        DB::commit();
        Eloquent::unguard();
    }
}
