<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 7/16/15
 * Time: 10:42 PM
 */

namespace APOSite\Http\Transformers;


use APOSite\Models\ServiceEvent;
use League\Fractal\TransformerAbstract;

class ServiceEventTransformer extends TransformerAbstract{

    public function transform(ServiceEvent $event){
        $coreEventData = $this->createData(new Item($event->coreEvent,new ContractEventTransformer()));
        $hrefArr = [
            'href' => route('events_show',['id'=>$event->id]),
            ];


            $otherData = [
            'project_type' => $event->project_type,
            'service_type' => $event->service_type,
                'location' => $event->location,
                'off_campus' => (boolean)$event->off_campus
        ];
        $travelTime = ((boolean)$event->off_campus)?[
            'travel_time' => $event->travel_time
        ]:[];

        return array_merge($hrefArr,$coreEventData,$otherData,$travelTime);
    }

}