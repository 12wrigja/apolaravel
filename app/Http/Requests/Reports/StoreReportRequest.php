<?php

namespace APOSite\Http\Requests\Reports;

use Illuminate\Support\Facades\Auth;
use APOSite\Http\Requests\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Console\DetectsApplicationNamespace;

class StoreReportRequest extends Request
{

    use DetectsApplicationNamespace;

    protected $filterNamespace = "Models\\Contracts\\Reports\\Types\\";

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $type = $this->route('type');
        $type = $this->snakeToCamelCase($type);
        $user = Auth::user();
        try {
            return App::call($this->getAppNamespace() . $this->filterNamespace . $type . '@canStore',
                ['user' => $user]);
        } catch (\ReflectionException $e) {
            return false;
        }
    }

    private function snakeToCamelCase($val)
    {
        $val = rtrim($val, 's');
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $val)));
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
            return App::call($this->getAppNamespace() . $this->filterNamespace . $this->snakeToCamelCase($type) . '@createRules');
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

}
