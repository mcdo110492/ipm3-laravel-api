<?php

namespace Ipm\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use Ipm\CollectionSchedules;

class CollectionSchedulesController extends Controller
{
    public function index(Request $request) {
        
        $limit      = $request['limit'];
        $limitPage  = $request['page'] - 1;
        $offset     = $limit * $limitPage;
        $order      = strtoupper($request['order']);
        $field      = $request['field'];
        $filter     = $request['filter'];
        
        $count      = CollectionSchedules::count();
        $get        = CollectionSchedules::where($field,'LIKE','%'.$filter.'%')->orWhere('collectionScheduleName','LIKE','%'.$filter.'%')->take($limit)->skip($offset)->orderBy($field,$order)->get();
        
        return response()->json([ 'status' => 200, 'count' => $count, 'data' => $get ]);
    }
        
    public function all() {
                
        $get = CollectionSchedules::all();
                        
        return response()->json([ 'status' => 200, 'data' => $get ]);
                
    }
                
    public function verifyData(Request $request) {
        
        $value      = $request['keyValue'];
        $id         = $request['keyId'];
        $keyField   = $request['keyField'];
        $status = 200;
                
        if($id == 0){
            $count = CollectionSchedules::where($keyField,'=',$value)->count();
                
            ($count>0) ? $status = 422 : $status = 200;
        }
        else {
                
            $count = CollectionSchedules::where($keyField,'=',$value)->where('collectionScheduleId','!=',$id)->count();
                
            ($count>0) ? $status = 422 : $status = 200;
        }
                
        return response()->json(compact('status'));
    }
                
                 
    public function store(Request $request){
                
        $request->validate([
            'collectionScheduleCode'      =>  'required|max:20|unique:collectionSchedules,collectionScheduleCode',
            'collectionScheduleName'      =>  'required|max:150|unique:collectionSchedules,collectionScheduleName'
        ]);
                
        $data   =   [ 'collectionScheduleCode' =>  $request['collectionScheduleCode'] , 'collectionScheduleName' =>  $request['collectionScheduleName'] ];
                
        CollectionSchedules::create($data);
                
        return response()->json([ 'status'  =>  201 , 'message'   =>  'Created' ]);
                
    }
                
    public function update(Request $request, $id){
                
        $request->validate([
            'collectionScheduleCode'   =>  [ 'required', 'max:20',
                                    Rule::unique('collectionSchedules')->ignore($id,'collectionScheduleId')
            ],
            'collectionScheduleName'   =>  [ 'required', 'max:150',
                                            Rule::unique('collectionSchedules')->ignore($id,'collectionScheduleId') ]
        ]);
                
        $data = [ 'collectionScheduleCode' => $request['collectionScheduleCode'] , 'collectionScheduleName' => $request['collectionScheduleName'] ];
                
        CollectionSchedules::where('collectionScheduleId','=',$id)->update($data);
                
        return response()->json([ 'status' => 200, 'message' => 'Updated']);
    }
    
}
