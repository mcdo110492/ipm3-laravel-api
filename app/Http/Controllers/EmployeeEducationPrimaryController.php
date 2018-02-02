<?php

namespace Ipm\Http\Controllers;

use Illuminate\Http\Request;
use Ipm\EmployeeEducationPrimary;

class EmployeeEducationPrimaryController extends Controller
{
    public function index($id){

        $employeeId = $id;

        $query = EmployeeEducationPrimary::where('employeeId','=',$id)->get()->first();

        return response()->json(['status' => 200, 'data' => $query]);
    }

    public function update(Request $request, $id){

        $query = EmployeeEducationPrimary::findOrFail($id);

        $validateData = $request->validate([
            'educPrimarySchool'     =>  'required|max:150',
            'educPrimaryAddress'    =>  'required|max:150',
            'educPrimaryYear'       =>  'required|max:20'
        ]);

        $query->update($validateData);

        return response()->json(['status' => 200, 'message' => 'Success']);
    }
}
