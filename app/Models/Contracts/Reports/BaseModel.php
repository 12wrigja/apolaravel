<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 7/16/15
 * Time: 8:37 PM
 */

namespace APOSite\Models\Reports;

use APOSite\Models\Report;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Validator;

abstract class BaseModel extends Model
{

    public $errors;

    /**
     * Listen for save event
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function($model)
        {
            return $model->validate();
        });
    }

    /**
     * Validates current attributes against rules
     *
     * @return boolean
     */
    public function validate()
    {
        $rules = property_exists($this, 'rules') ? static::$rules : array();
        $messages = property_exists($this, 'messages') ? static::$messages : array();


        if (!empty($rules))
        {
            $replace = ($this->getKey() > 0) ? $this->getKey() : null;
            foreach ($rules as $key => $rule)
            {
                $rules[$key] = str_replace(':id', $replace, $rule);
            }
            //Validate the core report first if it has been assigned
            $errors = new MessageBag();
            if($this->core != null){
                $this->core->validate();
                $coreErrors = $this->core->getErrors();
                dd($coreErrors);
                if(!$coreErrors->isEmpty()){
                    $errors = $coreErrors;
                }
            }

            //Validate the other part
            $validation = Validator::make($this->attributes, $rules, $messages);
            if ($validation->fails())
            {
                $errors = $validation->messages()->merge($errors);
            }
            $this->errors = $errors;
            if(!$errors->isEmpty()){
                return false;
            }
        }
        return true;
    }

    public static function create(array $attributes=[])
    {
        $specific = new static($attributes);
        $baseRules = property_exists($specific, 'baseRules') ? static::$baseRules : array();
        $baseMessages = property_exists($specific, 'baseMessages') ? static::$baseMessages : array();
        $coreEvent = new Report($attributes,$baseRules,$baseMessages);
        $coreEvent->validate();
        $specific->validate();
        $errors = $coreEvent->errors->merge($specific->errors);
        if($errors->isEmpty()){
            $coreEvent->save();
            $specific->save();
            $specific->core()->save($coreEvent);
        } else {
            $specific->errors = $errors;
        }
        return $specific;
    }

    public function core()
    {
        return $this->morphOne('APOSite\Models\Report', 'report_type');
    }

}