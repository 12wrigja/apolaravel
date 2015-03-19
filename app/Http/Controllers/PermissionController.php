<?php

class PermissionController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('permissions.index')->with('groupData',AccessController::retrieveAllGroupAssignments());
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('permissions.create')
		->with('userList',User::select('cwruID','firstName','lastName')->get())
		->with('groups',DB::table('groups')->lists('name','id'));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = array(
				'case_id'=>'required|unique_with:group_members,group_id',
				'group_id'=>'required|numeric'
		);
		$validator = Validator::make(Input::all(),$rules);
		if($validator->fails()){
			return Redirect::to('permissions/create')->withErrors($validator)->withInput(Input::except('password'));
		}else{
			DB::table('group_members')->insert(array('group_id'=>Input::get('group_id'),'case_id'=>Input::get('case_id')));
			return Redirect::to('permissions')->with('message','Successfully assigned permissions');
		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return AccessController::retrieveUsersOfGroup($id);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
