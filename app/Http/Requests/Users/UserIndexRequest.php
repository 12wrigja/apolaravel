<?php

namespace APOSite\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use APOSite\Models\Users\User;
use Illuminate\Validation\Factory as ValidationFactory;

class UserIndexRequest extends FormRequest
{
    private $requestSearchAndDisplayAttributes;

    /**
     * UserIndexRequest constructor.
     */
    public function __construct(ValidationFactory $validationFactory) {
     $validationFactory->extend('key_in', function($attribute, $value, $parameters, $validator){
        if(!is_array($parameters)) {
            return false;
        }
        return in_array($attribute, $parameters);
     });
    }


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = new User();
        $allowedSearchAttributes = $user->getFilterableAttributes();
        $searchFilterAttributes = Input::except('attrs');
        $extraAttributes = Input::get('attrs');
        $attributes = array_merge([], array_keys($searchFilterAttributes));
        if($extraAttributes != null) {
            $attributes = array_merge($attributes, explode(',', $extraAttributes));
        }
        $rules = [];
        $this->requestSearchAndDisplayAttributes = $attributes;
        foreach($attributes as $attribute) {
            $rules = array_merge($rules, [$attribute=>'key_in:'.implode(',',$allowedSearchAttributes)]);
        }
        return $rules;
    }

    public function messages()
    {
        $msgs = [];
        foreach($this->requestSearchAndDisplayAttributes as $attribute) {
               $msgs = array_merge($msgs, [$attribute.'.key_in'=>'The attribute :attribute is invalid.']);
        }
        return $msgs;
    }
}
