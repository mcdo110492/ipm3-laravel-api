<?php

namespace Ipm\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Ipm\Units;

class UnitsController extends Controller
{
    

    public function index(Request $request) {

        $limit      = $request['limit'];
        $limitPage  = $request['page'] - 1;
        $offset     = $limit * $limitPage;
        $order      = strtoupper($request['order']);
        $field      = $request['field'];
        $filter     = $request['filter'];

        $count      = Units::count();
        $get        = Units::where($field,'LIKE','%'.$filter.'%')->orWhere('unitName','LIKE','%'.$filter.'%')->take($limit)->skip($offset)->orderBy($field,$order)->get();

        return response()->json([ 'status' => 200, 'count' => $count, 'data' => $get ]);
    }

    public function all() {
        
        $get = Units::all();
                
        return response()->json([ 'status' => 200, 'data' => $get ]);
        
    }
        
    public function verifyData(Request $request) {

        $value      = $request['keyValue'];
        $id         = $request['keyId'];
        $keyField   = $request['keyField'];
        $status = 200;
        
        if($id == 0){
            $count = Units::where($keyField,'=',$value)->count();
        
            ($count>0) ? $status = 422 : $status = 200;
        }
        else {
        
            $count = Units::where($keyField,'=',$value)->where('unitId','!=',$id)->count();
        
            ($count>0) ? $status = 422 : $status = 200;
        }
        
        return response()->json(compact('status'));
    }
        
         
    public function store(Request $request){
        
        $request->validate([
            'unitCode'      =>  'required|unique:units,unitCode|max:20',
            'unitName'      =>  'required|unique:units,unitName|max:150'
        ]);
        
        $data   =   [ 'unitCode' =>  $request['unitCode'] , 'unitName' =>  $request['unitName'] ];
        
        Units::create($data);
        
        return response()->json([ 'status'  =>  201 , 'message'   =>  'Created' ]);
        
    }
        
    public function update(Request $request, $id){
        
        $request->validate([
            'unitCode'   =>  [ 'required', 'max:20',
                                    Rule::unique('units')->ignore($id,'unitId')
            ],
            'unitName'   =>  [ 'required', 'max:150',
                                    Rule::unique('units')->ignore($id,'unitId') ]
        ]);
        
        $data = [ 'unitCode' => $request['unitCode'] , 'unitName' => $request['unitName'] ];
        
        Units::where('unitId','=',$id)->update($data);
        
        return response()->json([ 'status' => 200, 'message' => 'Updated']);
    }

}
