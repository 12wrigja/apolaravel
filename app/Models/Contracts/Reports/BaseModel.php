<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 7/16/15
 * Time: 8:37 PM
 */

namespace APOSite\Models\Reports;

use APOSite\Models\Report;
use Eloquent;
use Input;
use DB;
use Exception;
use Log;

abstract class BaseModel extends Eloquent
{

    public $errors;
    protected $rules;
    protected $messages;

//    /**
//     * Listen for save event
//     *
//     * @return void
//     */
//    public static function boot()
//    {
//        parent::boot();
//
//        static::creating(function($model)
//        {
//            return $model->validate();
//        });
//    }
//
//    /**
//     * Validates current attributes against rules
//     *
//     * @return boolean
//     */
//    public function validate()
//    {
//        $rules = property_exists($this, 'rules') ? static::$rules : array();
//        $messages = property_exists($this, 'messages') ? static::$messages : array();
//
//
//        if (!empty($rules))
//        {
//            $replace = ($this->getKey() > 0) ? $this->getKey() : null;
//            foreach ($rules as $key => $rule)
//            {
//                $rules[$key] = str_replace(':id', $replace, $rule);
//            }
//            //Validate the core report first if it has been assigned
//            $errors = new MessageBag();
//            if($this->core != null){
//                $this->core->validate();
//                $coreErrors = $this->core->getErrors();
//                dd($coreErrors);
//                if(!$coreErrors->isEmpty()){
//                    $errors = $coreErrors;
//                }
//            }
//
//            //Validate the other part
//            $validation = Validator::make($this->attributes, $rules, $messages);
//            if ($validation->fails())
//            {
//                $errors = $validation->messages()->merge($errors);
//            }
//            $this->errors = $errors;
//            if(!$errors->isEmpty()){
//                return false;
//            }
//        }
//        return true;
//    }

    public static function create(array $attributes = [])
    {
        DB::beginTransaction();
        $specific = new static($attributes);
        $coreEvent = new Report($attributes);
        $coreEvent->save();
        $specific->save();
        $specific->core()->save($coreEvent);
        $brothers = Input::get('brothers');
        foreach ($brothers as $index=>$brother) {
            try {
                $value = $specific->computeValue($brother);
                $coreEvent->linkedUsers()->attach($brother['name'],['value'=>$value]);
            } catch (Exception $e) {
                Log::error("Unable to link brother " . $brother . " to report with ID " . $coreEvent->getKey());
                DB::rollBack();
            }
        }
        $coreEvent->save();
        DB::commit();
        return $specific;
    }

    public function core()
    {
        return $this->morphOne('APOSite\Models\Report', 'report_type');
    }

    public function rules()
    {
        return $this->rules;
    }

    public function errorMessages()
    {
        return $this->messages;
    }
}