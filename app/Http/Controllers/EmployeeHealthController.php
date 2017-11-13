<?php

namespace Ipm\Http\Controllers;

use Illuminate\Http\Request;

use Ipm\EmployeeHealthInfo;


class EmployeeHealthController extends Controller
{
    

    public function getHealth($id) {
        
        $get = EmployeeHealthInfo::where('employeeId','=',$id)->get()->first();
        
        return response()->json([ 'status' => 200, 'data' => $get ]);
    }
        
    public function updateHealth(Request $request, $id) {
        
        $health = EmployeeHealthInfo::findOrFail($id);
        
        $validatedData = $request->validate([
            'height'    =>  'required',
            'weight'    =>  'required',
            'bloodType' =>  'required'
        ]);
        
        
        $health->update($validatedData);
        
        return response()->json([ 'status' => 200, 'message' => 'Updated' ]);
        
    }

}
