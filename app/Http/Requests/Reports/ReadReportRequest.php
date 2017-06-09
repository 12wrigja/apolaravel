<?php namespace APOSite\Http\Requests\Reports;

use Illuminate\Support\Facades\Auth;
use APOSite\Http\Requests\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Console\DetectsApplicationNamespace;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ReadReportRequest extends Request
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
            return App::call($this->getAppNamespace() . $this->filterNamespace . $type . '@canRead', ['user' => $user]);
        } catch (\ReflectionException $e) {
            throw new ModelNotFoundException();
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
