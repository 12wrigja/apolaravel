<?php
class UserController extends Controller {
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		if(Input::get('query')){
			$users = $this->searchUsers(Input::get('query'))->paginate(10);
		}else{
			$users = User::paginate(10);
		}
		if(Request::ajax()){
			return Response::json(View::make('users.cards')->with('users',$users)->render());
		}else if (Request::wantsJson()){
			return User::with(['status'=>function($q){
				$q->select('id','status');
			}])->orderBy('firstName','ASC')->orderBy('lastName','ASC')->select('firstName','lastName','cwruID','status')->paginate(10);
		}else{
			return View::make('users.index')->with('users',$users)->with('torchURL','/packages/images/torch-logo.png');
		}
	}
	
	public function manage(){
		if(Input::get('query')){
			$users = $this->searchUsers(Input::get('query'))->paginate(10);
		}else{
			$users = User::with(['status'=>function($q){
				$q->select('id','status');
			}])->paginate(10);
		}
		if(Request::ajax()){
			return Response::json(View::make('users.table')->with('users',$users)->render());
		}else if (Request::wantsJson()){
			return User::with(['status'=>function($q){
				$q->select('id','status');
			}])->orderBy('firstName','ASC')->orderBy('lastName','ASC')->select('firstName','lastName','cwruID','status')->paginate(10);
		}else{
			return View::make('users.manage')->with('users',$users);
		}
	}
	
	private function managePage($users){
		if (Request::wantsJson ()) {
			return User::all ();
		} else {
			return View::make ( 'users.manage' )->with ( 'users', $users->paginate(10));
		}
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create() {
		if (Request::wantsJson ()) {
			return User::all ();
		} else {
			return View::make ('users.create')->with('statuses',MemberStatus::lists('status','id'));
		}
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store() {
		$rules = array(
				'firstName'=>'required',
				'lastName'=>'required',
				'cwruID'=>'required|unique:tblmembers',
				'status'=>'required|numeric'
		);
		$messages = array(
				'cwruID.unique' => 'The :attribute is already registered.'
		);
		$validator = Validator::make(Input::all(),$rules,$messages);
		if($validator->fails()){
			return Redirect::to('users/create')->withErrors($validator)->withInput(Input::except('password'));
		}else{
			$user = new User();
			$user->firstName = Input::get('firstName');
			$user->lastName = Input::get('lastName');
			$user->cwruID = Input::get('cwruID');
			$user->status = Input::get('status');
			$user -> save();			
			return Redirect::to('users/mange')->with('message','Successfully created the user.');
		}
	}
	
	/**
	 * Display the specified resource.
	 *
	 * @param int $id        	
	 * @return Response
	 */
	public function show($id) {
		$user = User::find($id);
		if($user != null){
			return View::make('users.profile')->with('user',$user)->with('permissions',$user->permissions());
		}else{
			throw new Symfony\Component\HttpKernel\Exception\NotFoundHttpException('User not found');
		}
	}
	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id        	
	 * @return Response
	 */
	public function edit($id) {
		return View::make('users.edit')->with('user',User::find($id))->with('statuses',MemberStatus::lists('status','id'));
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param int $id        	
	 * @return Response
	 */
	public function update($id) {
		
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id        	
	 * @return Response
	 */
	public function destroy($id) {
	$user = User::find($id);
		if($user != null){
			User::destroy($id);
			return Redirect::to('users/manage')->with('message','Successfully deleted the user.');
		}else{
			throw new Symfony\Component\HttpKernel\Exception\NotFoundHttpException('User not found');
		}
	}
	
	public function search(){
		$text = Input::get('query');
		$users = $this->searchUsers($text);
		$attributes = Input::get('attr');
		if($attributes!= null){
			$attributes = explode(',', $attributes);
			foreach($attributes as $attr){
				$users = $users->addSelect($attr);
			}
		}
		$users = $users->get();
		$resultFormat = Input::get('result_format');
		if($resultFormat != null){
			$formatStrings = explode(";", $resultFormat);
			$results = [];
			foreach($users as $user){
				$res = new stdClass();
				foreach($formatStrings as $str){
					$resStr = "";
					$key = explode(":", $str)[0];
					$pattern = explode(":", $str)[1];
					foreach($user->getAttributes() as $userAttr=>$value){
						$pattern = str_replace($userAttr, $value, $pattern);
					}
					$res->$key = $pattern;
				}
				$results[] = $res;
				
			}
			$results = (object)array('results'=>$results);
			return Response::json($results);
		}else{
			$results = [];
			foreach($users as $user){
				array_push($results, $user);
			}
			$res = (object)array('results'=>$results);
		}
		return Response::json($res);
	}
	
	private function searchUsers($text){
		if($text != ""){
			$users = User::with(['status'=>function($q){
				$q->select('id','status');
			}])->where('firstName','LIKE',$text.'%')->orWhere('lastName','LIKE',$text.'%')->orWhere(DB::raw('CONCAT(firstName, " ", lastName)'),'LIKE',$text.'%')->orderBy('firstName','ASC')->orderBy('lastName','ASC');
		}else{
			$users = null;
		}
		return $users;
	}
	
}
