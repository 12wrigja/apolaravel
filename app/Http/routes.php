<?php
use APOSite\Models\CarouselItem;
use APOSite\Http\Controllers\LoginController;
use APOSite\Http\Controllers\AccessController;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::filter('sameid',function($route){
	$username = LoginController::getCaseUsername();
	$id = $route->getParameter('id');
	if($id != $username){
		return View::make('errors.401')->with('message','You do not have permission to access this page.');
	}
});

Route::filter('casAuth',function(){
	return LoginController::authenticate();
});

Route::filter('webmaster',function(){
	$username = LoginController::getCaseUsername();
	if(!AccessController::isWebmaster($username)){
		return View::make('errors.401')->with('message','You do not have permission to access this page.');
	}
});

//Routes for the officer pages
Route::get('officers','Officers\OfficerPageController@index');

//Route for testing JSON input on post
Route::get('/api/testpost','JSONController@get');
Route::post('/api/testpost','JSONController@post');

//Routes for managing the users of the users, including creating and storing users.
Route::group(array('before'=>'casAuth|webmaster'),function(){
	Route::get('/users/create','UserController@create');
	Route::post('/users','UserController@store');
	Route::delete('/users/{id}','UserController@destroy');
	Route::get('/users/manage','UserController@manage');
});

//Route for searching users.
Route::get('/users/search',array('uses'=>'UserController@search','as'=>'users.search'));

//Routes for displaying all users and individual user profiles
Route::get('/users','UserController@index');
Route::get('/users/{id}','UserController@show');

//Routes for allowing users to update their profiles.
Route::group(array('before'=>'casAuth|sameid'),function(){
	Route::get('/users/{id}/edit','UserController@edit');
	Route::put('/users/{id}','UserController@update');
});

//Routes for managing permissions of users
Route::group(array('before'=>'casAuth|webmaster'),function(){
	Route::get('/permissions','PermissionController@index');
	Route::get('/permissions/create','PermissionController@create');
	Route::post('/permissions','PermissionController@store');
});

Route::group(array('before'=>'casAuth'),function(){
    Route::get('contracts',['uses'=>'ContractController@index','as'=>'contract_view']);
    Route::get('contracts/create',['uses'=>'ContractController@create', 'as'=>'contract_create']);
    Route::post('contracts/store',['uses'=>'ContractController@store', 'as'=>'contract_store']);
    Route::get('contracts/{id}/edit',['uses'=>'ContractController@edit','as'=>'contract_edit']);
    Route::put('contracts/{id}',['uses'=>'ContractController@update','as'=>'contract_update'])->where('id','[0-9]+');
    Route::delete('contracts/{id}',['uses'=>'ContractController@destroy', 'as'=>'contract_delete'])->where('id','[0-9]+');
    Route::get('contracts/{id}/','ContractController@show')->where('id','[0-9]+');
});

//Route group for
Route::group(array('before'=>'casAuth'),function(){
    Route::get('contractreqs',['uses'=>'ContractRequirementController@index','as'=>'contractreq_view']);
    Route::get('contractreqs/create',['uses'=>'ContractRequirementController@create', 'as'=>'contractreq_create']);
    Route::post('contractreqs/store',['uses'=>'ContractRequirementController@store', 'as'=>'contractreq_store']);
    Route::get('contractreqs/{id}/edit',['uses'=>'ContractRequirementController@edit','as'=>'contractreq_edit']);
    Route::put('contractreqs/{id}',['uses'=>'ContractRequirementController@update','as'=>'contractreq_update'])->where('id','[0-9]+');
    Route::delete('contractreqs/{id}',['uses'=>'ContractRequirementController@destroy', 'as'=>'contractreq_delete'])->where('id','[0-9]+');
    Route::get('contractreqs/{id}/','ContractRequirementController@show')->where('id','[0-9]+');
    Route::get('contractreqs',['uses'=>'ContractRequirementController@index', 'as'=>'contractreq_view']);
    Route::post('contractreqs',['uses'=>'ContractRequirementController@store', 'as'=>'contractreq_store']);
});

//Route for the homepage
Route::get('/',array('as'=>'home',function(){
	return View::make('home')->with('carouselItems',CarouselItem::all());
}));

//Route for logging in when debugging the application
Route::post('login_debug',function(){
	LoginController::debugLogin();
	return Redirect::route('home');
});

//Route for logging out
Route::get('/logout',function(){
	LoginController::logout();
	if(Input::has('redirect_url')){
		return Redirect::to(Input::get('redirect_url'));
	}else{
		return Redirect::route('home');
	}
});

//Route for logging in and checking login
Route::get('/login',array('as'=>'login','before'=>'casAuth',function(){
	return Redirect::route('home');
}));
