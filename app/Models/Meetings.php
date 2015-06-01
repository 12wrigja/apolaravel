<?php namespace APOSite\Models;

use Illuminate\Database\Eloquent\Model;

class Meetings extends Model {
	
	protected $table = 'tblattendance';
	
	protected $primarykey = 'id';
	
	public $timestamps = false;
	
	public static function currentMeetings($usr){
		
		$numMeetings = Meetings::where('id', '=', $usr)->sum('quantity');
		return $numMeetings/2;
		
	}
	
	
}