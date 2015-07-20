<?php namespace APOSite\Http\Requests;

use App;
use Illuminate\Console\AppNamespaceDetectorTrait;

class StoreReportRequest extends Request
{

    use AppNamespaceDetectorTrait;

    protected $filterNamespace = "Models\\Reports\\";

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
        return App::call($this->getAppNamespace() . $this->filterNamespace . $this->snakeToCamelCase($type) . '@rules');
    }

    public function messages()
    {
        $type = $this->route('type');
        return App::call($this->getAppNamespace() . $this->filterNamespace . $this->snakeToCamelCase($type) . '@errorMessages');
    }


    private function snakeToCamelCase($val)
    {
        $val = rtrim($val, 's');
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $val)));
    }

}
