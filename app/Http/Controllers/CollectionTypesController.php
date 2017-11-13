<?php

namespace Ipm\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Ipm\CollectionTypes;

class CollectionTypesController extends Controller
{

    public function index(Request $request) {
        
        $limit      = $request['limit'];
        $limitPage  = $request['page'] - 1;
        $offset     = $limit * $limitPage;
        $order      = strtoupper($request['order']);
        $field      = $request['field'];
        $filter     = $request['filter'];
        
        $count      = CollectionTypes::count();
        $get        = CollectionTypes::where($field,'LIKE','%'.$filter.'%')->orWhere('collectionTypeName','LIKE','%'.$filter.'%')->take($limit)->skip($offset)->orderBy($field,$order)->get();
        
        return response()->json([ 'status' => 200, 'count' => $count, 'data' => $get ]);
    }
        
    public function all() {
                
        $get = CollectionTypes::all();
                        
        return response()->json([ 'status' => 200, 'data' => $get ]);
                
    }
                
    public function verifyData(Request $request) {
        
        $value      = $request['keyValue'];
        $id         = $request['keyId'];
        $keyField   = $request['keyField'];
        $status = 200;
                
        if($id == 0){
            $count = CollectionTypes::where($keyField,'=',$value)->count();
                
            ($count>0) ? $status = 422 : $status = 200;
        }
        else {
                
            $count = CollectionTypes::where($keyField,'=',$value)->where('collectionTypeId','!=',$id)->count();
                
            ($count>0) ? $status = 422 : $status = 200;
        }
                
        return response()->json(compact('status'));
    }
                
                 
    public function store(Request $request){
                
        $request->validate([
            'collectionTypeCode'      =>  'required|max:20|unique:collectionTypes,collectionTypeCode',
            'collectionTypeName'      =>  'required|max:150|unique:collectionTypes,collectionTypeName'
        ]);
                
        $data   =   [ 'collectionTypeCode' =>  $request['collectionTypeCode'] , 'collectionTypeName' =>  $request['collectionTypeName'] ];
                
        CollectionTypes::create($data);
                
        return response()->json([ 'status'  =>  201 , 'message'   =>  'Created' ]);
                
    }
                
    public function update(Request $request, $id){
                
        $request->validate([
            'collectionTypeCode'   =>  [ 'required', 'max:20',
                                    Rule::unique('collectionTypes')->ignore($id,'collectionTypeId')
            ],
            'collectionTypeName'   =>  [ 'required', 'max:150',
                                            Rule::unique('collectionTypes')->ignore($id,'collectionTypeId') ]
        ]);
                
        $data = [ 'collectionTypeCode' => $request['collectionTypeCode'] , 'collectionTypeName' => $request['collectionTypeName'] ];
                
        CollectionTypes::where('collectionTypeId','=',$id)->update($data);
                
        return response()->json([ 'status' => 200, 'message' => 'Updated']);
    }

}
