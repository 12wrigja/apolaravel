<?php namespace APOSite\Http\Requests\Reports;

use Illuminate\Support\Facades\Auth;
use APOSite\Http\Requests\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Console\DetectsApplicationNamespace;

class ManageReportRequest extends Request
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
            return App::call($this->getAppNamespace() . $this->filterNamespace . $type . '@canManage',
                ['user' => $user]);
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
