<?php namespace APOSite\Http\Controllers;

use APOSite\Models\ServiceReport;

class SiteStatisticsController extends Controller {

	public static function logRequest($reequest){
		
	}

	public function getserviceevent($id){
		return ServiceReport::findOrFail($id);
	}
}
