<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::post('authenticate','AuthenticateController@authenticate');


Route::group([ 'prefix' => 'projects' ], function () {

    Route::get('all','ProjectsController@all');
    
    Route::get('', 'ProjectsController@index' );

    Route::post('', 'ProjectsController@store' );

    Route::post('verifyCode','ProjectsController@verifyCode');

    Route::put('{id}', 'ProjectsController@update' );

});

Route::group([ 'prefix' => 'positions' ], function () {

    Route::get('all','PositionsController@all');
    
    Route::get('', 'PositionsController@index' );

    Route::post('', 'PositionsController@store' );

    Route::put('{id}', 'PositionsController@update' );

});

Route::group([ 'prefix' => 'employmentStatus' ], function () {
    
    Route::get('all','EmploymentStatusController@all');

    Route::get('', 'EmploymentStatusController@index' );

    Route::post('', 'EmploymentStatusController@store' );

    Route::put('{id}', 'EmploymentStatusController@update' );

});

Route::group([ 'prefix' => 'employeeStatus' ], function () {

    Route::get('all','EmployeeStatusController@all');
    
    Route::get('', 'EmployeeStatusController@index' );

    Route::post('', 'EmployeeStatusController@store' );

    Route::put('{id}', 'EmployeeStatusController@update' );

});

Route::group(['prefix' => 'employee'], function () {
    
    Route::get('','EmployeeController@index');

    Route::post('register','EmployeeController@store');

});



