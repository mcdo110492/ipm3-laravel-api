<?php

namespace Ipm\Http\Controllers;

use Illuminate\Http\Request;
use Ipm\EmployeeEducationVocational;

class EmployeeEducationVocationalController extends Controller
{
    public function index($id){
        $employeeId = $id;

        $query = EmployeeEducationVocational::where('employeeId','=',$employeeId)->get();

        return response()->json(['status' => 200, 'data' => $query]);
    }

    public function store(Request $request, $id){
        $employeeId = $id;

        $request->validate([
            'educVocationalSchool'          =>  'required|max:150',
            'educVocationalAddress'         =>  'required|max:150',
            'educVocationalCourse'          =>  'required|max:150',
            'educVocationalYear'            =>  'required|max:20'
        ]);

        $data = [
            'employeeId'                =>  $employeeId,
            'educVocationalSchool'      =>  $request['educVocationalSchool'],
            'educVocationalAddress'     =>  $request['educVocationalAddress'],
            'educVocationalCourse'      =>  $request['educVocationalCourse'],
            'educVocationalYear'        =>  $request['educVocationalYear']
        ];

        $create = EmployeeEducationVocational::create($data);

        $get = EmployeeEducationVocational::findOrFail($create->educVocationalId);

        return response()->json(['status' => 200, 'createdData' => $get]);
    }

    public function update(Request $request, $id){

        $query = EmployeeEducationVocational::findOrFail($id);

        $request->validate([
            'educVocationalSchool'      =>  'required|max:150',
            'educVocationalAddress'     =>  'required|max:150',
            'educVocationalCourse'      =>  'required|max:150',
            'educVocationalYear'        =>  'required|max:20'
        ]);

        $data = ['educVocationalSchool' => $request['educVocationalSchool'],
                 'educVocationalAddress' => $request['educVocationalAddress'],
                 'educVocationalCourse' => $request['educVocationalCourse'],
                 'educVocationalYear' => $request['educVocationalYear']];

        $query->update($data);
        
        $get = EmployeeEducationVocational::findOrFail($id);
        

        return response()->json(['status' => 200, 'updatedData' => $get]);
    }
}
