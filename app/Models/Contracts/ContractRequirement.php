<?php namespace APOSite\Models;

use Illuminate\Database\Eloquent\Model;

class ContractRequirement extends Model {

    protected $table = 'c_requirements';

    private static $comparisons = [
        'LT'=>'Less Than',
        'LEQ'=>'Less Than or Equal To',
        'EQ'=>'Equal To',
        'GEQ'=>'Greater Than or Equal To',
        'GT'=>'Greater Than'
    ];

	protected $fillable = [
        'display_name',
        'description',
        'threshold',
        'comparison'
    ];

    public function prettyComparison(){
        return ContractRequirement::$comparisons[$this->comparison];
    }

    public function SatisfyingEvents(){
        return $this->belongsToMany('APOSite\Models\Contracts\ContractEvent','c_event_c_requirement');
    }

    public function EventFilters(){
        return $this->belongsToMany('APOSite\Models\Contracts\EventFilter','c_requirement_event_filter');
    }

}
