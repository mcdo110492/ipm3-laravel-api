<?php

namespace Ipm\Http\Controllers;

use Illuminate\Http\Request;

use Ipm\EmployeeEmploymentInfo;


class EmployeeEmploymentController extends Controller
{

    public function getEmployment($id) {
        
        $get = EmployeeEmploymentInfo::where('employeeId','=',$id)->get()->first();

        return response()->json([ 'status' => 200, 'data' => $get ]);
        
    }

    public function updateEmployment(Request $request, $id) {

        $employment = EmployeeEmploymentInfo::findOrFail($id);

        $validatedData = $request->validate([
            'positionId'            =>  'required',
            'employeeStatusId'      =>  'required',
            'employmentStatusId'    =>  'required',
            'contractStart'         =>  'required|date',
            'contractEnd'           =>  'required|date',
            'salary'                =>  'required',
            'remarks'               =>  'required'
        ]);
   

        $employment->update($validatedData);

        
        return response()->json([ 'status' => 200, 'message' => 'Updated' ]);
    }

    
}
