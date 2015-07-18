<?php

namespace APOSite\Models;

use APOSite\Http\Transformers\ServiceEventTransformer;
use League\Fractal\Manager;

class ServiceEvent extends BaseModel
{

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }

    protected $fillable = [
        'service_type',
        'location',
        'project_type',
        'off_campus',
        'travel_time'
    ];

    public function transformer(Manager $manager){
        return new ServiceEventTransformer($manager);
    }
}
