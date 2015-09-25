<?php

use Illuminate\Database\Seeder;
use APOSite\Models\Reports\Types\ServiceReport;

class OldServiceReportsSeeder extends Seeder
{
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        ServiceReport::truncate();
        DB::statement("SET foreign_key_checks=1");

        DB::beginTransaction();
        Eloquent::reguard();
        //Import old contract names from the status tables.
        DB::connection('apo')->table('tblsvcrpt')->select('id', 'date as event_date', 'event as display_name', 'location', 'isOutside', 'offcampus as off_campus', 'traveltime as travel_time', 'comments as description', 'approved', 'serviceType as service_type', 'submittedBy as creator_id')->chunk(100, function ($oldServiceReports) {
            foreach ($oldServiceReports as $oldReport) {

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

                $brothers = [];

                //Link users to the event
                $oldBrothers = DB::connection('apo')->table('tblbroservice')->where('reportID', $oldReport->id)->get();
                foreach ($oldBrothers as $oldBrother) {
                    $brother = [];
                    $brother['id'] = $oldBrother->brotherID;
                    $brother['hours'] = floor($oldBrother->hours / 12);
                    $brother['minutes'] = ($oldBrother->hours * 5) % 60;
                    array_push($brothers, $brother);
                }
                $oldReport->brothers = $brothers;
                //Create the event
                $report = ServiceReport::create((array)$oldReport);
                if ($oldReport->approved) {
                    $report->approved = true;
                    $report->save();
                }
            }

        });
        DB::commit();
        Eloquent::unguard();
    }
}
