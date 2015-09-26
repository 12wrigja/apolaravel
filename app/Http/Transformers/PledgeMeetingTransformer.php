<?php namespace APOSite\Http\Transformers;

use APOSite\Models\Contracts\Reports\Types\PledgeMeeting;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class PledgeMeetingTransformer extends TransformerAbstract
{

    protected $manager;

    function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }


    public function transform(PledgeMeeting $report)
    {
        $coreEventData = $this->manager->createData(new Item($report->core,
            new ReportTransformer()))->toArray()['data'];
        $brothers = $report->core->linkedUsers;
        $brothers->transform(function ($item, $key) {
            $val = $item->pivot;
            unset($val->report_id);
            return $val;
        });
        $otherData = [
            'minutes' => $report->minutes,
            'brothers' => $brothers
        ];
        return array_merge($coreEventData, $otherData);
    }

}