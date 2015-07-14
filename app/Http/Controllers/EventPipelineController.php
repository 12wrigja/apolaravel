<?php namespace APOSite\Http\Controllers;

use APOSite\Http\Requests;
use APOSite\Http\Controllers\Controller;
use Illuminate\Console\AppNamespaceDetectorTrait;
use Illuminate\Support\Facades\Input;

use Illuminate\Http\Request;

class EventPipelineController extends Controller {

	use AppNamespaceDetectorTrait;

	protected $filterNamespace = "Models\\";

    public function showEvent($id,$type){
        $controller = $app->make($className);
    }

	public function submitEvent($type){
		$eventType = $this->snakeToCamelCase($type);
		$modelName = $this->getAppNamespace();
		$modelName = $modelName . $this->filterNamespace;
		$modelName = $modelName . $eventType;
		$method = new \ReflectionMethod($modelName,'createEvent');
		$event = $method->invoke(null,Input::all());
		return $event;
	}

	private function snakeToCamelCase($val) {
		return str_replace(' ', '', ucwords(str_replace('_', ' ', $val)));
	}



}
