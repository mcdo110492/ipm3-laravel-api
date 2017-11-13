<?php

namespace Ipm\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Ipm\EmployeePersonalInfo;
use Ipm\EmployeeEmploymentInfo;
use Ipm\EmployeeContactInfo;
use Ipm\EmployeeGovernmentInfo;
use Ipm\EmployeeHealthInfo;
use Ipm\EmployeeAccountInfo;

use JWTAuth;

class EmployeeRegisterController extends Controller
{
    protected $projectId;
    
    protected $role;
    
    
    public function __construct() {
    
        $token = JWTAuth::parseToken()->authenticate();
    
        $this->projectId = $token->projectId;
    
        $this->role = $token->role;
    }
    
    public function store(Request $request){
        
        $request->validate([
            'employeeNumber'        => 'required|unique:employeePersonalInfo,employeeNumber',
            'firstName'             => 'required',
            'middleName'            => 'required',
            'lastName'              => 'required',
            'birthday'              => 'required',
            'placeOfBirth'          => 'required',
            'civilStatus'           => 'required',
            'citizenship'           => 'required',
            'religion'              => 'required',
            'positionId'            => 'required',
            'employeeStatusId'      => 'required',
            'employmentStatusId'    => 'required',
            'contractStart'         => 'required',
            'contractEnd'           => 'required'
        ]);

        

        DB::transaction(function () use ($request) {

            $project =  ( $this->role == 1 ) ? $request['projectId'] : $this->projectId;
            
            $na = 'N/A'; // not available
            
            $personalData = [
                'employeeNumber'    =>  $request['employeeNumber'],
                'firstName'         =>  $request['firstName'],
                'middleName'        =>  $request['middleName'],
                'lastName'          =>  $request['lastName'],
                'birthday'          =>  $request['birthday'],
                'placeOfBirth'      =>  $request['placeOfBirth'],
                'civilStatus'       =>  $request['civilStatus'],
                'citizenship'       =>  $request['citizenship'],
                'religion'          =>  $request['religion'],
                'projectId'         =>  $project
            ];

            $personal   =   EmployeePersonalInfo::create($personalData);
                    
            $employeeId     =   $personal->employeeId;
                    
            $employementData = [
                'employeeId'            =>  $employeeId,
                'positionId'            =>  $request['positionId'],
                'employeeStatusId'      =>  $request['employeeStatusId'],
                'employmentStatusId'    =>  $request['employmentStatusId'],
                'contractStart'         =>  $request['contractStart'],
                'contractEnd'           =>  $request['contractEnd'],
                'salary'                =>  0.00,
                'remarks'               =>  $na
                    
            ];
                    
            $employment     =   EmployeeEmploymentInfo::create($employementData);
                            
            $contactData    =   [
                'employeeId'            =>  $employeeId,
                'presentAddress'        =>  $na,
                'provincialAddress'     =>  $na,
                'mobileNumber'          =>  $na,
                'telephoneNumber'       =>  $na,
                'mobileNumber'          =>  $na
            ];
                    
            $contact        =   EmployeeContactInfo::create($contactData);

            $governmentData =   [
                'employeeId'        =>  $employeeId,
                'sssNumber'         =>  $na,
                'philHealthNumber'  =>  $na,
                'pagIbigNumber'     =>  $na,
                'tinNumber'         =>  $na
            ];

            $government     =   EmployeeGovernmentInfo::create($governmentData);

            $healthData     =   [
                'employeeId'    =>  $employeeId,
                'weight'        =>  $na,
                'height'        =>  $na,
                'bloodType'     =>  $na
            ];

            $health     =   EmployeeHealthInfo::create($healthData);

            $accountData = [
                'employeeId'    =>  $employeeId,
                'username'      =>  $request['employeeNumber'],
                'password'      =>  $request['employeeNumber']
            ];

            $account = EmployeeAccountInfo::create($accountData);
            
        });

        return response()->json([ 'status'  =>  201, 'message'  =>  'Created' ]);

    }

}
