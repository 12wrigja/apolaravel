<?php
class JSONController extends Controller {
	
	public function post(){
		$postdata = Input::json();
		$others = $postdata->get('caseIDs');
		return response()->json(['id'=>'1']);
	}

	public function get(){
		return View::make('examples.jsonget');
	}
}
