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

//this route will use the middleware of the 'web' group, so session and auth will work here


Route::group(['middleware' => 'auth'], function() {
    Route::get('/', 'HomeController@index');
    Route::get('admin', 'HomeController@index');
});


Route::auth();

Route::group(['namespace' => 'User', 'prefix' => 'user'], function() {
    Route::get('query', 'UserController@queryView');
    Route::post('queryResult', 'UserController@queryCode');
});

Route::group(['namespace' => 'User', 'prefix' => 'mhuser'], function() {
    //Route::post('wsklx/checkCode', 'klxApiController@checkCode');
    Route::get('query', 'MHUserController@queryView');
    Route::get('queryResult', 'MHUserController@queryCode');
});

Route::group(['namespace' => 'Api', 'prefix' => 'api/mh'], function() {
    //Route::post('wsklx/checkCode', 'klxApiController@checkCode');
    Route::post('/activeCode', 'mhApiController@activeCode');
    Route::post('/queryStatus', 'mhApiController@queryStatus');
});

Route::group(['namespace' => 'Api', 'prefix' => 'api/wsklx'], function() {
    //Route::post('wsklx/checkCode', 'klxApiController@checkCode');
    Route::post('/activeCode', 'klxApiController@activeCode');
    Route::post('/queryStatus', 'klxApiController@queryStatus');
});

Route::group(['middleware' => 'auth', 'namespace' => 'Admin', 'prefix' => 'admin/wsklx'], function() {
    Route::get('/', 'klxActivateController@index');
    Route::get('/create', 'klxActivateController@createView');
    Route::post('/getActivate', 'klxActivateController@getActivate');
    Route::get('/freeze', 'klxActivateController@freezeView');
    Route::post('/freezeActivate', 'klxActivateController@freezeActivate');
    Route::post('/unfreezeActivate', 'klxActivateController@unfreezeActivate');
    Route::delete('/delete/{id}', 'klxActivateController@destroy');
    Route::get('/query', 'klxActivateController@queryView');
    Route::post('/queryActivate', 'klxActivateController@queryActivate');
    Route::get('/agent', 'klxActivateController@registerView');
    Route::post('/createAgent', 'klxActivateController@createAgent');
    Route::get('/checkAgent', 'klxActivateController@agentView');
    Route::get('/massdelete', 'klxActivateController@massdeleteView');
    Route::post('/massdeletePreview', 'klxActivateController@massdeletePreview');
    Route::post('/massdeleteActivate', 'klxActivateController@massdeleteActivate');
});

Route::group(['middleware' => 'auth', 'namespace' => 'Admin', 'prefix' => 'admin/mh'], function() {
    Route::get('/', 'mhActivateController@index');
    Route::get('/create', 'mhActivateController@createView');
    Route::post('/getActivate', 'mhActivateController@getActivate');
    Route::get('/freeze', 'mhActivateController@freezeView');
    Route::post('/freezeActivate', 'mhActivateController@freezeActivate');
    Route::post('/unfreezeActivate', 'mhActivateController@unfreezeActivate');
    Route::delete('/delete/{id}', 'mhActivateController@destroy');
    Route::get('/query', 'mhActivateController@queryView');
    Route::post('/queryActivate', 'mhActivateController@queryActivate');
    Route::get('/agent', 'mhActivateController@registerView');
    Route::post('/createAgent', 'mhActivateController@createAgent');
    Route::get('/checkAgent', 'mhActivateController@agentView');
    Route::get('/massdelete', 'mhActivateController@massdeleteView');
    Route::post('/massdeletePreview', 'mhActivateController@massdeletePreview');
    Route::post('/massdeleteActivate', 'mhActivateController@massdeleteActivate');
});

