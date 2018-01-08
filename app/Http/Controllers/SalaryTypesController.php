<?php

namespace Ipm\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Ipm\SalaryTypes;

class SalaryTypesController extends Controller
{
    public function index(Request $request){
        
        $limit      = $request['limit'];
        $limitPage  = $request['page'] - 1;
        $offset     = $limit * $limitPage;
        $order      = strtoupper($request['order']);
        $field      = $request['field'];
        $filter     = $request['filter'];
        
        $query      = SalaryTypes::where($field,'LIKE','%'.$filter.'%')->orWhere('salaryTypeCode','LIKE','%'.$filter.'%');
        $count      = $query->count();
        $get        = $query->take($limit)->skip($offset)->orderBy($field,$order)->get();
        
        return response()->json([ 'status' => 200, 'count' => $count, 'data' => $get ]);
        
    }

    public function all() {

        $get = SalaryTypes::all();

        return response()->json([ 'status' => 200, 'data' => $get ]);

    }

    public function verifyData(Request $request){
        $value = $request['keyValue'];
        $id    = $request['keyId'];
        $keyField = $request['keyField'];
        $status = 200;

        if($id == 0){
            $count = SalaryTypes::where($keyField,'=',$value)->count();

            ($count>0) ? $status = 422 : $status = 200;
        }
        else {

            $count = SalaryTypes::where($keyField,'=',$value)->where('salaryTypeId','!=',$id)->count();

            ($count>0) ? $status = 422 : $status = 200;
        }

        return response()->json(compact('status'));
    }
        
         
    public function store(Request $request){
        
        $request->validate([
            'salaryTypeCode'      =>  'required|max:20|unique:salaryTypes,salaryTypeCode',
            'salaryTypeName'      =>  'required|max:150|unique:salaryTypes,salaryTypeName'
        ]);
        
        $data   =   [ 'salaryTypeCode' =>  $request['salaryTypeCode'], 'salaryTypeName' => $request['salaryTypeName'] ];
        
        SalaryTypes::create($data);
        
        return response()->json([ 'status'  =>  201 , 'message'   =>  'Created' ]);
        
    }
        
    public function update(Request $request, $id){
        $salary = SalaryTypes::findorFail($id);
        $request->validate([
            'salaryTypeCode'   =>  [ 'required', 'max:20',
                                   Rule::unique('salaryTypes')->ignore($id,'salaryTypeId')
            ],
            'salaryTypeName'   =>  [ 'required', 'max:150',
                        Rule::unique('salaryTypes')->ignore($id,'salaryTypeId')
            ]

        ]);
        
        $data = [ 'salaryTypeCode' => $request['salaryTypeCode'], 'salaryTypeName' => $request['salaryTypeName'] ];
        
        $salary->update($data);
        
        return response()->json([ 'status' => 200, 'message' => 'Updated','updatedData' => $salary]);
    }
}
