<?php namespace APOSite\Http\Requests\Reports;

use APOSite\Http\Requests\Request;
use App;
use Illuminate\Console\AppNamespaceDetectorTrait;

class UpdateReportRequest extends Request
{

    use AppNamespaceDetectorTrait;

    protected $filterNamespace = "Models\\Contracts\\Reports\\Types\\";

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $type = $this->route('type');
        try {
            return App::call($this->getAppNamespace() . $this->filterNamespace . $this->snakeToCamelCase($type) . '@updateRules');
        } catch (\ReflectionException $e) {
            return [];
        }
    }

    public function messages()
    {
        $type = $this->route('type');
        try {
            return App::call($this->getAppNamespace() . $this->filterNamespace . $this->snakeToCamelCase($type) . '@errorMessages');
        } catch (\ReflectionException $e) {
            return [];
        }
    }


    private function snakeToCamelCase($val)
    {
        $val = rtrim($val, 's');
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $val)));
    }

}
