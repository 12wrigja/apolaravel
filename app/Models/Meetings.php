<?php

class Meetings extends Eloquent {
	
	protected $table = 'tblattendance';
	
	protected $primarykey = 'id';
	
	public $timestamps = false;
	
	public static function currentMeetings($usr){
		
		$numMeetings = Meetings::where('id', '=', $usr)->sum('quantity');
		return $numMeetings/2;
		
	}
	
	
}