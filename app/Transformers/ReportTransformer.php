<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 7/16/15
 * Time: 10:38 PM
 */

namespace APOSite\Http\Transformers;

use APOSite\Models\Report;
use League\Fractal\TransformerAbstract;

class ReportTransformer extends TransformerAbstract{

    public function transform(Report $event){
        return [
            'id' => $event->EventType->id,
            'href' => route('report_show',['id'=>$event->EventType->id,'type'=>$this->getReportHREF($event)]),
            'display_name' => $event->display_name,
            'description' => $event->description,
            'date' => $event->event_date,
            'submitter' => $event->creator_id
        ];
    }

    private function getReportHREF($report){
        $type = $report->report_type_type;
        $type = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $type));
        $type = substr(strrchr($type,'\\'),1)."s";
        return $type;
    }

}