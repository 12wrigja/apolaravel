<?php namespace APOSite\Http\Requests\Reports;

use App;
use Illuminate\Console\AppNamespaceDetectorTrait;
use APOSite\Http\Controllers\LoginController;
use APOSite\Http\Requests\Request;

class ReadReportRequest extends Request
{

    use AppNamespaceDetectorTrait;

    protected $filterNamespace = "Models\\Reports\\Types\\";

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $type = $this->route('type');
        $type = $this->snakeToCamelCase($type);
        $user = LoginController::currentUser();
        try {
            return App::call($this->getAppNamespace() . $this->filterNamespace . $type . '@canRead',['user'=>$user]);
        } catch (\ReflectionException $e) {
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    public function messages()
    {
        return [];
    }


    private function snakeToCamelCase($val)
    {
        $val = rtrim($val, 's');
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $val)));
    }

}
