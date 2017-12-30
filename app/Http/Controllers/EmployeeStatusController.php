<?php

namespace Ipm\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Ipm\EmployeeStatus;


class EmployeeStatusController extends Controller
{
    public function index(Request $request){
        
        $limit      = $request['limit'];
        $limitPage  = $request['page'] - 1;
        $offset     = $limit * $limitPage;
        $order      = strtoupper($request['order']);
        $field      = $request['field'];
        $filter     = $request['filter'];
        
        $query      = EmployeeStatus::where($field,'LIKE','%'.$filter.'%')->orWhere('employeeStatusCode','LIKE','%'.$filter.'%');
        $count      = $query->count();
        $get        = $query->take($limit)->skip($offset)->orderBy($field,$order)->get();
        
        return response()->json([ 'status' => 200, 'count' => $count, 'data' => $get ]);
        
    }

    public function all() {
        
        $get = EmployeeStatus::all();
        
        return response()->json([ 'status' => 200, 'data' => $get ]);
    }

    public function verifyData(Request $request){
        $value = $request['keyValue'];
        $id    = $request['keyId'];
        $keyField = $request['keyField'];
        $status = 200;

        if($id == 0){
            $count = EmployeeStatus::where($keyField,'=',$value)->count();

            ($count>0) ? $status = 422 : $status = 200;
        }
        else {

            $count = EmployeeStatus::where($keyField,'=',$value)->where('employeeStatusId','!=',$id)->count();

            ($count>0) ? $status = 422 : $status = 200;
        }

        return response()->json(compact('status'));
    }
        
         
    public function store(Request $request){
        
        $request->validate([
            'employeeStatusName'   =>  'required|max:150|unique:employeeStatus,employeeStatusName',
            'employeeStatusCode'   =>  'required|max:20|unique:employeeStatus,employeeStatusCode'
        ]);
        
        $data   =   [ 'employeeStatusName' =>  $request['employeeStatusName'] , 'employeeStatusCode' => $request['employeeStatusCode']];
        
        EmployeeStatus::create($data);
        
        return response()->json([ 'status'  =>  201 , 'message'   =>  'Created' ]);
        
    }
        
    public function update(Request $request, $id){
        
        $employeeStatus = EmployeeStatus::findOrFail($id);

        $request->validate([
            'employeeStatusName'   =>  [ 'required', 'max:150',
                                            Rule::unique('employeeStatus')->ignore($id,'employeeStatusId')
            ],
            'employeeStatusCode'   =>  [ 'required', 'max:20',
                        Rule::unique('employeeStatus')->ignore($id,'employeeStatusId')
            ]
        ]);
        
        $data = [ 'employeeStatusName' => $request['employeeStatusName'], 'employeeStatusCode' => $request['employeeStatusCode'] ];
        
        $employeeStatus->update($data);
        
        return response()->json([ 'status' => 200, 'message' => 'Updated', 'createdData' => $employeeStatus]);
    }   
}
