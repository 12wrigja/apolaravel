<?php
use APOSite\Http\Controllers\LoginController;
use APOSite\Models\CarouselItem;

//Patterns for the various routes.
//Type pattern for the various report types that can exist.
Route::pattern('type', '[a-z][a-z_]*');
//ID pattern for matching against a resource id. Must be a number.
Route::pattern('id', '[0-9]+');
//CWRU ID pattern for matching against CWRU ID's
Route::pattern('cwruid', '[a-z]{3}[0-9]*');

//Routes for reports
Route::post('/reports/{type}', ['uses' => 'EventPipelineController@submitEvent', 'as' => 'report_store']);
Route::get('reports/{type}/create', ['uses' => 'EventPipelineController@createEvent', 'as' => 'report_create']);
Route::get('manage/reports/{type}', ['uses' => 'EventPipelineController@manageEvent', 'as' => 'report_manage']);
Route::get('/reports/{type}/', ['uses' => 'EventPipelineController@showAllEvents', 'as' => 'report_list']);
Route::get('/reports/{type}/{id}', ['uses' => 'EventPipelineController@showEvent', 'as' => 'report_show']);
Route::put('/reports/{type}/{id}', ['uses' => 'EventPipelineController@updateEvent', 'as' => 'report_update']);
Route::delete('/reports/{type}/{id}', ['uses' => 'EventPipelineController@deleteEvent', 'as' => 'report_delete']);

Route::get('images',function(){
   return view('home');
});
//Route::get('/images/{filename}',['uses'=>'ImageController@getImage','as'=>'image_get']);
Route::post('/img',['as'=>'upload_image','uses'=>'ImageController@uploadImage']);
Route::get('/manage/banner',function(){
   return view('tools.bannermanagement');
});

//Routes for the officer pages
Route::get('officers', ['uses'=>'Officers\OfficerPageController@index','as'=>'officers']);

Route::get('statistics',['uses'=>'ChapterStatisticsController@index','as'=>'chapterstatistics']);
Route::get('calendar',['as'=>'calendar',function(){
    return view('tools.calendar');
}]);

//Routes for managing the users of the users, including creating and storing users.
//Route::get('/users/create', 'UserController@create');
//Route::post('/users', 'UserController@store');
Route::delete('/users/{cwruid}', 'UserController@destroy');
//TODO fix up or verify user management and user search
//Route::get('/users/manage', 'UserController@manage');

//Route for searching users.
//Route::get('/users/search', array('uses' => 'UserController@search', 'as' => 'user_search'));

//Routes for displaying all users and individual user profiles
Route::get('/users', ['uses'=>'UserController@index','as'=>'users']);
Route::get('/users/{cwruid}', ['uses'=>'UserController@show','as'=>'user_show']);

//Routes for allowing users to update their profiles.
//TODO fix up the user editing system
//Route::get('/users/{cwruid}/edit', 'UserController@edit');
Route::get('/users/{cwruid}/status', ['uses'=>'UserController@statusPage','as'=>'user_status']);
//Route::put('/users/cwruid}', 'UserController@update');

//TODO clean up routing system for contract and requirement data, along w/ models
//All routes regarding contracts and contract requirements are commented out for the time being as they have not been refactored correctly.

//Route::get('contracts', ['uses' => 'ContractController@index', 'as' => 'contract_view']);
//Route::get('contracts/create', ['uses' => 'ContractController@create', 'as' => 'contract_create']);
//Route::post('contracts', ['uses' => 'ContractController@store', 'as' => 'contract_store']);
//Route::get('contracts/{id}/edit', ['uses' => 'ContractController@edit', 'as' => 'contract_edit']);
//Route::put('contracts/{id}', ['uses' => 'ContractController@update', 'as' => 'contract_update']);
//Route::delete('contracts/{id}', ['uses' => 'ContractController@destroy', 'as' => 'contract_delete']);
//Route::get('contracts/{id}/', 'ContractController@show')->where('id', '[0-9]+');
//
////Route group for Contract Requirements
//Route::get('contractreqs', ['uses' => 'ContractRequirementController@index', 'as' => 'contractreq_view']);
//Route::get('contractreqs/create', ['uses' => 'ContractRequirementController@create', 'as' => 'contractreq_create']);
//Route::post('contractreqs', ['uses' => 'ContractRequirementController@store', 'as' => 'contractreq_store']);
//Route::get('contractreqs/{id}/edit', ['uses' => 'ContractRequirementController@edit', 'as' => 'contractreq_edit']);
//Route::put('contractreqs/{id}', ['uses' => 'ContractRequirementController@update', 'as' => 'contractreq_update'])->where('id', '[0-9]+');
//Route::delete('contractreqs/{id}', ['uses' => 'ContractRequirementController@destroy', 'as' => 'contractreq_delete'])->where('id', '[0-9]+');
//Route::get('contractreqs/{id}/', 'ContractRequirementController@show')->where('id', '[0-9]+');
//Route::get('contractreqs', ['uses' => 'ContractRequirementController@index', 'as' => 'contractreq_view']);
//Route::post('contractreqs', ['uses' => 'ContractRequirementController@store', 'as' => 'contractreq_store']);

//Route for the homepage
Route::get('/', array(
    'as' => 'home',
    function () {
        return View::make('home')->with('carouselItems', CarouselItem::all());
    }
));

////Route for logging in when debugging the application
Route::post('login/debug', function () {
    return LoginController::debugLogin();
});

//Route for logging out
Route::get('/logout', ['as'=>'logout',function () {
    LoginController::logout();
    if (Input::has('redirect_url')) {
        return Redirect::to(Input::get('redirect_url'));
    } else {
        return Redirect::route('home');
    }
}]);

//Route for logging in and checking login
Route::get('login', array(
    'as' => 'login',
    'middleware' => 'SSOAuth',
    function () {
        return Redirect::route('home');
    }
));

Route::get('debug',function(){
    return LoginController::currentUser()->contractForSemester(null)->requirements[0]->getReports();
});

