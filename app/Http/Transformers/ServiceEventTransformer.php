<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 7/16/15
 * Time: 10:42 PM
 */

namespace APOSite\Http\Transformers;


use APOSite\Models\ServiceEvent;
use League\Fractal\Manager;
use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Item;

class ServiceEventTransformer extends TransformerAbstract{

    protected $manager;

    function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }


    public function transform(ServiceEvent $event){
        $coreEventData = $this->manager->createData(new Item($event->coreEvent, new ContractEventTransformer()))->toArray();
        $hrefArr = [
            'href' => route('event_show',['id'=>$event->id, 'type'=>'service_events']),
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