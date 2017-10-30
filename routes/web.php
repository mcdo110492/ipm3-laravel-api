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

Route::group(['prefix' => 'routeAuthenticate', 'middleware' => ['jwt.auth']], function () {
    
   Route::get('', function () {
     
        return response()->json(['status' => 200, 'message' => 'ok']);

   });

});



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

    Route::post('verifyPosition','PositionsController@verifyPosition');

    Route::put('{id}', 'PositionsController@update' );

});

Route::group([ 'prefix' => 'employmentStatus' ], function () {
    
    Route::get('all','EmploymentStatusController@all');

    Route::get('', 'EmploymentStatusController@index' );

    Route::post('', 'EmploymentStatusController@store' );

    Route::post('verify','EmploymentStatusController@verify');

    Route::put('{id}', 'EmploymentStatusController@update' );

});

Route::group([ 'prefix' => 'employeeStatus' ], function () {

    Route::get('all','EmployeeStatusController@all');
    
    Route::get('', 'EmployeeStatusController@index' );

    Route::post('', 'EmployeeStatusController@store' );

    Route::post('verify','EmployeeStatusController@verify');

    Route::put('{id}', 'EmployeeStatusController@update' );

});

Route::group(['prefix' => 'employee'], function () {
    
    Route::get('','EmployeeController@index');


    Route::post('verify','EmployeeController@verify');

    Route::post('register','EmployeeController@store');


    Route::get('contact','EmployeeController@getContact');

    Route::put('contact/{id}','EmployeeController@updateContact');


    Route::get('health','EmployeeController@getHealth');
    
    Route::put('health/{id}','EmployeeController@updateHealth');


    Route::get('government','EmployeeController@getGovernment');
    
    Route::put('government/{id}','EmployeeController@updateGovernment');


    Route::get('account/{id}','EmployeeController@getAccount');

    Route::put('username/{id}','EmployeeController@updateAccountUsername');

    Route::put('account/status/{id}','EmployeeController@updateAccountStatus');

    Route::put('account/reset/{id}','EmployeeController@updateAccountResetPassword');


    Route::get('license/{id}','EmployeeController@getLicenses');

    Route::post('license','EmployeeController@storeLicense');

    Route::put('license/{id}','EmployeeController@updateLicense');


    Route::get('education/{id}','EmployeeController@getEducations');

    Route::post('education','EmployeeController@storeEducation');

    Route::put('education/{id}','EmployeeController@updateEducation');


    Route::get('training/{id}','EmployeeController@getTrainings');

    Route::post('training','EmployeeController@storeTraining');

    Route::put('training/{id}','EmployeeController@updateTraining');


    Route::get('club/{id}','EmployeeController@getClubs');

    Route::post('club','EmployeeController@storeClub');

    Route::put('club/{id}','EmployeeController@updateClub');

});



