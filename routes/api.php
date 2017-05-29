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
        Route::post('/users', ['uses' => 'API\UserAPIController@store', 'as' => 'user_store'])
            ->middleware('scope:manage-users');
        // Read
        Route::get('/users', ['uses' => 'API\UserAPIController@index', 'as' => 'api.users'])
            ->middleware('scope:view-profile,edit-profile');
        Route::get('/users/{cwruid}', ['uses' => 'API\UserAPIController@show', 'as' => 'user_show'])
            ->middleware('scope:view-profile,edit-profile');
        // Update
        Route::put('/users/{cwruid}',
            ['uses' => 'API\UserAPIController@update', 'as' => 'user_update'])
            ->middleware('scope:edit-profile');
        // Delete
        Route::delete('/users/{cwruid}', 'API\UserAPIController@destroy')->middleware('scope:manage-users');
        // Contract Status
        Route::get('/users/{cwruid}/status',
            ['uses' => 'API\UserAPIController@statusPage', 'as' => 'user_status']);
    });