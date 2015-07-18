<?php

namespace APOSite\Models;

use League\Fractal\Manager;
use APOSite\Http\Transformers\ServiceReportTransformer;

class ServiceReport extends BaseModel
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
        return new ServiceReportTransformer($manager);
    }
}
