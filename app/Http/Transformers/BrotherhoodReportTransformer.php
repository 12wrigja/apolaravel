<?php namespace APOSite\Http\Transformers;

use APOSite\Models\Reports\ServiceReport;
use League\Fractal\Manager;
use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Item;

class BrotherhoodReportTransformer extends TransformerAbstract
{

    protected $manager;

    function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }


    public function transform(ServiceReport $report)
    {
        $id = ['id' => $report->id];
        $coreEventData = $this->manager->createData(new Item($report->core, new ReportTransformer()))->toArray()['data'];
        $hrefArr = [
            'href' => route('report_show', ['id' => $report->id, 'type' => 'service_reports']),
        ];
        $brothers = $report->core->linkedUsers;
        $brothers->transform(function ($item, $key){
            $val = $item->pivot;
            unset($val->report_id);
            return $val;
        });
        $otherData = [
            'display_name' => $report->core->display_name,
            'description' => $report->core->description,
            'event_date' => $report->core->event_date,
            'location' => $report->location,
            'type' => $report->type,
            'submission_date' => $report->created_at->toDateTimeString(),
            'brothers' => $brothers
        ];
        return array_merge($id, $hrefArr, $coreEventData, $otherData);
    }

}