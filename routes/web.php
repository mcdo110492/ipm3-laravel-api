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

    Route::post('verifyPosition','PositionsController@verifyData');

    Route::put('{id}', 'PositionsController@update' );

});

Route::group([ 'prefix' => 'employmentStatus' ], function () {
    
    Route::get('all','EmploymentStatusController@all');

    Route::get('', 'EmploymentStatusController@index' );

    Route::post('', 'EmploymentStatusController@store' );

    Route::post('verify','EmploymentStatusController@verifyData');

    Route::put('{id}', 'EmploymentStatusController@update' );

});

Route::group([ 'prefix' => 'employeeStatus' ], function () {

    Route::get('all','EmployeeStatusController@all');
    
    Route::get('', 'EmployeeStatusController@index' );

    Route::post('', 'EmployeeStatusController@store' );

    Route::post('verify','EmployeeStatusController@verifyData');

    Route::put('{id}', 'EmployeeStatusController@update' );

});

Route::group([ 'prefix' => 'units' ], function () {
    
    Route::get('all','UnitsController@all');
        
    Route::get('', 'UnitsController@index' );
    
    Route::post('', 'UnitsController@store' );
    
    Route::post('verify','UnitsController@verifyData');
    
    Route::put('{id}', 'UnitsController@update' );
    
});

Route::group([ 'prefix' => 'collection/schedules' ], function () {
    
    Route::get('all','CollectionSchedulesController@all');
        
    Route::get('', 'CollectionSchedulesController@index' );
    
    Route::post('', 'CollectionSchedulesController@store' );
    
    Route::post('verify','CollectionSchedulesController@verifyData');
    
    Route::put('{id}', 'CollectionSchedulesController@update' );
    
});

Route::group([ 'prefix' => 'collection/types' ], function () {
    
    Route::get('all','CollectionTypesController@all');
        
    Route::get('', 'CollectionTypesController@index' );
    
    Route::post('', 'CollectionTypesController@store' );
    
    Route::post('verify','CollectionTypesController@verifyData');
    
    Route::put('{id}', 'CollectionTypesController@update' );
    
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


    Route::get('education/{id}','EmployeeEducationController@getEducations');

    Route::post('education/{id}','EmployeeEducationController@storeEducation');

    Route::put('education/{id}','EmployeeEducationController@updateEducation');


    Route::get('training/{id}','EmployeeTrainingController@getTrainings');

    Route::post('training/{id}','EmployeeTrainingController@storeTraining');

    Route::put('training/{id}','EmployeeTrainingController@updateTraining');


    Route::get('club/{id}','EmployeeClubController@getClubs');

    Route::post('club/{id}','EmployeeClubController@storeClub');

    Route::put('club/{id}','EmployeeClubController@updateClub');

});


// Equipment
Route::group([ 'prefix' => 'equipments' ], function () {
    
    Route::get('all','EquipmentsController@all');
        
    Route::get('', 'EquipmentsController@index' );
    
    Route::post('', 'EquipmentsController@store' );
    
    Route::post('verify','EquipmentsController@verifyData');
    
    Route::put('{id}', 'EquipmentsController@update' );

    Route::put('status/{id}', 'EquipmentsController@changeStatus' );
    
});

// GPS
Route::group([ 'prefix' => 'shifts' ], function () {
    
    Route::get('all','ShiftsController@all');
        
    Route::get('', 'ShiftsController@index' );
    
    Route::post('', 'ShiftsController@store' );
    
    Route::put('{id}', 'ShiftsController@update' );

    Route::post('upload/{id}','ShiftsController@upload');
    
});




