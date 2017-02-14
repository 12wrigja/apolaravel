<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['prefix' => 'v1'],
    function () {
        // Users API

        // Create
        Route::post('/users', ['uses' => 'UserController@store', 'as' => 'user_store']);

        // Read
        Route::get('/users', ['uses' => 'API\UserAPIController@index', 'as' => 'api.users'])
            ->middleware('scope:view-profile,edit-profile');
        Route::get('/users/{cwruid}', ['uses' => 'UserController@show', 'as' => 'user_show'])->middleware('scope:view-profile,edit-profile');

        // Update
        Route::put('/users/{cwruid}', ['uses' => 'UserController@update', 'as' => 'user_update'])
            ->middleware('scope:edit-profile');

        // Delete
        Route::delete('/users/{cwruid}', 'UserController@destroy');

        // Contract Status
        Route::get('/users/{cwruid}/status',
                   ['uses' => 'UserController@statusPage', 'as' => 'user_status']);
    });