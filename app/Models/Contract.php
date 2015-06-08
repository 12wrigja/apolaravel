<?php namespace APOSite\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model {

	protected $fillable = [
        'display_name',
        'description'
    ];

    public function Requirements(){
        return $this->belongsToMany('APOSite\Models\ContractRequirement');
    }

    public function getDates(){
        return ['created_at','updated_at'];
    }

}
