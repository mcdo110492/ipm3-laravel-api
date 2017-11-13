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
        
        
        EmployeeTrainingInfo::create($newData);

        return response()->json([ 'status' => 201, 'message' => 'Created' ]);
        
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
        
        return response()->json([ 'status' => 200, 'message' => 'Updated' ]);
        
    }

}
