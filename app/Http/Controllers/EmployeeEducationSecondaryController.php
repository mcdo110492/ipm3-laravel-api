<?php

namespace Ipm\Http\Controllers;

use Illuminate\Http\Request;
use Ipm\EmployeeEducationSecondary;


class EmployeeEducationSecondaryController extends Controller
{
    public function index($id){

        $employeeId = $id;

        $query = EmployeeEducationSecondary::where('employeeId','=',$id)->get();

        return response()->json(['status' => 200, 'data' => $query]);
    }

    public function update(Request $request, $id){

        $query = EmployeeEducationSecondary::findOrFail($id);

        $validateData = $request->validate([
            'employeeId'              =>  'required',
            'educSecondarySchool'     =>  'required|max:150',
            'educSecondaryAddress'    =>  'required|max:150',
            'educSecondaryYear'       =>  'required|max:20'
        ]);

        $query->update($validateData);

        return response()->json(['status' => 200, 'message' => 'Success']);
    }
}
