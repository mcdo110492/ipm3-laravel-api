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
        $get        = Positions::where($field,'LIKE','%'.$filter.'%')->take($limit)->skip($offset)->orderBy($field,$order)->get();
        
        return response()->json([ 'status' => 200, 'count' => $count, 'data' => $get ]);
        
    }

    public function all() {

        $get = Positions::all();

        return response()->json([ 'status' => 200, 'data' => $get ]);

    }
        
         
    public function store(Request $request){
        
        $request->validate([
            'positionName'   =>  'required|unique:positions,positionName'
        ]);
        
        $data   =   [ 'positionName' =>  $request['positionName'] ];
        
        Positions::create($data);
        
        return response()->json([ 'status'  =>  201 , 'message'   =>  'Created' ]);
        
    }
        
    public function update(Request $request, $id){
        
        $request->validate([
            'positionName'   =>  [ 'required',
                                   Rule::unique('positions')->ignore($id,'positionId')
            ],
        ]);
        
        $data = [ 'positionName' => $request['positionName'] ];
        
        Positions::where('positionId','=',$id)->update($data);
        
        return response()->json([ 'status' => 200, 'message' => 'Updated']);
    }
}
