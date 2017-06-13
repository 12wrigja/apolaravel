<?php
use Illuminate\Support\Facades\Auth;
use APOSite\Models\CarouselItem;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;

//Patterns for the various routes.
//Type pattern for the various report types that can exist.
Route::pattern('type', '[a-z][a-z_]*');
//ID pattern for matching against a resource id. Must be a number.
Route::pattern('id', '[0-9]+');
//CWRU ID pattern for matching against CWRU ID's
Route::pattern('cwruid', '[a-z]+[0-9]*');

//Routes for the officer pages
Route::get('officers', ['uses' => 'Officers\OfficerPageController@index', 'as' => 'officers']);
Route::get('statistics', ['uses' => 'ChapterStatisticsController@chapterStatistics', 'as' => 'chapterstatistics']);

//Routes for External Tools used by APO
Route::get('calendar', [
    'as' => 'calendar',
    function () {
        return view('tools.calendar');
    }
]);
Route::get('drive', [
    'middleware' => 'auth',
    function () {
        return redirect()->away('https://drive.google.com/open?id=0BzPifk8kXJfHOHVYR2szVzJ6dXM');
    }
]);
Route::get('rush', [
    'as' => 'rush',
    function () {
        return redirect()->away('http://us10.campaign-archive2.com/home/?u=5b2f75849cd559d84139bbab3&id=50120b9c97');
    }
]);
Route::get('talenttwist', [
    'as' => 'talenttwist',
    function () {
        return redirect()->away('http://www.facebook.com/events/535265626666670/');
    }
]);

//Document viewing.
Route::get('documents', ['uses' => 'DocumentController@index', 'as' => 'document_list']);
Route::get('documents/{office}/{filename}',
    ['uses' => 'DocumentController@getOfficeDocument', 'as' => 'retrieve_office_document']);
Route::get('documents/{filename}', ['uses' => 'DocumentController@getDocument', 'as' => 'retrieve_document']);

//Contract and management related routes
Route::get('contracts/progress',
    ['uses' => 'ChapterStatisticsController@contractStatusPage', 'as' => 'contract_progress']);
Route::get('manage/contracts', ['uses' => 'ContractController@manage', 'as' => 'contract_manage']);
Route::get('contracts', ['as' => 'sign_contract', 'uses' => 'ContractController@index']);
Route::post('contracts', ['uses' => 'ContractController@modifyContract', 'as' => 'contract_store']);
Route::post('contracts/change',
    ['as' => 'changeContractSigning', 'uses' => 'ContractController@changeContractSigning']);

Route::post('email', function (\APOSite\Http\Requests\SendEmailRequest $request) {
    $user = APOSite\Models\Users\User::find($request->get('to'));
    $userFullName = $user->getDisplayName();
    $userId = $user->id;
    Mail::queue('emails.test', ['msg' => 'This is a test message from the website.'],
        function ($message) use ($userId, $userFullName) {
            $message->to($userId . '@case.edu', $userFullName)->subject('Test Message');
        });
});

Route::get('/grilledcheese', ['uses' => 'GrilledCheeseController@showOrderPage', 'as' => 'gs']);
Route::get('/grilledcheese/manage', 'GrilledCheeseController@showManagementPage');
Route::get('/grilledcheese/*', function () {
    return redirect()->route('gs');
});


Route::get('/marchformarfan', [
    'as' => 'm4m',
    function () {
        return view('marchformarfan.index');
    }
]);

//Route for the homepage
Route::get('/', array('as' => 'home', function () {
        return View::make('home')->with('carouselItems', CarouselItem::OrderByDisplayOrder()->get());
    }
));

// Routes for logging in and out. Copied from Laravel source.
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('logout','Auth\LoginController@logout')->name('logout');
Route::get('whoami', function(){
    if(Auth::check()){
        return Auth::id();
    } else {
        abort(401);
    }
});

Route::get('{id}', [
    'as' => 'error_show',
    function ($id) {
        try {
            return view('errors.' . $id);
        } catch (Exception $e) {
            return view('errors.500');
        }
    }
]);

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

// View profile page
Route::get('/users/{cwruid}', ['uses' => 'UserController@show', 'as' => 'user_show']);
// Search page for users
Route::get('/users', ['uses' => 'UserController@index', 'as' => 'users']);
// Creation page for users
Route::get('/users/create', ['uses' => 'UserController@create', 'as' => 'user_create']);
// Profile Editing page for users
Route::get('/users/{cwruid}/edit', ['uses' => 'UserController@edit', 'as' => 'user_edit']);
// Contract status page
Route::get('/users/{cwruid}/status', ['uses' => 'UserController@statusPage', 'as' => 'user_status']);
// Management Page
Route::get('/manage/users', ['uses' => 'UserController@manage', 'as' => 'user_manage']);
