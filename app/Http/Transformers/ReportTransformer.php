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
            'id' => $event->id,
            'display_name' => $event->display_name,
            'description' => $event->description,
            'date' => $event->event_date,
            'submitter' => $event->creator_id
        ];
    }

}