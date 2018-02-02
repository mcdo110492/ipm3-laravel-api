<?php

namespace Ipm\Http\Controllers;

use Illuminate\Http\Request;

use Ipm\EmployeeTrainingInfo;

class EmployeeTrainingController extends Controller
{
    
    public function getTrainings($id){
        
        $get = EmployeeTrainingInfo::where('employeeId','=',$id)->get();
        
        return response()->json([ 'status' => 200, 'data' => $get ]);
    }
        
    public function storeTraining(Request $request,$id){
        
        $validatedData = $request->validate([
            'trainingName'  =>  'required|max:150',
            'trainingTitle' =>  'required|max:150',
            'trainingFrom'  =>  'required|date',
            'trainingTo'    =>  'required|date'
        ]);
        
        $newData                =   array_prepend($validatedData,$id,'employeeId');
        
        
        $training = EmployeeTrainingInfo::create($newData);
        $created = EmployeeTrainingInfo::findOrFail($training->employeeTrainingId);

        return response()->json([ 'status' => 201, 'message' => 'Created', 'createdData' => $created ]);
        
    }
        
    public function updateTraining(Request $request, $id){
        
        $training = EmployeeTrainingInfo::findOrFail($id);
 
        $validatedData = $request->validate([
            'trainingName'  =>  'required|max:150',
            'trainingTitle' =>  'required|max:150',
            'trainingFrom'  =>  'required|date',
            'trainingTo'    =>  'required|date'
        ]);
        
        $training->update($validatedData);

        $get = EmployeeTrainingInfo::where('employeeTrainingId','=',$id)->get()->first();
        
        return response()->json([ 'status' => 200, 'message' => 'Updated', 'updatedData' => $get ]);
        
    }

}
