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
//        $controller = $app->make($className);
    }

	public function submitEvent($type){
		$eventType = $this->snakeToCamelCase($type);
		$modelName = $this->getAppNamespace();
		$modelName = $modelName . $this->filterNamespace;
		$modelName = $modelName . $eventType;
		$method = new \ReflectionMethod($modelName,'createEvent');
		$event = $method->invoke(null,Input::all());
        $coreEvent = $event->coreEvent()->first();
		return $this->combineEventData($coreEvent,$event);
	}

	private function snakeToCamelCase($val) {
        $val = rtrim($val,'s');
		return str_replace(' ', '', ucwords(str_replace('_', ' ', $val)));
	}

    private function combineEventData($coreEvent,$event){
        $arr = $event->toArray();
        $arr2 = $coreEvent->toArray();
        foreach($arr2 as $key=>$value){
            if($key != 'event_type_type' && $key != 'event_type_id') {
                $arr[$key] = $value;
            }
        }
        return $arr;
    }

}
