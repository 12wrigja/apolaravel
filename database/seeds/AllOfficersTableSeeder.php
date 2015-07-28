<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use APOSite\Models\Office;
use APOSite\Models\User;
use APOSite\Models\Semester;

class AllOfficersTableSeeder extends Seeder
{
    public function run()
    {
        $semester = Semester::currentSemester();
        $oldOffices = DB::connection('apo')->table('tblofficers')->select('displayOrder as display_order', 'Office as email', 'Display as display_name', 'type', 'CurrentOfficer as co', 'NewlyElectedOfficer as no')->get();
        Eloquent::reguard();
        DB::beginTransaction();
        foreach ($oldOffices as $oldOffice) {
            $office = Office::where('display_name', $oldOffice->display_name)->first();

            if ($oldOffice->co != null || $oldOffice->co != "") {
                $currentUser = User::find($oldOffice->co);
                if ($currentUser != null) {
                    $office->users()->attach($currentUser, ['semester_id' => $semester->id, 'alt_text' => null]);
                }
            }
            if ($oldOffice->no != null || $oldOffice->no != "") {
                $newUser = User::find($oldOffice->no);
                if ($newUser != null) {
                    $office->users()->attach($newUser, ['semester_id' => $semester->next()->id, 'alt_text' => null]);
                }
            }
        }
        $oldOfficers = DB::connection('apo')->table('tblallofficers')->get();
        foreach($oldOfficers as $oldOfficer){
            $oldUser = User::find($oldOfficer->id);
            if($oldUser != null){
                $office = Office::where('display_name',$oldOfficer->position)->first();
                if($office != null){
                    $office->users()->attach($oldUser,['semester_id'=>$oldOfficer->semester,'alt_text'=>null]);
                } else {
                    DB::table('office_user')->insert(['semester_id'=>$oldOfficer->semester, 'alt_text'=>$oldOfficer->position,'user_id'=>$oldUser->id]);
                }

            }
        }
        DB::commit();
        Eloquent::unguard();
    }
}
