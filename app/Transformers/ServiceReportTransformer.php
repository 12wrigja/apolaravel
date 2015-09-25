<?php

namespace APO\Transformers;

use APO\Models\ServiceReport;
use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Item;

class ServiceReportTransformer extends TransformerAbstract
{

    public function transform(ServiceReport $report)
    {
        $brothers = $report->core->linkedUsers;
        $brothers->transform(function ($item, $key){
            $val = $item->pivot;
            unset($val->report_id);
            $val->hours = $item->value/60;
            $val->minutes = $item->value%60;
            unset($val->value);
            return $val;
        });
        $data = [
            'event_name' => $report->event_name,
            'description' => $report->description,
            'event_date' => $report->event_date,
            'creator_id' => $report->creator_id,
            'project_type' => $report->project_type,
            'service_type' => $report->service_type,
            'location' => $report->location,
            'off_campus' => (boolean)$report->off_campus,
            'travel_time' => $report->travel_time,
            'submission_date' => $report->created_at->toDateTimeString(),
            'approved' => (boolean)$report->approved,
            'brothers' => $brothers
        ];
        return $data;
    }

}