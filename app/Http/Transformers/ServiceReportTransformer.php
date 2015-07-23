<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 7/16/15
 * Time: 10:42 PM
 */

namespace APOSite\Http\Transformers;


use APOSite\Models\Reports\ServiceReport;
use League\Fractal\Manager;
use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Item;

class ServiceReportTransformer extends TransformerAbstract{

    protected $manager;

    function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }


    public function transform(ServiceReport $report){
        $id = ['id'=>$report->id];
        $coreEventData = $this->manager->createData(new Item($report->core, new ReportTransformer()))->toArray()['data'];
        $hrefArr = [
            'href' => route('report_show',['id'=>$report->id, 'type'=>'service_reports']),
        ];
        $otherData = [
            'project_type' => $report->project_type,
            'service_type' => $report->service_type,
            'location' => $report->location,
            'off_campus' => (boolean)$report->off_campus,
            'travel_time' => $report->travel_time,
            'submission_date'=>$report->created_at->toDateTimeString()
        ];
        return array_merge($id,$hrefArr,$coreEventData,$otherData);
    }

}