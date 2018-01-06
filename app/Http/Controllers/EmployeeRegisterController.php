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
use Ipm\EmployeeEducationPrimary;
use Ipm\EmployeeEducationSecondary;

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
            'employeeNumber'        => 'required|max:20|unique:employeePersonalInfo,employeeNumber',
            'firstName'             => 'required|max:150',
            'middleName'            => 'required|max:150',
            'lastName'              => 'required|max:150',
            'birthday'              => 'required|date',
            'placeOfBirth'          => 'required|max:150',
            'civilStatus'           => 'required|max:50',
            'citizenship'           => 'required|max:50',
            'religion'              => 'required|max:150',
            'positionId'            => 'required',
            'employeeStatusId'      => 'required',
            'employmentStatusId'    => 'required',
            'dateHired'             => 'required|date',
            'contractStart'         => 'required|date',
            'contractEnd'           => 'required|date',
            'contractTypeId'        => 'required'
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

            EmployeePersonalInfo::create($personalData);
                    
            $employeeId     =   $personal->employeeId;
                    
            $employementData = [
                'employeeId'            =>  $employeeId,
                'positionId'            =>  $request['positionId'],
                'employeeStatusId'      =>  $request['employeeStatusId'],
                'employmentStatusId'    =>  $request['employmentStatusId'],
                'dateHired'             =>  $request['dateHired'],
                'contractStart'         =>  $request['contractStart'],
                'contractEnd'           =>  $request['contractEnd'],
                'contractTypeId'        =>  $request['contractTypeId'],
                'remarks'               =>  $na
                    
            ];
                    
            EmployeeEmploymentInfo::create($employementData);
                            
            $contactData    =   [
                'employeeId'            =>  $employeeId,
                'presentAddress'        =>  $na,
                'provincialAddress'     =>  $na,
                'primaryMobileNumber'   =>  $na,
                'secondaryMobileNumber' =>  $na,
                'telephoneNumber'       =>  $na,
                'mobileNumber'          =>  $na
            ];
                    
            EmployeeContactInfo::create($contactData);

            $governmentData =   [
                'employeeId'        =>  $employeeId,
                'sssNumber'         =>  $na,
                'philHealthNumber'  =>  $na,
                'pagIbigNumber'     =>  $na,
                'tinNumber'         =>  $na
            ];

            EmployeeGovernmentInfo::create($governmentData);

            $healthData     =   [
                'employeeId'    =>  $employeeId,
                'weight'        =>  $na,
                'height'        =>  $na,
                'bloodType'     =>  $na
            ];

            EmployeeHealthInfo::create($healthData);

            $accountData = [
                'employeeId'    =>  $employeeId,
                'username'      =>  $request['employeeNumber'],
                'password'      =>  $request['employeeNumber']
            ];

            EmployeeAccountInfo::create($accountData);

            $educPrimaryData = [
                'employeeId'            =>  $employeeId,
                'educPrimarySchool'     =>  $na,
                'educPrimaryAddress'    =>  $na,
                'educPrimaryYear'       =>  $na
            ];

            EmployeeEducationPrimary::create($educPrimaryData);


            $educSecondaryData = [
                'employeeId'            =>  $employeeId,
                'educSecondarySchool'   =>  $na,
                'educSecondaryAddress'  =>  $na,
                'educSecondaryYear'     =>  $na
            ];

            EmployeeEducationSecondary::create($educSecondaryData);
            
        });

        return response()->json([ 'status'  =>  201, 'message'  =>  'Created' ]);

    }

}
