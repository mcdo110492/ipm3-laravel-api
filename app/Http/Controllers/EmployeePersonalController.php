<?php

namespace Ipm\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use Ipm\EmployeePersonalInfo;

use JWTAuth;

class EmployeePersonalController extends Controller
{

    protected $projectId;
    
    protected $role;
    
    
    public function __construct() {
    
        $token = JWTAuth::parseToken()->authenticate();
    
        $this->projectId = $token->projectId;
    
        $this->role = $token->role;
    }


    public function getPersonal(Request $request,$id) {

        
        if($this->role == 1){

            $get = EmployeePersonalInfo::where('employeeId','=',$id)->get()->first();

        }
        else {

            $count = EmployeePersonalInfo::where('employeeId','=',$id)->where('projectId','=',$this->projectId)->count();
                    
            if($count == 0) {

                return response()->json(['status' => 404, 'message' => 'Not Found'],404);
                    
            }

            $get = EmployeePersonalInfo::where('employeeId','=',$id)->where('projectId','=',$this->projectId)->get()->first();
        }
        
        return response()->json([ 'status' => 200, 'data' => $get ]);

    }

        
    public function updatePersonal(Request $request, $id) {
        
        $personal = EmployeePersonalInfo::findOrFail($id);
        
        $validatedData = $request->validate([
            'employeeNumber'    =>  ['required','max:20',
                                     Rule::unique('employeePersonalInfo')->ignore($id,'employeeId')],
            'firstName'         =>  'required|max:150',
            'middleName'        =>  'required|max:150',
            'lastName'          =>  'required|max:150',
            'birthday'          =>  'required|date',
            'placeOfBirth'      =>  'required|max:150',
            'civilStatus'       =>  'required|max:50',
            'citizenship'       =>  'required|max:50',
            'religion'          =>  'required|max:150'
        ]);
                
        
        $personal->update($validatedData);
        
        
        return response()->json([ 'status' => 200, 'message' => 'Updated' ]);
        
    }


}
