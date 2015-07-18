<?php namespace APOSite\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model {

    public $timestamps = true;

    protected $hidden = ['pivot'];

	protected $fillable = [
        'display_name',
        'description'
    ];

    public function Requirements(){
        return $this->belongsToMany('APOSite\Models\Requirement');
    }

    public function getDates(){
        return ['created_at','updated_at'];
    }

}
