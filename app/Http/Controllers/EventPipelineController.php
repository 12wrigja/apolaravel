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

    public function showEvent($type,$id){
		$event = $this->getClass($type)->getMethod('query')->invoke(null)->findOrFail($id);
		$resource = new Item($event,$event->transformer($this->fractal));
		return $this->fractal->createData($resource)->toJson();
    }

	public function submitEvent($type){
		//Create and save the event
        $event = $this->getClass($type)->getMethod('create')->invoke(null,Input::all());
		$resource = new Item($event,$event->transformer($this->fractal));
		return $this->fractal->createData($resource)->toJson();
	}

	private function snakeToCamelCase($val) {
        $val = rtrim($val,'s');
		return str_replace(' ', '', ucwords(str_replace('_', ' ', $val)));
	}

	private function getClass($type){
		$eventType = $this->snakeToCamelCase($type);
		$modelName = $this->getAppNamespace();
		$modelName = $modelName . $this->filterNamespace;
		$modelName = $modelName . $eventType;
		return new \ReflectionClass($modelName);
	}
}
