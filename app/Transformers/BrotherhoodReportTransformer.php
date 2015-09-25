<?php

namespace APO\Transformers;

use APOSite\Models\Reports\Types\BrotherhoodReport;
use League\Fractal\Manager;
use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Item;

class BrotherhoodReportTransformer extends TransformerAbstract
{

    public function transform(BrotherhoodReport $report)
    {

        $brothers = $report->linkedUsers;
        $brothers->transform(function ($item, $key){
            $val = $item->pivot;
            unset($val->report_id);
            return $val;
        });
        $data = [
            'event_name' => $report->event_name,
            'description' => $report->core->description,
            'event_date' => $report->core->event_date,
            'location' => $report->location,
            'type' => $report->type,
            'submission_date' => $report->created_at->toDateTimeString(),
            'brothers' => $brothers
        ];
        return
    }

}