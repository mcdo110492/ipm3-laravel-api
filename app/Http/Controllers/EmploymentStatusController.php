<?php

namespace Ipm\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Ipm\EmploymentStatus;

class EmploymentStatusController extends Controller
{
    public function index(Request $request){
        
        $limit      = $request['limit'];
        $limitPage  = $request['page'] - 1;
        $offset     = $limit * $limitPage;
        $order      = strtoupper($request['order']);
        $field      = $request['field'];
        $filter     = $request['filter'];
        
        $count      = EmploymentStatus::count();
        $get        = EmploymentStatus::where($field,'LIKE','%'.$filter.'%')->orWhere('employmentStatusCode','LIKE','%'.$filter.'%')->take($limit)->skip($offset)->orderBy($field,$order)->get();
        
        return response()->json([ 'status' => 200, 'count' => $count, 'data' => $get ]);
        
    }

    public function all() {

        $get = EmploymentStatus::all();

        return response()->json([ 'status' => 200, 'data' => $get ]);

    }

    public function verifyData(Request $request){
        $value = $request['keyValue'];
        $id    = $request['keyId'];
        $keyField = $request['keyField'];
        $status = 200;

        if($id == 0){
            $count = EmploymentStatus::where($keyField,'=',$value)->count();

            ($count>0) ? $status = 422 : $status = 200;
        }
        else {

            $count = EmploymentStatus::where($keyField,'=',$value)->where('emloymentStatusId','!=',$id)->count();

            ($count>0) ? $status = 422 : $status = 200;
        }

        return response()->json(compact('status'));
    }
        
         
    public function store(Request $request){
        
        $request->validate([
            'employmentStatusName'   =>  'required|max:150|unique:employmentStatus,employmentStatusName',
            'employmentStatusCode'   =>  'required|max:20|unique:employmentStatus,employmentStatusCode'
        ]);
        
        $data   =   [ 'employmentStatusName' =>  $request['employmentStatusName'], 'employmentStatusCode' => $request['employmentStatusCode'] ];
        
        EmploymentStatus::create($data);
        
        return response()->json([ 'status'  =>  201 , 'message'   =>  'Created' ]);
        
    }
        
    public function update(Request $request, $id){
        
        $request->validate([
            'employmentStatusName'   =>  [ 'required', 'max:150',
                                            Rule::unique('employmentStatus')->ignore($id,'employmentStatusId')
            ],
            'employmentStatusCode'   =>  [ 'required', 'max:20',
                        Rule::unique('employmentStatus')->ignore($id,'employmentStatusId')
            ]
        ]);
        
        $data = [ 'employmentStatusName' => $request['employmentStatusName'], 'employmentStatusCode' => $request['employmentStatusCode'] ];
        
        EmploymentStatus::where('employmentStatusId','=',$id)->update($data);
        
        return response()->json([ 'status' => 200, 'message' => 'Updated']);
    }
}
