<?php namespace APOSite\Http\Controllers;

use APOSite\Http\Requests;
use Illuminate\Console\AppNamespaceDetectorTrait;
use Illuminate\Support\Facades\Input;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;

class EventPipelineController extends Controller {

	use AppNamespaceDetectorTrait;

	protected $filterNamespace = "Models\\";

    protected $fractal;

    function __construct()
    {
        $this->fractal = new Manager();
    }


    public function showEvent($id,$type){
//        $controller = $app->make($className);
    }

	public function submitEvent($type){
        //Convert type to CamelCase and append the namespace to get the class to instantiate
		$eventType = $this->snakeToCamelCase($type);
		$modelName = $this->getAppNamespace();
		$modelName = $modelName . $this->filterNamespace;
		$modelName = $modelName . $eventType;

        //Use reflection to instantiate the class
		$method = new \ReflectionMethod($modelName,'create');
		$event = $method->invoke(null,Input::all());
		$resource = new Item($event,$event->transformer($this->fractal));
		return $this->fractal->createData($resource)->toJson();
	}

	private function snakeToCamelCase($val) {
        $val = rtrim($val,'s');
		return str_replace(' ', '', ucwords(str_replace('_', ' ', $val)));
	}

}
