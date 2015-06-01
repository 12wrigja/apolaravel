<?php namespace APOSite\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use DateTime;

class SiteStatistics extends Model {

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
        $now = new DateTime();
		$stat->timestamp = $now->getTimeStamp();
		$stat->save();
	}
}
