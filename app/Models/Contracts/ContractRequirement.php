<?php namespace APOSite\Models;

use Illuminate\Database\Eloquent\Model;

class ContractRequirement extends Model {

    protected $table = 'c_requirements';

    protected $touches = ['Contract'];

    protected $hidden = ['pivot'];

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

    public function Contract(){
        return $this->belongsToMany('APOSite\Models\Contract','contract_c_requirement','c_requirement_id');
    }

    public function prettyComparison(){
        return ContractRequirement::$comparisons[$this->comparison];
    }

    public function SatisfyingEvents(){
        return $this->belongsToMany('APOSite\Models\ContractEvent','c_event_c_requirement','c_requirement_id');
    }

    public function EventFilters(){
        return $this->hasMany('APOSite\Models\EventFilter','c_requirement_id');
    }

}
