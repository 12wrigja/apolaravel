<?php

use APOSite\Models\Contracts\Reports\Types\ChapterMeeting;
use APOSite\Models\Contracts\Reports\Types\ExecMeeting;
use APOSite\Models\Contracts\Reports\Types\PledgeMeeting;
use APOSite\Models\Users\User;

use Illuminate\Database\Seeder;

class OldMeetingSeeder extends Seeder
{
    public function run()
    {

        DB::reconnect();

        DB::statement("SET foreign_key_checks=0");
        ChapterMeeting::truncate();
        ExecMeeting::truncate();
        PledgeMeeting::truncate();
        DB::statement("SET foreign_key_checks=1");


        Eloquent::reguard();
        //Import old contract names from the status tables.
        DB::connection('apo')->table('tblmeetings')->select('eventID', 'date as event_date', 'type',
            'semester')->chunk(100, function ($oldMeetings) {
            foreach ($oldMeetings as $oldMeeting) {
                $brothers = [];
                $oldMeeting->creator_id = 'jow5';
                //Link users to the event
                $oldBrothers = DB::connection('apo')->table('tblattendance')->where('event',
                    $oldMeeting->eventID)->whereIn('id',User::all()->lists('id'))->get();
                foreach ($oldBrothers as $oldBrother) {
                    $brother = [];
                    $brother['id'] = $oldBrother->id;
                    $brother['count_for'] = $oldBrother->countfortag;
                    array_push($brothers, $brother);
                }
                $oldMeeting->brothers = $brothers;
                $report = null;
                switch ($oldMeeting->type) {
                    case 'chapter':
                        $report = ChapterMeeting::create((array)$oldMeeting);
                        break;
                    case 'pledge':
                        $report = PledgeMeeting::create((array)$oldMeeting);
                        break;
                    case 'exec':
                        $report = ExecMeeting::create((array)$oldMeeting);
                        continue;
                        break;
                    case 'chapter_rollover':
                        continue;
                        break;
                    case 'pledge_rollover':
                        continue;
                        break;
                    case 'other':
                        continue;
                        break;
                }
            }

        });
        Eloquent::unguard();
    }
}
