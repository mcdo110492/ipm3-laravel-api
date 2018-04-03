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

// Master Data
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

    Route::post('verify','PositionsController@verifyData');

    Route::put('{id}', 'PositionsController@update' );

});

Route::group([ 'prefix' => 'employment/status' ], function () {
    
    Route::get('all','EmploymentStatusController@all');

    Route::get('', 'EmploymentStatusController@index' );

    Route::post('', 'EmploymentStatusController@store' );

    Route::post('verify','EmploymentStatusController@verifyData');

    Route::put('{id}', 'EmploymentStatusController@update' );

});

Route::group([ 'prefix' => 'employee/status' ], function () {

    Route::get('all','EmployeeStatusController@all');
    
    Route::get('', 'EmployeeStatusController@index' );

    Route::post('', 'EmployeeStatusController@store' );

    Route::post('verify','EmployeeStatusController@verifyData');

    Route::put('{id}', 'EmployeeStatusController@update' );

});

Route::group([ 'prefix' => 'contract/types' ], function () {

    Route::get('all','ContractTypesController@all');
    
    Route::get('', 'ContractTypesController@index' );

    Route::post('', 'ContractTypesController@store' );

    Route::post('verify','ContractTypesController@verifyData');

    Route::put('{id}', 'ContractTypesController@update' );

});

Route::group([ 'prefix' => 'salary/types' ], function () {

    Route::get('all','SalaryTypesController@all');
    
    Route::get('', 'SalaryTypesController@index' );

    Route::post('', 'SalaryTypesController@store' );

    Route::post('verify','SalaryTypesController@verifyData');

    Route::put('{id}', 'SalaryTypesController@update' );

});


// HR

Route::group(['prefix' => 'employee'], function () {
    
    Route::get('','EmployeeController@index');


    Route::post('verify','EmployeeController@verify');

    Route::post('register','EmployeeRegisterController@store');


    Route::get('personal/{id}','EmployeePersonalController@getPersonal');

    Route::put('personal/{id}','EmployeePersonalController@updatePersonal');


    Route::get('employment/{id}','EmployeeEmploymentController@getEmployment');
    
    Route::put('employment/{id}','EmployeeEmploymentController@updateEmployment');


    Route::get('contact/{id}','EmployeeContactController@getContact');

    Route::put('contact/{id}','EmployeeContactController@updateContact');


    Route::get('health/{id}','EmployeeHealthController@getHealth');
    
    Route::put('health/{id}','EmployeeHealthController@updateHealth');


    Route::get('government/{id}','EmployeeGovernmentController@getGovernment');
    
    Route::put('government/{id}','EmployeeGovernmentController@updateGovernment');


    Route::get('account/{id}','EmployeeAccountController@getAccount');

    Route::post('verify/username','EmployeeAccountController@verifyUsername');

    Route::put('username/{id}','EmployeeAccountController@updateAccountUsername');

    Route::put('account/status/{id}','EmployeeAccountController@updateAccountStatus');

    Route::put('account/reset/{id}','EmployeeAccountController@updateAccountResetPassword');


    Route::get('license/{id}','EmployeeLicenseController@getLicenses');

    Route::post('license/verify','EmployeeLicenseController@verifyLicenses');

    Route::post('license/{id}','EmployeeLicenseController@storeLicense');

    Route::put('license/{id}','EmployeeLicenseController@updateLicense');


    Route::get('training/{id}','EmployeeTrainingController@getTrainings');

    Route::post('training/{id}','EmployeeTrainingController@storeTraining');

    Route::put('training/{id}','EmployeeTrainingController@updateTraining');


    Route::get('club/{id}','EmployeeClubController@getClubs');

    Route::post('club/{id}','EmployeeClubController@storeClub');

    Route::put('club/{id}','EmployeeClubController@updateClub');


    Route::get('compensations/{id}','EmployeeCompensationsController@index');

    Route::post('compensations/verify/{empId}','EmployeeCompensationsController@verify');
    
    Route::post('compensations/{id}','EmployeeCompensationsController@store');

    Route::put('compensations/{id}','EmployeeCompensationsController@update');


    Route::get('contract/history/{id}','EmployeeContractHistoryController@index');

    Route::post('contract/history/{id}','EmployeeContractHistoryController@store');

    Route::put('contract/history/{id}','EmployeeContractHistoryController@update');


    Route::get('education/primary/{id}','EmployeeEducationPrimaryController@index');

    Route::put('education/primary/{id}','EmployeeEducationPrimaryController@update');


    Route::get('education/secondary/{id}','EmployeeEducationSecondaryController@index');

    Route::put('education/secondary/{id}','EmployeeEducationSecondaryController@update');


    Route::get('education/tertiary/{id}','EmployeeEducationTertiaryController@index');

    Route::post('education/tertiary/{id}','EmployeeEducationTertiaryController@store');

    Route::put('education/tertiary/{id}','EmployeeEducationTertiaryController@update');


    Route::get('education/highest/{id}','EmployeeEducationHighestController@index');

    Route::post('education/highest/{id}','EmployeeEducationHighestController@store');

    Route::put('education/highest/{id}','EmployeeEducationHighestController@update');


    Route::get('education/vocational/{id}','EmployeeEducationVocationalController@index');

    Route::post('education/vocational/{id}','EmployeeEducationVocationalController@store');

    Route::put('education/vocational/{id}','EmployeeEducationVocationalController@update');

});




Route::group(['prefix' => 'user'], function () {

    Route::post('profile/changePassword', "UserController@changePassword");

    Route::post('profile/changeProfilePicture',"UserController@changeProfilePicture");

});