<?php namespace APOSite\Http\Transformers;

use APOSite\Models\Contracts\Reports\Types\ServiceReport;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class ServiceReportTransformer extends TransformerAbstract
{

    protected $manager;

    function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }


    public function transform(ServiceReport $report)
    {
        $coreEventData = $this->manager->createData(new Item($report->core,
            new ReportTransformer()))->toArray()['data'];
        $brothers = $report->core->linkedUsers;
        $brothers->transform(function ($item, $key) {
            $val = $item->pivot;
            unset($val->report_id);
            $val->hours = $item->value / 60;
            $val->minutes = $item->value % 60;
            unset($val->value);
            return $val;
        });
        $otherData = [
            'project_type' => $report->project_type,
            'service_type' => $report->service_type,
            'location' => $report->location,
            'off_campus' => (boolean)$report->off_campus,
            'travel_time' => $report->travel_time,
            'submission_date' => $report->created_at->toDateTimeString(),
            'brothers' => $brothers
        ];
        return array_merge($coreEventData, $otherData);
    }

}