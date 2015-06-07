<?php namespace APOSite\Models;

use Illuminate\Database\Eloquent\Model;

class ContractRequirement extends Model {

	protected $fillable = [
        'display_name',
        'description',
        'threshold',
        'comparison'
    ];

}
