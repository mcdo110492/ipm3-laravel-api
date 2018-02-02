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


        $club = EmployeeClubInfo::create($newData);

        $created = EmployeeClubInfo::findOrFail($club->employeeClubId);

        return response()->json([ 'status' => 201, 'message' => 'Created', 'createdData' => $created ]);
        
    }
        
    public function updateClub(Request $request, $id){

        $club = EmployeeClubInfo::findOrFail($id);

        $validatedData = $request->validate([
            'clubName'          =>  'required|max:150',
            'clubPosition'      =>  'required|max:150',
            'membershipDate'    =>  'required|date'
         ]);
        
        $club->update($validatedData);

        $get = EmployeeClubInfo::where('employeeClubId','=',$id)->get()->first();

        return response()->json([ 'status' => 200, 'message' => 'Updated', 'updatedData' => $get ]);

    }

}
