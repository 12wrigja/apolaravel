<?php

namespace APOSite\Http\Requests\Users;

use APOSite\Http\Controllers\AccessController;
use Illuminate\Support\Facades\Auth;
use APOSite\Http\Requests\Request;
use APOSite\Models\Users\User;
use Illuminate\Validation\Factory as ValidationFactory;

class UserEditRequest extends Request
{

    /**
     * ContractModifyRequest constructor.
     */
    public function __construct(ValidationFactory $validationFactory)
    {
        $validationFactory->extend('semester', function ($attribute, $value, $parameters, $validator) {
            if (is_array($value) && array_key_exists('semester', $value) && array_key_exists('year', $value)) {
                $year = $value['year'];
                $semester = $value['semester'];
                $semesters = ['fall', 'spring'];
                if (is_numeric($year) && in_array($semester, $semesters)) {
                    return true;
                }
            } else {
                if ($value == 'current') {
                    return true;
                }
            }
            return false;
        },
            ":attribute is not a valid semester");
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (!Auth::check()){
            return false;
        }
        $signedInUser = Auth::user();
        $pageUser = User::find($this->route('cwruid'));
        if (($pageUser->id === $signedInUser->id) || AccessController::isWebmaster($signedInUser)) {
            return true;
        } elseif ($pageUser->isPledge() && AccessController::isPledgeEducator($signedInUser)) {
            return true;
        } else {
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
        return [
            'email' => 'sometimes|required|email',
            'pledge_semester' => 'sometimes|required|semester',
            'initiation_semester' => 'sometimes|required|semester',
            'graduation_semester' => 'sometimes|required|semester',
            'family_id' => 'sometimes|required|exists:families,id',
            'big' => 'sometimes|required|exists:users,id'
        ];
    }
}
