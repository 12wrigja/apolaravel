<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/test',function(){
   dd(Input::all());
});

Route::post('/service_reports','Reports\ServiceReportController@store');

//Route for logging out
Route::get('/logout', function () {
    LoginController::logout();
    if (Input::has('redirect_url')) {
        return Redirect::to(Input::get('redirect_url'));
    } else {
        return Redirect::route('home');
    }
});

//Route for logging in and checking login
Route::get('/login', array('as' => 'login', 'middleware' => 'SSOAuth', function () {
    return Redirect::route('home');
}));

//Route for the homepage
Route::get('/', array('as' => 'home', function () {
    //return View::make('home')->with('carouselItems', []);
    return view('master_full');
}));
