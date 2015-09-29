<?php namespace APOSite\Http\Transformers;

use APOSite\Models\Contracts\Reports\Types\ExecMeeting;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class ExecMeetingTransformer extends TransformerAbstract
{

    protected $manager;

    function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }


    public function transform(ExecMeeting $report)
    {
        $brothers = $report->core->linkedUsers;
        $brothers->transform(function ($item, $key) {
            $val = $item->pivot;
            unset($val->report_id);
            unset($val->value);
            return $val;
        });
        $otherData = [
            'id' => $report->id,
            'href' => route('report_show',['id'=>$report->id,'type'=>'chapter_meetings']),
            'date' => $report->event_date->toDateString(),
            'human_date' => $report->event_date->toFormattedDateString(),
            'minutes' => $report->minutes,
            'brothers' => $brothers
        ];
        return  $otherData;
    }

}