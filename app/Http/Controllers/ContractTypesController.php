<?php

namespace Ipm\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Ipm\ContractTypes;

class ContractTypesController extends Controller
{
    public function index(Request $request){
        
        $limit      = $request['limit'];
        $limitPage  = $request['page'] - 1;
        $offset     = $limit * $limitPage;
        $order      = strtoupper($request['order']);
        $field      = $request['field'];
        $filter     = $request['filter'];
        
        $query      = ContractTypes::where($field,'LIKE','%'.$filter.'%')->orWhere('contractTypeCode','LIKE','%'.$filter.'%');
        $count      = $query->count();
        $get        = $query->take($limit)->skip($offset)->orderBy($field,$order)->get();
        
        return response()->json([ 'status' => 200, 'count' => $count, 'data' => $get ]);
        
    }

    public function all() {

        $get = ContractTypes::all();

        return response()->json([ 'status' => 200, 'data' => $get ]);

    }

    public function verifyData(Request $request){
        $value = $request['keyValue'];
        $id    = $request['keyId'];
        $keyField = $request['keyField'];
        $status = 200;

        if($id == 0){
            $count = ContractTypes::where($keyField,'=',$value)->count();

            ($count>0) ? $status = 422 : $status = 200;
        }
        else {

            $count = ContractTypes::where($keyField,'=',$value)->where('contractTypeId','!=',$id)->count();

            ($count>0) ? $status = 422 : $status = 200;
        }

        return response()->json(compact('status'));
    }
        
         
    public function store(Request $request){
        
        $request->validate([
            'contractTypeCode'      =>  'required|max:20|unique:contracTypes,contractTypeCode',
            'contractTypeName'      =>  'required|max:150|unique:contracTypes,contractTypeName'
        ]);
        
        $data   =   [ 'contractTypeCode' =>  $request['contractTypeCode'], 'contractTypeName' => $request['contractTypeName'] ];
        
        ContractTypes::create($data);
        
        return response()->json([ 'status'  =>  201 , 'message'   =>  'Created' ]);
        
    }
        
    public function update(Request $request, $id){
        $contract = ContractTypes::findorFail($id);
        $request->validate([
            'contractTypeCode'   =>  [ 'required', 'max:20',
                                   Rule::unique('contractTypes')->ignore($id,'contractTypeId')
            ],
            'contractTypeName'   =>  [ 'required', 'max:150',
                        Rule::unique('contractTypes')->ignore($id,'contractTypeId')
            ]

        ]);
        
        $data = [ 'contractTypeCode' => $request['contractTypeCode'], 'contractTypeName' => $request['contractTypeName'] ];
        
        $contract->update($data);
        
        return response()->json([ 'status' => 200, 'message' => 'Updated','createdData' => $contract]);
    }
}
