<?php

namespace APOSite\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Console\AppNamespaceDetectorTrait;

class Filter extends Model
{
    use AppNamespaceDetectorTrait;

    public static function createFromValues($display_name, $controller, $method){
        $filter = new Filter();
        $filter->display_name = $display_name;
        $filter->controller = $controller;
        $filter->method = $method;
        $filter->save();
        return $filter;
    }

    protected $filterNamespace = "Http\\Controllers\\Filters\\";
    protected $fillable = [
        'display_name',
        'controller',
        'method'
    ];

    public function validate($event)
    {
        //Fill in the auto-validate call here.
        $className = $this->getAppNamespace();
        $className = $className . $this->filterNamespace;
        $className = $className . $this->controller;
        try {
            $app = app();
            //Now to call a controller and method with the given user and event
            $controller = $app->make($className);
            return $controller->callAction($this->method, [$event]);
        } catch (\ReflectionException $e) {
            return null;
        }
    }

    public function Requirement()
    {
        return $this->belongsToMany('APOSite\Models\Requirement');
    }

}
