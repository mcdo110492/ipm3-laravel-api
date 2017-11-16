<?php

namespace Ipm\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Ipm\Positions;

class PositionsController extends Controller
{
    public function index(Request $request){
        
        $limit      = $request['limit'];
        $limitPage  = $request['page'] - 1;
        $offset     = $limit * $limitPage;
        $order      = strtoupper($request['order']);
        $field      = $request['field'];
        $filter     = $request['filter'];
        
        $count      = Positions::count();
        $get        = Positions::where($field,'LIKE','%'.$filter.'%')->orWhere('positionCode','LIKE','%'.$filter.'%')->take($limit)->skip($offset)->orderBy($field,$order)->get();
        
        return response()->json([ 'status' => 200, 'count' => $count, 'data' => $get ]);
        
    }

    public function all() {

        $get = Positions::all();

        return response()->json([ 'status' => 200, 'data' => $get ]);

    }

    public function verifyData(Request $request){
        $value = $request['keyValue'];
        $id    = $request['keyId'];
        $keyField = $request['keyField'];
        $status = 200;

        if($id == 0){
            $count = Positions::where($keyField,'=',$value)->count();

            ($count>0) ? $status = 422 : $status = 200;
        }
        else {

            $count = Positions::where($keyField,'=',$value)->where('positionId','!=',$id)->count();

            ($count>0) ? $status = 422 : $status = 200;
        }

        return response()->json(compact('status'));
    }
        
         
    public function store(Request $request){
        
        $request->validate([
            'positionName'   =>  'required|max:150|unique:positions,positionName',
            'positionCode'   =>  'required|max:20|unique:positions,positionCode'
        ]);
        
        $data   =   [ 'positionName' =>  $request['positionName'], 'positionCode' => $request['positionCode'] ];
        
        Positions::create($data);
        
        return response()->json([ 'status'  =>  201 , 'message'   =>  'Created' ]);
        
    }
        
    public function update(Request $request, $id){
        
        $request->validate([
            'positionName'   =>  [ 'required', 'max:150',
                                   Rule::unique('positions')->ignore($id,'positionId')
            ],
            'positionCode'   =>  [ 'required', 'max:20',
                        Rule::unique('positions')->ignore($id,'positionId')
            ]

        ]);
        
        $data = [ 'positionName' => $request['positionName'], 'positionCode' => $request['positionCode'] ];
        
        Positions::where('positionId','=',$id)->update($data);
        
        return response()->json([ 'status' => 200, 'message' => 'Updated']);
    }
    
}
