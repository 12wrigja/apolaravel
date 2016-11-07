<?php namespace APOSite\Http\Transformers;


use APOSite\Models\Contracts\Reports\Types\DuesReport;
use League\Fractal\Manager;
use League\Fractal\TransformerAbstract;

class DuesReportTransformer extends TransformerAbstract
{

    protected $manager;

    function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }


    public function transform(DuesReport $report)
    {
        $brothers = $report->core->linkedUsers;
        $brothers->transform(function ($item, $key) {
            $val = $item->pivot;
            unset($val->report_id);
            $val->id = $val->user_id;
            return $val;
        });
        $otherData = [
            'id' => $report->id,
            'href' => route('report_show', ['id' => $report->id, 'type' => 'service_reports']),
            'report_date' => $report->report_date->toDateString(),
            'human_date' => $report->report_date->toFormattedDateString(),
            'submitter' => $report->creator_id,
            'brothers' => $brothers
        ];
        return $otherData;
    }

}