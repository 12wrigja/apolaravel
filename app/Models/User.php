<?php namespace APOSite\Models;

use APOSite\Http\Controllers\AccessController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class User extends Model{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tblmembers';
	
	protected $primaryKey = 'cwruID';
	
	public $timestamps = false;
	
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('biggable','bro2bro','deleteMe','emailchapterminutes','emailpledgeminutes','emailexecminutes','timestamp');	

	public function status(){
		return $this->belongsTo('MemberStatus','status');
	}
	
	public function scopeCollegians($query){
		return $query->where('status','in','(1,4,5,6,7)');
	}
	
	public function scopeActive($query){
		return $query->where('status','=','1');
	}
	
	public function scopeAssociate($query){
		return $query->where('status','=','6');
	}
	
	public function scopePledge($query){
		return $query->where('status','=','4');
	}
	
	public function scopeNeophyte($query){
		return $query->where('status','=','5');
	}
	
	public function scopeAlumni($query){
		return $query->where('status','in','(8,9)');
	}
	
	public function scopeAdvisors($query){
		return $query->where('status','=','10');
	}
	
	public function card(){
		return View::make('users.userCard')->with('user',$this)->with('permissions',$this->permissions());
	}
	
	public function permissions(){
		return DB::table('tblprofilepermissions')->where('cwruID','=',$this->cwruID)->first();
	}
	
	public function hasPermission($attrName){
		if(Session::get('username') == $user->cwruID){
			return true;
		}else if (AccessController::isMember(Session::get('username'))){
			
		}else{
			
		}
	}
	
	public function pictureURL($size = 500){
		return "http://www.gravatar.com/avatar/".md5($this->picture)."?s=$size&d=mm";
	}

    public function getFullDisplayName(){
        return $this->getDisplayName()." ".$this->lastName;
    }

    public function getDisplayName(){
        if($this->nickName != null){
            return $this->nickName;
        } else {
            return $this->firstName;
        }
    }
}
