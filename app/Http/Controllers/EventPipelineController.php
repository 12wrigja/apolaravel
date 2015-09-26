<?php namespace APOSite\Http\Controllers;

use APOSite\Http\Requests;
use APOSite\Http\Requests\Reports\ReadReportRequest;
use APOSite\Http\Requests\Reports\StoreReportRequest;
use APOSite\Http\Requests\Reports\UpdateReportRequest;
use Illuminate\Console\AppNamespaceDetectorTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

class EventPipelineController extends Controller
{

    use AppNamespaceDetectorTrait;

    protected $filterNamespace = "Models\\Reports\\Types\\";

    protected $fractal;

    function __construct()
    {
        $this->fractal = new Manager();
        $this->middleware('SSOAuth');
    }

    public function showEvent(ReadReportRequest $request, $type, $id)
    {
        try {
            $class = $this->getClass($type);
            $query = $class->getMethod('query')->invoke(null);
            $query = $class->getMethod('applyRowLevelSecurity')->invoke(null, $query, LoginController::currentUser());
            $event = $query->findOrFail($id);
            $transformer = $event->transformer($this->fractal);
            if ($transformer != null) {
                $resource = new Item($event, $transformer);
                return $this->fractal->createData($resource)->toJson();
            } else {
                return $event;
            }
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
        return view('reports.' . str_replace('_', '', $type) . '.manage');
    }

    public function showAllEvents(ReadReportRequest $request, $type)
    {
        try {
            $class = $this->getClass($type);
            $query = $class->getMethod('query')->invoke(null);
            $query = $class->getMethod('applyReportFilters')->invoke(null, $query);
            $query = $query->orderBy('id', 'DESC');
            $query = $class->getMethod('applyRowLevelSecurity')->invoke(null, $query, LoginController::currentUser());
            $paginator = $query->paginate(20);
            $queryParams = Input::except('page');
            foreach ($queryParams as $key => $value) {
                $paginator->addQuery($key, $value);
            }
            if (!$paginator->getCollection()->isEmpty()) {
                $reports = $paginator->getCollection();
                $transformer = $reports->first()->transformer($this->fractal);
                if ($transformer != null) {
                    $resource = new Collection($reports, $transformer);
                    $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));
                    return $this->fractal->createData($resource)->toJson();
                } else {
                    return $paginator;
                }
            } else {
                return Response::json([
                    'data' => []
                ], 200);
            }
        } catch (\ReflectionException $e) {
            //TODO cleanup what happens when a reflection exception is thrown. Maybe return a 404 for a not found report type?
            return $e;
        } catch (ModelNotFoundException $e) {
            //TODO Cleanup the response type here to give the correct error message, status, etc.
            return "Model not found.";
        }
    }

    public function submitEvent(StoreReportRequest $request, $type)
    {
        try {
            //Create and save the event
            $method = $this->getClass($type)->getMethod('create');
            $event = $method->invoke(null, Input::except('creator_id'), false);

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

    public function updateEvent(UpdateReportRequest $request, $type, $id)
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

    public function deleteEvent($type, $id)
    {
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
