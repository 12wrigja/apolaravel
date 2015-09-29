<?php namespace APOSite\Http\Transformers;

use APOSite\Models\Contracts\Reports\Types\BrotherhoodReport;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class BrotherhoodReportTransformer extends TransformerAbstract
{

    protected $manager;

    function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }


    public function transform(BrotherhoodReport $report)
    {
        $brothers = $report->core->linkedUsers;
        $brothers->transform(function ($item, $key) {
            $val = $item->pivot;
            unset($val->report_id);
            $val->display_name = $item->getFullDisplayName();
            $val->hours = intval($item->pivot->value / 60);
            $val->minutes = $item->pivot->value % 60;
            unset($val->value);
            return $val;
        });
        if($report->event_date == null){
            dd($report);
        }
        $otherData = [
            'id' => $report->id,
            'href' => route('report_show',['id'=>$report->id,'type'=>'service_reports']),
            'event_name' => $report->event_name,
            'description' => $report->description,
            'date' => $report->event_date->toDateString(),
            'human_date' => $report->event_date->toFormattedDateString(),
            'submitter' => $report->creator_id,
            'event_date' => $report->event_date,
            'location' => $report->location,
            'type' => $report->type,
            'submission_date' => $report->created_at->toDateTimeString(),
            'brothers' => $brothers
        ];
        return $otherData;
    }

}