<?php

namespace Ipm\Http\Controllers;

use Illuminate\Http\Request;

use Ipm\EmployeeContactInfo;


class EmployeeContactController extends Controller
{

    
    public function getContact($id) {
        
        $get = EmployeeContactInfo::where('employeeId','=',$id)->get()->first();
        
        return response()->json([ 'status' => 200, 'data' => $get ]);
        
    }
        
    public function updateContact(Request $request, $id) {
        
        $contact = EmployeeContactInfo::findOrFail($id);
        
        $validatedData = $request->validate([
            'presentAddress'           =>    'required|max:150',
            'provincialAddress'        =>    'required|max:150',
            'primaryMobileNumber'      =>    'required|max:50',
            'secondaryMobileNumber'    =>    'required|max:50',
            'telephoneNumber'          =>    'required|max:50'
        ]);
        
        
        $contact->update($validatedData);
        
        return response()->json([ 'status' => 200, 'message' => 'Updated' ]);
        
    }


}
