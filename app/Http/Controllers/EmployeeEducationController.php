<?php

namespace Ipm\Http\Controllers;

use Illuminate\Http\Request;

use Ipm\EmployeeEducationInfo;

class EmployeeEducationController extends Controller
{
    
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

}
