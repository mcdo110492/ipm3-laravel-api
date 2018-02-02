<?php

namespace Ipm\Http\Controllers;

use Illuminate\Http\Request;
use Ipm\EmployeeEducationTertiary;

class EmployeeEducationTertiaryController extends Controller
{
    public function index($id){
        $employeeId = $id;

        $query = EmployeeEducationTertiary::where('employeeId','=',$employeeId)->get();

        return response()->json(['status' => 200, 'data' => $query]);
    }

    public function store(Request $request, $id){
        $employeeId = $id;

        $request->validate([
            'educTertiarySchool'    =>  'required|max:150',
            'educTertiaryAddress'   =>  'required|max:150',
            'educTertiaryCourse'    =>  'required|max:150',
            'educTertiaryYear'      =>  'required|max:20'
        ]);

        $data = [
            'employeeId'            =>  $employeeId,
            'educTertiarySchool'    =>  $request['educTertiarySchool'],
            'educTertiaryAddress'   =>  $request['educTertiaryAddress'],
            'educTertiaryYear'      =>  $request['educTertiaryYear'],
            'educTertiaryCourse'    =>  $request['educTertiaryCourse']
        ];

        $tertiary = EmployeeEducationTertiary::create($data);

        $created = EmployeeEducationTertiary::findOrFail($tertiary->educTertiaryId);

        return response()->json(['status' => 200, 'createdData' => $created]);
    }

    public function update(Request $request, $id){

        $query = EmployeeEducationTertiary::findOrFail($id);

        $validatedData = $request->validate([
            'educTertiarySchool'        =>  'required|max:150',
            'educTertiaryAddress'       =>  'required|max:150',
            'educTertiaryCourse'        =>  'required|max:150',
            'educTertiaryYear'          =>  'required|max:20'
        ]);

        $query->update($validatedData);

        $get = EmployeeEducationTertiary::where('educTertiaryId','=',$id)->get()->first();

        return response()->json(['status' => 200 , 'updatedData' => $get]);
    }
}
