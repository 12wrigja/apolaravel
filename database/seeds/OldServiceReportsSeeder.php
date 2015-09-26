<?php

use APOSite\Models\Contracts\Reports\Types\ServiceReport;
use APOSite\Models\Contracts\Report;
use Illuminate\Database\Seeder;
use APOSite\Models\Users\User;

class OldServiceReportsSeeder extends Seeder
{
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        ServiceReport::truncate();
        DB::statement("SET foreign_key_checks=1");

        DB::beginTransaction();
        $userList = User::all()->lists('id');
        //Import old contract names from the status tables.
        DB::connection('apo')->table('tblsvcrpt')->select('id', 'date as event_date', 'event as event_name',
            'location', 'isOutside', 'offcampus as off_campus', 'traveltime as travel_time', 'comments as description',
            'approved', 'serviceType as service_type', 'submittedBy as creator_id')->chunk(100,
            function ($oldServiceReports) use ($userList) {
                foreach ($oldServiceReports as $oldReport) {
                    $this->command->info('Processing report with id: '.$oldReport->id);
                    if ($oldReport->description == null) {
                        $oldReport->description = "";
                    }

                    //transform the isoutside column to the new project_type column
                    if ($oldReport->isOutside) {
                        $oldReport->project_type = 'outside';
                    } else {
                        $oldReport->project_type = 'inside';
                    }
                    unset($oldReport->isOutside);

                    //Transform the serviceType column to use the enum instead of numbers
                    switch ($oldReport->service_type) {
                        case 0:
                            $oldReport->service_type = 'chapter';
                            break;
                        case 1:
                            $oldReport->service_type = 'campus';
                            break;
                        case 2:
                            $oldReport->service_type = 'community';
                            break;
                        case 3:
                            $oldReport->service_type = 'country';
                            break;
                        default:
                            break;
                    }

                    //Create the event
                    $svcrpt = new ServiceReport((array)$oldReport);
                    $report = new Report();
                    $report->id = $oldReport->id;
                    $report->EventType()->associate($svcrpt);
                    $svcrpt->save();
                    $report->save();

                    //Link users to the event
                    $oldBrothers = DB::connection('apo')->table('tblbroservice')->where('reportID',
                        $oldReport->id)->whereIn('brotherID',$userList)->get();
                    foreach ($oldBrothers as $oldBrother) {
                        $brother = [];
                        $brother['id'] = $oldBrother->brotherID;
                        $hours = floor($oldBrother->hours / 12);
                        $minutes = ($oldBrother->hours * 5) % 60;
                        DB::table('report_user')->insert(['report_id'=>$report->id,'user_id'=>$oldBrother->brotherID,'value'=>($hours*60+$minutes),'tag'=>null]);
                    }
                }
            });
        DB::commit();
    }
}
