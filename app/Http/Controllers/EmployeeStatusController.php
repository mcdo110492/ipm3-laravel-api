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
        
        $count      = EmployeeStatus::count();
        $get        = EmployeeStatus::where($field,'LIKE','%'.$filter.'%')->take($limit)->skip($offset)->orderBy($field,$order)->get();
        
        return response()->json([ 'status' => 200, 'count' => $count, 'data' => $get ]);
        
    }

    public function all() {
        
        $get = EmployeeStatus::all();
        
        return response()->json([ 'status' => 200, 'data' => $get ]);
    }

    public function verify(Request $request){
        $value = $request['keyValue'];
        $id    = $request['keyId'];
        $status = 200;

        if($id == 0){
            $count = EmployeeStatus::where('employeeStatusName','=',$value)->count();

            ($count>0) ? $status = 422 : $status = 200;
        }
        else {

            $count = EmployeeStatus::where('employeeStatusName','=',$value)->where('employeeStatusId','!=',$id)->count();

            ($count>0) ? $status = 422 : $status = 200;
        }

        return response()->json(compact('status'));
    }
        
         
    public function store(Request $request){
        
        $request->validate([
            'employeeStatusName'   =>  'required|unique:employeeStatus,employeeStatusName'
        ]);
        
        $data   =   [ 'employeeStatusName' =>  $request['employeeStatusName'] ];
        
        EmployeeStatus::create($data);
        
        return response()->json([ 'status'  =>  201 , 'message'   =>  'Created' ]);
        
    }
        
    public function update(Request $request, $id){
        
        $request->validate([
            'employeeStatusName'   =>  [ 'required',
                                            Rule::unique('employeeStatus')->ignore($id,'employeeStatusId')
            ],
        ]);
        
        $data = [ 'employeeStatusName' => $request['employeeStatusName'] ];
        
        EmployeeStatus::where('employeeStatusId','=',$id)->update($data);
        
        return response()->json([ 'status' => 200, 'message' => 'Updated']);
    }   
}
