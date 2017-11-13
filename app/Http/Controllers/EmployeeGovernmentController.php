<?php

namespace Ipm\Http\Controllers;

use Illuminate\Http\Request;

use Ipm\EmployeeGovernmentInfo;


class EmployeeGovernmentController extends Controller
{
    
    

    public function getGovernment($id){
        
        $get = EmployeeGovernmentInfo::where('employeeId','=',$id)->get()->first();
        
        return response()->json([ 'status' => 200, 'data' => $get ]);
        
    }
        
    public function updateGovernment(Request $request, $id){
        
        $government = EmployeeGovernmentInfo::findOrFail($id);
        
        $validatedData = $request->validate([
            'sssNumber'         =>  'required|max:20',
            'pagIbigNumber'     =>  'required|max:20',
            'philHealthNumber'  =>  'required|max:20',
            'tinNumber'         =>  'required|max:20'
        ]);
        
        $government->update($validatedData);
        
        return response()->json([ 'status' => 200, 'message' => 'Updated' ]);
        
    }

}
