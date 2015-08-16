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

    public function isPassing($user){
        $requirements = $this->Requirements()->get();
        $passing = true;
        foreach($requirements as $requirement){
            if(!$requirement->isPassingForUser($user)){
                return false;
            }
        }
        return true;
    }

}
