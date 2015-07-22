<?php namespace APOSite\Http\Controllers;

use APOSite\Http\Requests;
use Illuminate\Console\AppNamespaceDetectorTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Input;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use App;

class EventPipelineController extends Controller
{

    use AppNamespaceDetectorTrait;

    protected $filterNamespace = "Models\\Reports\\";

    protected $fractal;

    function __construct()
    {
        $this->fractal = new Manager();
    }

    public function showEvent($type, $id)
    {
        try {
            $event = $this->getClass($type)->getMethod('query')->invoke(null)->findOrFail($id);
            $resource = new Item($event, $event->transformer($this->fractal));
            return $this->fractal->createData($resource)->toJson();
        } catch (\ReflectionException $e) {
            return "Reflection issue.";
        } catch (ModelNotFoundException $e) {
            return "Model not found.";
        }
    }

    public function submitEvent(Requests\StoreReportRequest $request, $type)
    {
        try {
            //Create and save the event
            $method = $this->getClass($type)->getMethod('create');
            $event = $method->invoke(null, Input::all(), false);

            //Return the data in json form
            $resource = new Item($event, $event->transformer($this->fractal));
            return $this->fractal->createData($resource)->toJson();
        } catch (\ReflectionException $e) {
            return $e;
//            return Response::json([
//                'general_error'=>'Unable to process request.'
//            ],422);
        }
    }

    public function updateEvent(Requests\UpdateReportRequest $request, $type, $id){
        try {
            $report = $this->getClass($type)->getMethod('query')->invoke(null)->findOrFail($id);
            $report->update(Input::all());
            //Return the data in json form
            return "Success";
        } catch (\ReflectionException $e) {
            return $e;
//            return Response::json([
//                'general_error'=>'Unable to process request.'
//            ],422);
        }
    }

    private function snakeToCamelCase($val)
    {
        $val = rtrim($val, 's');
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $val)));
    }

    private function getClass($type)
    {
        $eventType = $this->snakeToCamelCase($type);
        $modelName = $this->getAppNamespace();
        $modelName = $modelName . $this->filterNamespace;
        $modelName = $modelName . $eventType;
        $class = new \ReflectionClass($modelName);
        return $class;
    }

    private function snakeToSpace($type)
    {
        return str_replace('_', ' ', $type);
    }
}
