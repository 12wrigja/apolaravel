<?php
use APOSite\Http\Controllers\LoginController;
use APOSite\Models\CarouselItem;

//Patterns for the various routes.
//Type pattern for the various report types that can exist.
Route::pattern('type', '[a-z][a-z_]*');
//ID pattern for matching against a resource id. Must be a number.
Route::pattern('id', '[0-9]+');
//CWRU ID pattern for matching against CWRU ID's
Route::pattern('cwruid', '[a-z]+[0-9]*');

//Routes for reports
Route::post('/reports/{type}', ['uses' => 'EventPipelineController@submitEvent', 'as' => 'report_store']);
Route::get('reports/{type}/create', ['uses' => 'EventPipelineController@createEvent', 'as' => 'report_create']);
Route::get('manage/reports/{type}', ['uses' => 'EventPipelineController@manageEvent', 'as' => 'report_manage']);
Route::get('/reports/{type}/', ['uses' => 'EventPipelineController@showAllEvents', 'as' => 'report_list']);
Route::get('/reports/{type}/{id}', ['uses' => 'EventPipelineController@showEvent', 'as' => 'report_show']);
Route::put('/reports/{type}/{id}', ['uses' => 'EventPipelineController@updateEvent', 'as' => 'report_update']);
Route::delete('/reports/{type}/{id}', ['uses' => 'EventPipelineController@deleteEvent', 'as' => 'report_delete']);

//Route::get('images',function(){
//   return view('home');
//});
//Route::get('/images/{filename}',['uses'=>'ImageController@getImage','as'=>'image_get']);
//Route::post('/img',['as'=>'upload_image','uses'=>'ImageController@uploadImage']);
//Route::get('/manage/banner',function(){
//   return view('tools.bannermanagement');
//});

//Routes for the officer pages
Route::get('officers', ['uses'=>'Officers\OfficerPageController@index','as'=>'officers']);
Route::get('statistics',['uses'=>'ChapterStatisticsController@chapterStatistics','as'=>'chapterstatistics']);

//Routes for External Tools used by APO
Route::get('calendar',['as'=>'calendar',function(){
    return view('tools.calendar');
}]);
Route::get('drive',['middleware'=>'SSOAuth',function(){
  return redirect()->away('https://drive.google.com/open?id=0BzPifk8kXJfHOHVYR2szVzJ6dXM');
}]);

//TODO fix up the user editing system
Route::get('/users', ['uses'=>'UserController@index','as'=>'users']);
Route::post('/users',['uses'=>'UserController@store','as'=>'user_store']);
Route::get('/users/create',['uses'=>'UserController@create','as'=>'user_create']);
Route::get('/users/{cwruid}/edit', ['uses'=>'UserController@edit','as'=>'user_edit']);
Route::get('/users/{cwruid}/status', ['uses'=>'UserController@statusPage','as'=>'user_status']);
Route::get('/users/{cwruid}', ['uses'=>'UserController@show','as'=>'user_show']);
Route::delete('/users/{cwruid}', 'UserController@destroy');
Route::put('/users/{cwruid}', ['uses'=>'UserController@update','as'=>'user_update']);
Route::get('/manage/users',['uses'=>'UserController@manage','as'=>'user_manage']);

//Document viewing.
Route::get('documents',['uses'=>'DocumentController@index','as'=>'document_list']);
Route::get('documents/{office}/{filename}',['uses'=>'DocumentController@getOfficeDocument','as'=>'retrieve_office_document']);
Route::get('documents/{filename}',['uses'=>'DocumentController@getDocument','as'=>'retrieve_document']);

//Contract and management related routes
Route::get('contracts/progress',['uses'=>'ChapterStatisticsController@contractStatusPage','as'=>'contract_progress']);
Route::get('manage/contracts',['uses'=>'ContractController@manage','as'=>'contract_manage']);
Route::get('contracts',['as'=>'sign_contract','uses'=>'ContractController@index']);
Route::post('contracts',['uses'=>'ContractController@modifyContract','as'=>'contract_store']);
Route::post('contracts/change',['as'=>'changeContractSigning','uses'=>'ContractController@changeContractSigning']);

Route::post('email',function(\APOSite\Http\Requests\SendEmailRequest $request){
    $user = APOSite\Models\Users\User::find($request->get('to'));
    $userFullName = $user->getDisplayName();
    $userId = $user->id;
    Mail::queue('emails.test',['msg'=>'This is a test message from the website.'],function($message) use ($userId,$userFullName){
        $message->to($userId.'@case.edu',$userFullName)->subject('Test Message');
    });
});

Route::get('/grilledcheese',['uses'=>'GrilledCheeseController@showOrderPage','as'=>'gs']);
Route::get('/grilledcheese/manage','GrilledCheeseController@showManagementPage');
Route::get('/grilledcheese/*',function(){
    return redirect()->route('gs');
});

Route::get('/marchformarfan',['middleware'=>'SSOAuth','as'=>'m4m',function(){
   return view('marchformarfan.index');
}]);

//Route for the homepage
Route::get('/', array(
    'as' => 'home',
    function () {
        return View::make('home')->with('carouselItems', CarouselItem::OrderByDisplayOrder()->get());
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
        if(session()->has('redirect_url')){
            $redirect_url = session('redirect_url');
            session()->forget('redirect_ur');
            return redirect($redirect_url);
        } else {
            return Redirect::route('home');
        }
    }
));

Route::get('{id}',['as'=>'error_show',function($id){
   try{
       return view('errors.'.$id);
   } catch(Exception $e){
       return Redirect::route('error_show',['id'=>'404']);
   }
}]);
