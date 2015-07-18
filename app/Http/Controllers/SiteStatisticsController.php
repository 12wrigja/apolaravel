<?php namespace APOSite\Http\Controllers;

use APOSite\Models\ServiceEvent;

class SiteStatisticsController extends Controller {

	public static function logRequest($reequest){
		
	}

	public function getserviceevent($id){
		return ServiceEvent::findOrFail($id);
	}
}
