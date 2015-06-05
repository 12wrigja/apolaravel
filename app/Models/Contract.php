<?php namespace APOSite\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model {

	protected $fillable = [
        'display_name'
    ];

    public function Requirements(){
        return $this->belongsToMany('APOSite\Models\ContractRequirements');
    }

}
