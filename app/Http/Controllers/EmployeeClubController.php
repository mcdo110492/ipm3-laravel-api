<?php

namespace Ipm\Http\Controllers;

use Illuminate\Http\Request;

use Ipm\EmployeeClubInfo;

class EmployeeClubController extends Controller
{
    
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
