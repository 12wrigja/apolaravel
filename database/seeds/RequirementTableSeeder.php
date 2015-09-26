<?php

use APOSite\Models\Contract;
use APOSite\Models\Filter;
use APOSite\Models\Requirement;
use Illuminate\Database\Seeder;

class RequirementTableSeeder extends Seeder
{
    public function run()
    {
        $activeRequirements = [];
        $hoursComputation = function ($reports, $reportValues) {
            $val = 0;
            foreach ($reports as $report) {
                $val += $reportValues[$report->id];
            }
            $val /= 60;
            return $val;
        };
        //Active Member Requirements
        $activetotalhours = Requirement::createFromValues("Active Member Total Hours",
            "As an active member in APO TY, you are required to complete at least 20 hours of service each semester.",
            20, 'GEQ', function ($reports, $reportValues) {
                $val = 0;
                foreach ($reports as $report) {
                    $val += $reportValues[$report->id];
                }
                $val /= 60;
                return $val;
            });
        array_push($activeRequirements, $activetotalhours->id);
        $activeinsidehours = Requirement::createFromValues("Active Member Inside Hours",
            "As an active member in APO TY, at least 10 of the 20 hours of service each semester need to be inside service hours.",
            10, 'GEQ', function ($reports, $reportValues) {
                $val = 0;
                foreach ($reports as $report) {
                    $val += $reportValues[$report->id];
                }
                $val /= 60;
                return $val;
            });
        array_push($activeRequirements, $activeinsidehours->id);
        $activebrotherhoodhours = Requirement::createFromValues("Active Member Brotherhood Hours",
            "As an active member in APO TY, you are required to attend at least 2 hours of brotherhood events each semester.",
            2, 'GEQ', function ($reports, $reportValues) {
                $val = 0;
                foreach ($reports as $report) {
                    $val += $reportValues[$report->id];
                }
                $val /= 60;
                return $val;
            });
        array_push($activeRequirements, $activebrotherhoodhours->id);
        $activechaptermeetings = Requirement::createFromValues("Active Member Chapter Meetings",
            "As an active member in APO TY, you are required to attend at least 8 chapter meetings each semester.", 8,
            'GEQ', function ($reports, $reportValues) {
                $val = 0;
                foreach ($reports as $report) {
                    $val += $reportValues[$report->id];
                }
                return $val;
            });
        array_push($activeRequirements, $activechaptermeetings->id);
        $activepledgemeetings = Requirement::createFromValues("Active Member Pledge Meetings",
            "As an active member in APO TY, you are required to attend at least 1 pledge meeting each semester", 1,
            'GEQ', function ($reports, $reportValues) {
                $val = 0;
                foreach ($reports as $report) {
                    $val += $reportValues[$report->id];
                }
                return $val;
            });
        array_push($activeRequirements, $activepledgemeetings->id);
        $activedues = Requirement::createFromValues("Active Member Dues",
            "As an active member in APO TY, you are required to pay full dues", 70, 'EQ',
            function ($reports, $reportValues) {
                $reports->sortBy('event_date');
                if ($reports->count() > 0) {
                    $latestReport = $reports[$reports->count() - 1];
                    return $reportValues[$latestReport->id];
                } else {
                    return 0;
                }
            });
        array_push($activeRequirements, $activedues->id);

        $associateRequirements = [];
        //Associate Member Requirements
        $associatetotalhours = Requirement::createFromValues("Associate Member Total Hours",
            "As an associate member in APO TY, you are required to complete at least 10 hours of service each semester",
            10, 'GEQ', function ($reports, $reportValues) {
                $val = 0;
                foreach ($reports as $report) {
                    $val += $reportValues[$report->id];
                }
                $val /= 60;
                return $val;
            });
        array_push($associateRequirements, $associatetotalhours->id);
        $associateinsidehours = Requirement::createFromValues("Associate Member Inside Hours",
            "As an associate member in APO TY, at least 10 of the hours you complete each semester must be inside hours.",
            10, 'GEQ', function ($reports, $reportValues) {
                $val = 0;
                foreach ($reports as $report) {
                    $val += $reportValues[$report->id];
                }
                $val /= 60;
                return $val;
            });
        array_push($associateRequirements, $associateinsidehours->id);
        $associatebrotherhoodhours = Requirement::createFromValues("Associate Member Brotherhood Hours",
            "As an associate member in APO TY, you are required to attend at least 2 hours of brotherhood events each semester.",
            2, 'GEQ', function ($reports, $reportValues) {
                $val = 0;
                foreach ($reports as $report) {
                    $val += $reportValues[$report->id];
                }
                $val /= 60;
                return $val;
            });
        array_push($associateRequirements, $associatebrotherhoodhours->id);
        $associatedues = Requirement::createFromValues("Associate Member Dues",
            "As an associate member in APO TY, you are required to pay half dues", 35, 'EQ',
            function ($reports, $reportValues) {
                $reports->sortBy('event_date');
                if ($reports->count() > 0) {
                    $latestReport = $reports[$reports->count() - 1];
                    return $reportValues[$latestReport->id];
                } else {
                    return 0;
                }
            });
        array_push($associateRequirements, $associatedues->id);

        $pledgeRequirements = [];
        //Pledge Member Requirements
        $pledgetotalhours = Requirement::createFromValues("Pledge Member Total Hours",
            "As an pledge of APO TY, you are required to complete at least 10 hours of service this semester.", 10,
            'GEQ', function ($reports, $reportValues) {
                $val = 0;
                foreach ($reports as $report) {
                    $val += $reportValues[$report->id];
                }
                $val /= 60;
                return $val;
            });
        array_push($pledgeRequirements, $pledgetotalhours->id);
        $pledgeinsidehours = Requirement::createFromValues("Pledge Member Inside Hours",
            "As an pledge of APO TY, at least 8 of the 10 hours of service this semester need to be inside service hours.",
            8, 'GEQ', function ($reports, $reportValues) {
                $val = 0;
                foreach ($reports as $report) {
                    $val += $reportValues[$report->id];
                }
                $val /= 60;
                return $val;
            });
        array_push($pledgeRequirements, $pledgeinsidehours->id);
        $pledgebrotherhoodhours = Requirement::createFromValues("Pledge Member Brotherhood Hours",
            "As an pledge of APO TY, you are required to attend at least 2 hours of brotherhood events each semester.",
            2, 'GEQ', function ($reports, $reportValues) {
                $val = 0;
                foreach ($reports as $report) {
                    $val += $reportValues[$report->id];
                }
                $val /= 60;
                return $val;
            });
        array_push($pledgeRequirements, $pledgebrotherhoodhours->id);
        $pledgechaptermeetings = Requirement::createFromValues("Pledge Member Chapter Meetings",
            "As an pledge of APO TY, you are required to attend at least 2 chapter meetings each semester.", 8, 'GEQ',
            function ($reports, $reportValues) {
                $val = 0;
                foreach ($reports as $report) {
                    $val += $reportValues[$report->id];
                }
                return $val;
            });
        array_push($pledgeRequirements, $pledgechaptermeetings->id);
        $pledgepledgemeetings = Requirement::createFromValues("Pledge Member Pledge Meetings",
            "As an pledge of APO TY, you are required to attend all pledge meetings this semester", 9, 'GEQ',
            function ($reports, $reportValues) {
                $val = 0;
                foreach ($reports as $report) {
                    $val += $reportValues[$report->id];
                }
                return $val;
            });
        array_push($pledgeRequirements, $pledgepledgemeetings->id);
        $pledgedues = Requirement::createFromValues("Pledge Member Dues",
            "As an pledge of APO TY, you are required to pay full dues", 70, 'EQ', function ($reports, $reportValues) {
                $reports->sortBy('event_date');
                if ($reports->count() > 0) {
                    $latestReport = $reports[$reports->count() - 1];
                    return $reportValues[$latestReport->id];
                } else {
                    return 0;
                }
            });
        array_push($pledgeRequirements, $pledgedues->id);

        //Attach requirements to the contracts
        $activeContract = Contract::find(1);
        $associateContract = Contract::find(6);
        $pledgeContract = Contract::find(4);

        $activeContract->Requirements()->sync($activeRequirements);
        $associateContract->Requirements()->sync($associateRequirements);
        $pledgeContract->Requirements()->sync($pledgeRequirements);

        //Create and link filters to requirements
        //Service and brotherhood event filters
        $serviceEventFilter = Filter::createFromValues('Service Event Filter', 'EventFilter', 'validateServiceEvent');
        $activetotalhours->filters()->attach($serviceEventFilter->id);
        $associatetotalhours->filters()->attach($serviceEventFilter->id);
        $pledgetotalhours->filters()->attach($serviceEventFilter->id);

        $insideHourFilter = Filter::createFromValues('Inside Service Event Filter', 'EventFilter',
            'validateInsideHours');
        $activeinsidehours->filters()->attach($insideHourFilter->id);
        $associateinsidehours->filters()->attach($insideHourFilter->id);
        $pledgeinsidehours->filters()->attach($insideHourFilter->id);

        $brotherhoodEventFilter = Filter::createFromValues('Brotherhood EventFilter', 'EventFilter',
            'validateBrotherhoodEvent');
        $activeinsidehours->filters()->attach($brotherhoodEventFilter->id);
        $associateinsidehours->filters()->attach($brotherhoodEventFilter->id);
        $pledgeinsidehours->filters()->attach($brotherhoodEventFilter->id);

        //Meeting filters
        $chapterMeetingFilter = Filter::createFromValues('Chapter Meeting Filter', 'MeetingFilter',
            'validateChapterMeeting');
        $activechaptermeetings->filters()->attach($chapterMeetingFilter->id);
        $pledgechaptermeetings->filters()->attach($chapterMeetingFilter->id);

        $pledgeMeetingFilter = Filter::createFromValues('Pledge Meeting Filter', 'MeetingFilter',
            'validatePledgeMeeting');
        $activechaptermeetings->filters()->attach($pledgeMeetingFilter->id);
        $pledgechaptermeetings->filters()->attach($pledgeMeetingFilter->id);

        $execMeetingFilter = Filter::createFromValues('Exec Meeting Filter', 'MeetingFilter', 'validateExecMeeting');

        //Other Filters
        $duesFilter = Filter::createFromValues('Dues Reporting Filter', 'EventFilter', 'validateDuesEvent');
        $activedues->filters()->attach($duesFilter->id);
        $associatedues->filters()->attach($duesFilter->id);
        $pledgedues->filters()->attach($duesFilter->id);
    }
}
