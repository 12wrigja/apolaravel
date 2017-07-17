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

//Patterns for the various routes.
//Type pattern for the various report types that can exist.
Route::pattern('type', '[a-z][a-z_]*');
//ID pattern for matching against a resource id. Must be a number.
Route::pattern('id', '[0-9]+');
//CWRU ID pattern for matching against CWRU ID's
Route::pattern('cwruid', '[a-z]+[0-9]*');

Route::group(['prefix' => 'v1'],
    function () {
        // Users API
        // Create
        Route::post('/users', ['uses' => 'API\UserAPIController@store', 'as' => 'api.user_store'])
            ->middleware('scope:manage-users');
        // Read
        Route::get('/users', ['uses' => 'API\UserAPIController@index', 'as' => 'api.users'])
            ->middleware('scope:view-profile,edit-profile');
        Route::get('/users/{cwruid}', ['uses' => 'API\UserAPIController@show', 'as' => 'api.user'])
            ->middleware('scope:view-profile,edit-profile');
        // Update
        Route::put('/users/{cwruid}',
            ['uses' => 'API\UserAPIController@update', 'as' => 'api.user_update'])
            ->middleware('scope:edit-profile');
        // Delete
        Route::delete('/users/{cwruid}',
            ['uses' => 'API\UserAPIController@destroy', 'as' => 'api.user_delete'])->middleware('scope:manage-users');
        // Contract Status
        Route::get('/users/{cwruid}/status',
            [
                'uses' => 'API\UserAPIController@contractStatus',
                'as' => 'api.user_status'
            ])->middleware('scope:view-contract');

        // WhoAmI
        Route::get('/whoami', function() {
            return response()->json(['data'=>Auth::id()]);
        });
    });