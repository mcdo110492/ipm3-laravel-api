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

    /**
     * Changes in update using findOrFail method before validation to ensure that the id exist before validating or return a 404 error
     * Change in creating method use array_prepend() to add the employeeId in the validated data array
     * Use a model in update by using findOrFail and then update so that you can access the mutators in every model before updating
     */

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

        $select     = 'ep.employeeId, ep.employeeNumber, ep.firstName, ep.middleName, ep.lastName, ep.profileImage, p.positionName, es.employeeStatusName, emps.employmentStatusName';

        $count      = EmployeePersonalInfo::where('projectId','=',$project)->count();
        $get        = DB::table('employeePersonalInfo as ep')
                      ->selectRaw($select)
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

    public function verify(Request $request){
        $value = $request['keyValue'];
        $id    = $request['keyId'];
        $status = 200;

        if($id == 0){
            $count = EmployeePersonalInfo::where('employeeNumber','=',$value)->count();

            ($count>0) ? $status = 422 : $status = 200;
        }
        else {

            $count = EmployeePersonalInfo::where('employeeNumber','=',$value)->where('employeeId','!=',$id)->count();

            ($count>0) ? $status = 422 : $status = 200;
        }

        return response()->json(compact('status'));
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
            
        });

        return response()->json([ 'status'  =>  201, 'message'  =>  'Created' ]);

    }

    public function getProfile($id){

        if($this->role == 1){
            $get = EmployeePersonalInfo::where('employeeId','=',$id)->get()->first();
        }
        else{
            $count = EmployeePersonalInfo::where('employeeId','=',$id)->where('projectId','=',$this->projectId)->count();
            if($count == 0){
                return response()->json(['status' => 404, 'message' => 'Not Found'],404);
            }
            $get = EmployeePersonalInfo::where('employeeId','=',$id)->where('projectId','=',$this->projectId)->get()->first();
        }

        return response()->json([ 'status' => 200, 'data' => $get ]);
    }

    public function updateProfile(Request $request, $id){

        $personal = EmployeePersonalInfo::findOrFail($id);

        $validatedData = $request->validate([
            'employeeNumber'    =>  ['required',
                                     Rule::unique('employeePersonalInfo')->ignore($id,'employeeId')],
            'firstName'         =>  'required',
            'middleName'        =>  'required',
            'lastName'          =>  'required',
            'birthday'          =>  'required',
            'placeOfBirth'      =>  'required',
            'civilStatus'       =>  'required',
            'citizenship'       =>  'required',
            'religion'          =>  'required'
        ]);
        

        $personal->update($validatedData);


        return response()->json([ 'status' => 200, 'message' => 'Updated' ]);

    }

    public function getEmployment($id){
        
        $get = EmployeeEmploymentInfo::where('employeeId','=',$id)->get()->first();

        return response()->json([ 'status' => 200, 'data' => $get ]);
        
    }

    public function updateEmployment(Request $request, $id){

        $employment = EmployeeEmploymentInfo::findOrFail($id);

        $validatedData = $request->validate([
            'positionId'            =>  'required',
            'employeeStatusId'      =>  'required',
            'employmentStatusId'    =>  'required',
            'contractStart'         =>  'required',
            'contractEnd'           =>  'required',
            'salary'                =>  'required',
            'remarks'               =>  'required'
        ]);
   

        $employment->update($validatedData);

        
        return response()->json([ 'status' => 200, 'message' => 'Updated' ]);
    }

    public function getContact($id){

        $get = EmployeeContactInfo::where('employeeId','=',$id)->get()->first();

        return response()->json([ 'status' => 200, 'data' => $get ]);

    }

    public function updateContact(Request $request, $id){

        $contact = EmployeeContactInfo::findOrFail($id);

        $validatedData = $request->validate([
            'presentAddress'    =>    'required|max:150',
            'provincialAddress' =>    'required|max:150',
            'mobileNumber'      =>    'required|max:50',
            'telephoneNumber'   =>    'required|max:50'
        ]);


        $contact->update($validatedData);

        return response()->json([ 'status' => 200, 'message' => 'Updated' ]);

    }

    public function getHealth($id){

        $get = EmployeeHealthInfo::where('employeeId','=',$id)->get()->first();

        return response()->json([ 'status' => 200, 'data' => $get ]);
    }

    public function updateHealth(Request $request, $id){

        $health = EmployeeHealthInfo::findOrFail($id);

        $validatedData = $request->validate([
            'height'    =>  'required',
            'weight'    =>  'required',
            'bloodType' =>  'required'
        ]);


        $health->update($validatedData);

        return response()->json([ 'status' => 200, 'message' => 'Updated' ]);

    }

    public function getGovernment($id){

        $get = EmployeeGovernmentInfo::where('employeeId','=',$id)->get()->first();

        return response()->json([ 'status' => 200, 'data' => $get ]);

    }

    public function updateGovernment(Request $request, $id){

        $government = EmployeeGovernmentInfo::findOrFail($id);

        $validatedData = $request->validate([
            'sssNumber'         =>  'required',
            'pagIbigNumber'     =>  'required',
            'philHealthNumber'  =>  'required',
            'tinNumber'         =>  'required'
        ]);

        $government->update($validatedData);

        return response()->json([ 'status' => 200, 'message' => 'Updated' ]);

    }

    public function getAccount($id){

        $get = EmployeeAccountInfo::where('employeeId','=',$id)->get();

        return response()->json([ 'status' => 200, 'data' => $get ]);
    }

    public function updateAccountUsername(Request $request, $id){

        $account = EmployeeAccountInfo::findOrFail($id);

        $validatedData = $request->validate([
            'username'  =>  [ 'required',
                              Rule::unique('employeeAccountInfo')->ignore($id,'employeeAccountId')
            ]
        ]);

        $account->update($validatedData);

        return response()->json([ 'status' => 200, 'message' => 'Updated' ]);
    }

    public function updateAccountStatus(Request $request, $id){

        $account = EmployeeAccountInfo::findOrFail($id);

        $validatedData = $request->validate([
            'status'    =>  'required|numeric'
        ]);

        $account->update($validatedData);

        return response()->json([ 'status' => 200, 'message' => 'Status has been change' ]);

    }

    public function updateAccountResetPassword(Request $request, $id){

        $account = EmployeeAccountInfo::findOrFail($id);

        $get    = $account->get();

        $username = $get->username;

        $data = [
            'password' => $username
        ];

        $account->update($data);

        return response()->json([ 'status' => 200 , 'message' => 'Password has been reset. And the new password is the username.' ]);
        
    }

    public function getLicenses($id){

        $get = EmployeeLicenseInfo::where('employeeId','=',$id)->get();

        return response()->json([ 'status' => 200, 'data' => $get ]);
    }

    public function verifyLicenses(Request $request){
        $value = $request['keyValue'];
        $id    = $request['keyId'];
        $status = 200;

        if($id == 0){
            $count = EmployeeLicenseInfo::where('licenseNumber','=',$value)->count();

            ($count>0) ? $status = 422 : $status = 200;
        }
        else {

            $count = EmployeeLicenseInfo::where('licenseNumber','=',$value)->where('employeeLicenseId','!=',$id)->count();

            ($count>0) ? $status = 422 : $status = 200;
        }

        return response()->json(compact('status'));
    }

    public function storeLicense(Request $request, $id){

        $validatedData = $request->validate([
            'licenseNumber'     =>  'required|unique:employeeLicenseInfo,licenseNumber',
            'licenseType'       =>  'required',
            'dateIssued'        =>  'required|date',
            'dateExpiry'        =>  'required|date'
        ]);
        
        $newData                =   array_prepend($validatedData,$id,'employeeId');

        EmployeeLicenseInfo::create($newData);

        return response()->json([ 'status' => 201, 'message' => 'Created' ]);

    }

    public function updateLicense(Request $request, $id){

        $license = EmployeeLicenseInfo::findOrFail($id);

        $validatedData = $request->validate([
            'licenseNumber' =>  [ 'required',
                                   Rule::unique('employeeLicenseInfo')->ignore($id,'employeeLicenseId')
            ],
            'licenseType'   =>  'required',
            'dateIssued'    =>  'required|date',
            'dateExpiry'    =>  'required|date'
        ]);

        $license->update($validatedData);

        return response()->json([ 'status' => 200, 'message' => 'Updated' ]);

    }

    public function getEducations($id){

        $get = EmployeeEducationInfo::where('employeeId','=',$id)->get();

        return response()->json([ 'status' => 200, 'data' => $get ]);

    }

    public function storeEducation(Request $request, $id){

        $validatedData = $request->validate([
            'schoolName'    =>  'required|max:150',
            'schoolAddress' =>  'required|max:150',
            'schoolYear'    =>  'required|max:20',
            'degree'        =>  'required|max:150',
            'major'         =>  'required|max:150',
            'minor'         =>  'required|max:150',
            'awards'        =>  'required|max:150'
        ]);

        $newData                =   array_prepend($validatedData,$id,'employeeId');

        EmployeeEducationInfo::create($newData);

        return response()->json([ 'status' => 201, 'message' => 'Created' ]);

    }

    public function updateEducation(Request $request, $id){

        $education = EmployeeEducationInfo::findOrFail($id);

        $validatedData = $request->validate([
            'schoolName'    =>  'required|max:150',
            'schoolAddress' =>  'required|max:150',
            'schoolYear'    =>  'required|max:20',
            'degree'        =>  'required|max:150',
            'major'         =>  'required|max:150',
            'minor'         =>  'required|max:150',
            'awards'        =>  'required|max:150'
        ]);

        $education->update($validatedData);

        return response()->json([ 'status' => 200, 'message' => 'Updated' ]);

    }


    public function getTrainings($id){

        $get = EmployeeTrainingInfo::where('employeeId','=',$id)->get();

        return response()->json([ 'status' => 200, 'data' => $get ]);
    }

    public function storeTraining(Request $request,$id){

        $validatedData = $request->validate([
            'trainingName'  =>  'required|max:150',
            'trainingTitle' =>  'required|max:150',
            'trainingFrom'  =>  'required|date',
            'trainingTo'    =>  'required|date'
        ]);

        $newData                =   array_prepend($validatedData,$id,'employeeId');


        EmployeeTrainingInfo::create($newData);

        return response()->json([ 'status' => 201, 'message' => 'Created' ]);

    }

    public function updateTraining(Request $request, $id){

        $training = EmployeeTrainingInfo::findOrFail($id);

        $validatedData = $request->validate([
            'trainingName'  =>  'required|max:150',
            'trainingTitle' =>  'required|max:150',
            'trainingFrom'  =>  'required|date',
            'trainingTo'    =>  'required|date'
        ]);

        $training->update($validatedData);

        return response()->json([ 'status' => 200, 'message' => 'Updated' ]);

    }

    public function getClubs($id){

        
        $get = EmployeeClubInfo::where('employeeId','=',$id)->get();

        return response()->json([ 'status' => 200, 'data' => $get ]);

    }

    public function storeClub(Request $request,$id){

        $validatedData = $request->validate([
            'clubName'          =>  'required|max:150',
            'clubPosition'      =>  'required|max:150',
            'membershipDate'    =>  'required|date'
        ]);

        $newData                =   array_prepend($validatedData,$id,'employeeId');


        EmployeeClubInfo::create($newData);

        return response()->json([ 'status' => 201, 'message' => 'Created' ]);

    }

    public function updateClub(Request $request, $id){

        $club = EmployeeClubInfo::findOrFail($id);

        $validatedData = $request->validate([
            'clubName'          =>  'required|max:150',
            'clubPosition'      =>  'required|max:150',
            'membershipDate'    =>  'required|date'
        ]);
        
        $club->update($validatedData);

        return response()->json([ 'status' => 200, 'message' => 'Updated' ]);

    }

}
