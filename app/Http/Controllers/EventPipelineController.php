<?php namespace APOSite\Http\Controllers;

use APOSite\Http\Requests;
use Illuminate\Console\AppNamespaceDetectorTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Input;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use Illuminate\Support\Facades\Response;

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

    public function createEvent($type)
    {
        return view('reports.' . str_replace('_', '', $type) . '.create');
    }

    public function manageEvent($type)
    {
        return view('management.' . str_replace('_', '', $type));
    }

    public function showAllEvents($type)
    {
        try {
            $class = $this->getClass($type);
            $query = $class->getMethod('query')->invoke(null);
            if (Input::has('approved')) {
                if (Input::get('approved') == 'true') {
                    $query = $query->Approved();
                } else if (Input::get('approved') == 'false') {
                    $query = $query->NotApproved();
                }
            }
            $query = $query->orderBy('id', 'DESC');
            $reports = $query->get();
            if (!$reports->isEmpty()) {
                $transformer = $reports->first()->transformer($this->fractal);
                $resource = new Collection($reports, $transformer);
                return $this->fractal->createData($resource)->toJson();
            } else {
                return Response::json([
                    'data' => []
                ], 200);
            }
        } catch (\ReflectionException $e) {
            return $e;
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

    public function updateEvent(Requests\UpdateReportRequest $request, $type, $id)
    {
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

    public function deleteEvent($type, $id){
        try {
            $report = $this->getClass($type)->getMethod('query')->invoke(null)->findOrFail($id);
            $core = $report->core;
            $report->delete();
            $core->delete();
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

}
