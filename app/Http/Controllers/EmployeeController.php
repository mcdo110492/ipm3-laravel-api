<?php

namespace Ipm\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use Ipm\EmployeePersonalInfo;
use Ipm\EmployeeEmploymentInfo;
use Ipm\EmployeeContactInfo;
use Ipm\EmployeeGovernmentInfo;
use Ipm\EmployeeHealthInfo;
use Ipm\EmployeeLicenseInfo;
use Ipm\EmployeeEducationInfo;
use Ipm\EmployeeTrainingInfo;
use Ipm\EmployeeClubInfo;

use JWTAuth;

class EmployeeController extends Controller
{
    protected $projectId;

    protected $role;

    public function __construct() {

        $token = JWTAuth::parseToken()->authenticate();

        $this->projectId = $token->projectId;

        $this->role = $token->role;
    }

    public function index(Request $request){
        $limit      = $request['limit'];
        $limitPage  = $request['page'] - 1;
        $offset     = $limit * $limitPage;
        $order      = strtoupper($request['order']);
        $field      = $request['field'];
        $filter     = $request['filter'];
        $project    = ($this->role == 1) ? $request['projectId'] : $this->projectId;

        $count      = EmployeePersonalInfo::where('projectId','=',$project)->count();
        $get        = DB::table('employeePersonalInfo as ep')
                      ->leftJoin('employeeEmploymentInfo as ee','ee.employeeId','=','ep.employeeId')
                      ->leftJoin('positions as p','p.positionId','=','ee.positionId')
                      ->leftJoin('employeeStatus as es','es.employeeStatusId','=','ee.employeeStatusId')
                      ->leftJoin('employmentStatus as emps','emps.employmentStatusId','=','ee.employmentStatusId')
                      ->where('ep.projectId','=',$project)
                      ->where(function ($q) use($filter) {
                        $q->where('ep.employeeNumber','LIKE','%'.$filter.'%')
                          ->orWhere('ep.firstName','LIKE','%'.$filter.'%')
                          ->orWhere('ep.middleName','LIKE','%'.$filter.'%')
                          ->orWhere('ep.lastName','LIKE','%'.$filter.'%')
                          ->orWhere('p.positionName','LIKE','%'.$filter.'%');
                      })
                      ->take($limit)
                      ->skip($offset)
                      ->orderBy('ep.'.$field,$order)
                      ->get();

        return response()->json([ 'status'  =>  200, 'count' => $count, 'data' =>  $get ]);
    }

    public function store(Request $request){
        
        $request->validate([
            'employeeNumber'        => 'required|unique:employeePersonalInfo,employeeNumber',
            'firstName'             => 'required',
            'middleName'            => 'required',
            'lastName'              => 'required',
            'birthday'              => 'required',
            'positionId'            => 'required',
            'employeeStatusId'      => 'required',
            'employmentStatusId'    => 'required',
            'contractStart'         => 'required',
            'contractEnd'           => 'required'
        ]);

        

        DB::transaction(function () use ($request) {

            $project = ( $this->role == 1 ) ? $request['projectId'] : $this->projectId;
            
            $na = 'N/A'; // not available
            
            $personalData = [
                'employeeNumber'    =>  $request['employeeNumber'],
                'firstName'         =>  $request['firstName'],
                'middleName'        =>  $request['middleName'],
                'lastName'          =>  $request['lastName'],
                'birthday'          =>  $request['birthday'],
                'placeOfBirth'      => $na,
                'civilStatus'       => $na,
                'citizenship'       => $na,
                'religion'          => $na,
                'projectId'         => $project
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
            
        });

        return response()->json([ 'status'  =>  201, 'message'  =>  'Created' ]);

    }

    public function getContact($id){

        $get = EmployeeContactInfo::where('employeeId','=',$id)->get();

        return response()->json([ 'status' => 200, 'data' => $get ]);

    }

    public function updateContact(Request $request, $id){

        $validatedData = $request->validate([
            'presentAddress'    =>    'required|max:150',
            'provincialAddress' =>    'required|max:150',
            'mobileNumber'      =>    'required|max:50',
            'telephoneNumber'   =>    'required|max:50'
        ]);

        EmployeeContactInfo::where('employeeContactId','=',$id)->update($validatedData);

        return response()->json([ 'status' => 200, 'message' => 'Updated' ]);

    }

    public function getHealth($id){

        $get = EmployeeHealthInfo::where('employeeId','=',$id)->get();

        return response()->json([ 'status' => 200, 'data' => $get ]);
    }

    public function updateHealth(Request $request, $id){

        $validatedData = $request->validate([
            'height'    =>  'required',
            'weight'    =>  'required',
            'bloodType' =>  'required'
        ]);

        EmployeeHealthInfo::where('employeeHealthId','=',$id)->update($validatedData);

        return response()->json([ 'status' => 200, 'message' => 'Updated' ]);

    }

    public function getGovernment($id){

        $get = EmployeeGovernmentInfo::where('employeeId','=',$id)->get();

        return response()->json([ 'status' => 200, 'data' => $get ]);

    }

    public function updateGovernment(Request $request, $id){

        $validatedData = $request->validate([
            'sssNumber'         =>  'required',
            'pagIbigNumber'     =>  'required',
            'philHealthNumber'  =>  'required',
            'tinNumber'         =>  'required'
        ]);

        EmployeeGovernmentInfo::where('employeeGovernmentId','=',$id)->update($validatedData);

        return response()->json([ 'status' => 200, 'message' => 'Updated' ]);

    }

    public function getAccount($id){

        $get = EmployeeAccountInfo::where('employeeId','=',$id)->get();

        return response()->json([ 'status' => 200, 'data' => $get ]);
    }

    public function updateAccountUsername(Request $request, $id){

        $validatedData = $request->validate([
            'username'  =>  [ 'required',
                              Rule::unique('employeeAccountInfo')->ignore($id,'employeeAccountId')
            ]
        ]);
        
        EmployeeAccountInfo::where('employeeAccountId','=',$id)->update($validatedData);

        return response()->json([ 'status' => 200, 'message' => 'Updated' ]);
    }

    public function updateAccountStatus(Request $request, $id){

        $validatedData = $request->validate([
            'status'    =>  'required|numeric'
        ]);

        EmployeeAccountInfo::where('employeeAccountId','=',$id)->update($validatedData);

        return response()->json([ 'status' => 200, 'message' => 'Status has been change' ]);

    }

    public function updateAccountResetPassword(Request $request, $id){

        $get = EmployeeAccountInfo::where('employeeAccountId','=',$id)->get();

        $username = $get->username;

        $newPassword = Hash::make($username);

        $data = [
            'password' => $newPassword
        ];

        EmployeeAccountInfo::where('employeeAccountId','=',$id)->update($data);

        return response()->json([ 'status' => 200 , 'message' => 'Password has been reset. And the new password is the username.' ]);
        
    }

    public function getLicenses($id){

        $get = EmployeeLicenseInfo::where('employeeId','=',$id)->get();

        return response()->json([ 'status' => 200, 'data' => $get ]);
    }

    public function storeLicense(Request $request){

        $validatedData = $request->validate([
            'employeeId'        =>  'required|integer',
            'licenseNumber'     =>  'required|unique:employeeLicenseInfo,licenseNumber',
            'licenseType'       =>  'required',
            'dateIssued'        =>  'required|date',
            'dateExpiry'        =>  'required|date',
            'licenseImage'      =>  'required'
        ]);

        $data = [
            'employeeId'        =>  $request['employeeId'],
            'licenseNumber'     =>  $request['licenseNumber'],
            'licenseType'       =>  $request['licenseType'],
            'dateIssued'        =>  $request['dateIssued'],
            'dateExpiry'        =>  $request['dateExpiry']
        ];

        EmployeeLicenseInfo::create($data);

        return response()->json([ 'status' => 201, 'message' => 'Created' ]);

    }

    public function updateLicense(Request $request, $id){

        $validatedData = $request->validate([
            'licenseNumber' =>  [ 'required',
                                   Rule::unique('employeeLicenseInfo')->ignore($id,'employeeLicenseId')
            ],
            'licenseType'   =>  'required',
            'dateIssued'    =>  'required|date',
            'dateExpiry'    =>  'required|date'
        ]);

        $data = [
            'employeeId'        =>  $request['employeeId'],
            'licenseNumber'     =>  $request['licenseNumber'],
            'licenseType'       =>  $request['licenseType'],
            'dateIssued'        =>  $request['dateIssued'],
            'dateExpiry'        =>  $request['dateExpiry']
        ];

        EmployeeLicenseInfo::where('employeeLicenseId','=',$id)->update($data);

        return response()->json([ 'status' => 200, 'message' => 'Updated' ]);

    }

    public function getEducations($id){

        $get = EmployeeEducationInfo::where('employeeId','=',$id)->get();

        return response()->json([ 'status' => 200, 'data' => $get ]);

    }

    public function storeEducation(Request $request){

        $validatedData = $request->validate([
            'employeeId'    =>  'required|integer',
            'schoolName'    =>  'required|max:150',
            'schoolAddress' =>  'required|max:150',
            'schoolYear'    =>  'required|max:20',
            'degree'        =>  'required|max:150',
            'major'         =>  'required|max:150',
            'minor'         =>  'required|max:150',
            'awards'        =>  'required|max:150'
        ]);

        EmployeeEducationInfo::create($validatedData);

        return response()->json([ 'status' => 201, 'message' => 'Created' ]);

    }

    public function updateEducation(Request $request, $id){

        $validatedData = $request->validate([
            'schoolName'    =>  'required|max:150',
            'schoolAddress' =>  'required|max:150',
            'schoolYear'    =>  'required|max:20',
            'degree'        =>  'required|max:150',
            'major'         =>  'required|max:150',
            'minor'         =>  'required|max:150',
            'awards'        =>  'required|max:150'
        ]);

        EmployeeEducationInfo::where('employeeEducationId','=',$id)->update($validatedData);

        return response()->json([ 'status' => 200, 'message' => 'Updated' ]);

    }


    public function getTrainings($id){

        $get = EmployeeTrainingInfo::where('employeeId','=',$id)->get();

        return response()->json([ 'status' => 200, 'data' => $get ]);
    }

    public function storeTraining(Request $request){

        $validate = $request->validate([
            'employeeId'    =>  'required|integer',
            'trainingName'  =>  'required|max:150',
            'trainingTitle' =>  'required|max:150',
            'trainingFrom'  =>  'required|date',
            'trainingTo'    =>  'required|date'
        ]);

        $data = [
            'employeeId'    =>  $request['employeeId'],
            'trainingName'  =>  $request['trainingName'],
            'trainingTitle' =>  $request['trainingTitle'],
            'trainingFrom'  =>  $request['trainingFrom'],
            'trainingTo'    =>  $request['trainingTo']
        ];

        EmployeeTrainingInfo::create($data);

        return response()->json([ 'status' => 201, 'message' => 'Created' ]);

    }

    public function updateTraining(Request $request, $id){

        $validate = $request->validate([
            'trainingName'  =>  'required|max:150',
            'trainingTitle' =>  'required|max:150',
            'trainingFrom'  =>  'required|date',
            'trainingTo'    =>  'required|date'
        ]);

        $data = [
            'trainingName'  =>  $request['trainingName'],
            'trainingTitle' =>  $request['trainingTitle'],
            'trainingFrom'  =>  $request['trainingFrom'],
            'trainingTo'    =>  $request['trainingTo']
        ];

        EmployeeTrainingInfo::where('employeeTrainingId','=',$id)->update($data);

        return response()->json([ 'status' => 200, 'message' => 'Updated' ]);

    }

    public function getClubs($id){

        
        $get = EmployeeClubInfo::where('employeeId','=',$id)->get();

        return response()->json([ 'status' => 200, 'data' => $get ]);

    }

    public function storeClub(Request $request){

        $validate = $request->validate([
            'employeeId'        =>  'required|integer',
            'clubName'          =>  'required|max:150',
            'clubPosition'      =>  'required|max:150',
            'membershipDate'    =>  'required|date'
        ]);

        $data = [
            'employeeId'        =>  $request['employeeId'],
            'clubName'          =>  $request['clubName'],
            'clubPosition'      =>  $request['clubPosition'],
            'membershipDate'    =>  $reqeust['membershipDate']
        ];

        EmployeeClubInfo::create($data);

        return response()->json([ 'status' => 201, 'message' => 'Created' ]);

    }

    public function updateClub(Request $request, $id){

        $validate = $request->validate([
            'clubName'          =>  'required|max:150',
            'clubPosition'      =>  'required|max:150',
            'membershipDate'    =>  'required|date'
        ]);

        $data = [
            'clubName'          =>  $request['clubName'],
            'clubPosition'      =>  $request['clubPosition'],
            'membershipDate'    =>  $reqeust['membershipDate']
        ]; 

        EmployeeClubInfo::where('employeeClubId','=',$id)->update($data);

        return response()->json([ 'status' => 200, 'message' => 'Updated' ]);

    }

}
