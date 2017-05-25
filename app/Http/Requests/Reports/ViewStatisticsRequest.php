<?php namespace APOSite\Http\Requests\Reports;

use APOSite\Http\Controllers\AccessController;
use Illuminate\Support\Facades\Auth;
use APOSite\Http\Requests\Request;

class ViewStatisticsRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(!Auth::check()){
            return false;
        }
        $user = Auth::user();
        return AccessController::isMembership($user);
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

}
