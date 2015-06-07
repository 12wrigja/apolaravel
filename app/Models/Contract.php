<?php namespace APOSite\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model {

	protected $fillable = [
        'display_name',
        'description'
    ];

    protected static $rules = [
        'display_name'=>['required','min:10'],
        'description'=>['required','min:40']
    ];

    public function Requirements(){
        return $this->belongsToMany('APOSite\Models\ContractRequirement');
    }

}
