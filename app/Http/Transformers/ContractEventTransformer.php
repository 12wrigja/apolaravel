<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 7/16/15
 * Time: 10:38 PM
 */

namespace APOSite\Http\Transformers;


use APOSite\Models\Contract;
use APOSite\Models\ContractEvent;
use League\Fractal\TransformerAbstract;

class ContractEventTransformer extends TransformerAbstract{

    public function transform(ContractEvent $event){
        return [
          'display_name' => $event->display_name,
            'description' => $event->description,
            'date' => $event->event_date
        ];
    }

}