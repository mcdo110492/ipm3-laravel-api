<?php

namespace Ipm\Http\Controllers;

use Illuminate\Http\Request;
use Ipm\EmployeeEducationHighest;

class EmployeeEducationHighestController extends Controller
{
    
    public function index($id){
        $employeeId = $id;

        $query = EmployeeEducationHighest::where('employeeId','=',$employeeId)->get();

        return response()->json(['status' => 200, 'data' => $query]);
    }

    public function store(Request $request, $id){
        $employeeId = $id;

        $request->validate([
            'educHighestSchool'         =>  'required|max:150',
            'educHighestAddress'        =>  'required|max:150',
            'educHighestCourse'         =>  'required|max:150',
            'educHighestYear'           =>  'required|max:20'
        ]);

        $data = [
            'employeeId'             =>  $employeeId,
            'educHighestSchool'      =>  $request['educHighestSchool'],
            'educHighestAddress'     =>  $request['educHighestAddress'],
            'educHighestCourse'      =>  $request['educHighestCourse'],
            'educHighestYear'        =>  $request['educHighestYear']
        ];

        $create = EmployeeEducationHighest::create($data);

        $get = EmployeeEducationHighest::findOrFail($create->educHighestId);

        return response()->json(['status' => 200, 'createdData' => $get]);
    }

    public function update(Request $request, $id){
        $query = EmployeeEducationHighest::findOrFail($id);

        $validateData = $request->validate([
            'educHighestSchool'     =>  'required|max:150',
            'educHighestAddress'    =>  'required|max:150',
            'educHighestCourse'     =>  'required|max:150',
            'educHighestYear'       =>  'required|max:20'
        ]);

        $query->update($validateData);

        $get = EmployeeEducationHighest::findOrFail($id);

        return response()->json(['status' => 200, 'updatedData' => $get]);
    }
}
