<?php

class SiteStatistics extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'sitestatistics';
	
	protected $primaryKey = 'routeName';
	
	public $timestamps = false;
	
	public static function logRequest($request){
		$stat = new SiteStatistics();
		$stat->routeName = Request::path();
		$stat->timestamp = DateTime::getTimeStamp();
		$stat->save(); 
	}
}
