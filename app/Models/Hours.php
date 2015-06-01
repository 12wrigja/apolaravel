<?php namespace APOSite\Models;

use Illuminate\Database\Eloquent\Model;

class Hours extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tblhours';
	
	protected $primaryKey = 'id';
	
	public $timestamps = false;
	
	public static function currentHours($usr){
		$usrHours = Hours::find($usr);
		if(null != $usrHours){
			$inside = $usrHours->inside;
			$outside = $usrHours->outside;
			return ($inside+$outside)/12.0;
		}else{
			return null;
		}
	}
}
