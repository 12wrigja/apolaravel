<?php namespace APOSite\Http\Transformers;

use APOSite\Models\Contracts\Reports\Types\ChapterMeeting;
use League\Fractal\Manager;
use League\Fractal\TransformerAbstract;
use APOSite\Models\Users\User;

class ChapterMeetingTransformer extends TransformerAbstract
{

    protected $manager;

    function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }


    public function transform(ChapterMeeting $report)
    {
        $brothers = $report->core->linkedUsers;
        $brothers->transform(function ($item, $key) {
            $val = $item->pivot;
            unset($val->report_id);
            $val->id = $val->user_id;
            unset($val->user_id);
            $val->name = $item->getFullDisplayName();
            $val->count_for = $val->tag;
            unset($val->tag);
            return $val;
        });;
        $otherData = [
            'id' => $report->id,
            'href' => route('report_show',['id'=>$report->id,'type'=>'chapter_meetings']),
            'event_date' => $report->event_date->toDateString(),
            'human_date' => $report->event_date->toFormattedDateString(),
            'minutes' => $report->minutes,
            'brothers' => $brothers,
            'submitter' => ['id'=>$report->creator_id,'display_name'=>User::find($report->creator_id)->fullDisplayName()],
        ];
        return  $otherData;
    }

}