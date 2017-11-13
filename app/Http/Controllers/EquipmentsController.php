<?php

namespace Ipm\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Ipm\Equipments;

use JWTAuth;

class EquipmentsController extends Controller
{
    protected $projectId;

    protected $role;

    public function __construct() {

        $token = JWTAuth::parseToken()->authenticate();
        
        $this->projectId = $token->projectId;
        
        $this->role = $token->role;
    }

    public function index(Request $request) {
        
        $limit      = $request['limit'];
        $limitPage  = $request['page'] - 1;
        $offset     = $limit * $limitPage;
        $order      = strtoupper($request['order']);
        $field      = $request['field'];
        $filter     = $request['filter'];
        $project    = ($this->role == 1) ? $request['projectId'] : $this->projectId;
        
        $count      = Equipments::where('projectId','=',$project)->count();
        $get        = DB::table('equipments as e')
                      ->leftJoin('units as u','u.unitId','=','e.unitId')
                      ->where('e.projectId','=',$project)
                      ->where(function ($q) use($filter) {
                        $q->where('e.equipmentCode','LIKE','%'.$filter.'%')
                          ->orWhere('e.bodyNumber','LIKE','%'.$filter.'%')
                          ->orWhere('e.model','LIKE','%'.$filter.'%')
                          ->orWhere('e.plateNo','LIKE','%'.$filter.'%')
                          ->orWhere('u.unitName','LIKE','%'.$filter.'%')
                          ->orWhere('u.unitCode','LIKE','%'.$filter.'%');
                      })
                      ->take($limit)
                      ->skip($offset)
                      ->orderBy('e.'.$field,$order)
                      ->get();
        
        return response()->json([ 'status' => 200, 'count' => $count, 'data' => $get ]);
    }
        
    public function all(Request $request) {
        $project = ($this->role == 1) ? $request['projectId'] : $this->projectId;
        $get = Equipments::where('projectId','=',$project)->all();
                        
        return response()->json([ 'status' => 200, 'data' => $get ]);
                
    }
                
    public function verifyData(Request $request) {
        
        $value      = $request['keyValue'];
        $id         = $request['keyId'];
        $keyField   = $request['keyField'];
        $status = 200;
                
        if($id == 0){
            $count = Equipments::where($keyField,'=',$value)->count();
                
            ($count>0) ? $status = 422 : $status = 200;
        }
        else {
                
            $count = Equipments::where($keyField,'=',$value)->where('equipmentId','!=',$id)->count();
                
            ($count>0) ? $status = 422 : $status = 200;
        }
                
        return response()->json(compact('status'));
    }
                
                 
    public function store(Request $request){
                
        $request->validate([
            'equipmentCode'           =>  'required|max:20',
            'bodyNumber'              =>  'required|max:20',
            'model'                   =>  'required|max:150',
            'capacity'                =>  'required|max:50',
            'plateNo'                 =>  'required|max:50',
            'unitId'                  =>  'required'
        ]);

        $project = ($this->role == 1) ? $request['projectId'] : $this->projectId;
                
        $data   =   [ 'equipmentCode' =>  $request['equipmentCode'] , 
                      'bodyNumber'    =>  $request['bodyNumber'],
                      'model'         =>  $request['model'],
                      'capacity'      =>  $request['capacity'],
                      'plateNo'       =>  $request['plateNo'],
                      'remarks'       =>  'N/A',
                      'unitId'        =>  $request['unitId'],
                      'projectId'     =>  $project 
                    ];
                
        Equipments::create($data);
                
        return response()->json([ 'status'  =>  201 , 'message'   =>  'Created' ]);
                
    }
                
    public function update(Request $request, $id){
                
        $request->validate([
            'equipmentCode'           =>  'required|max:20',
            'bodyNumber'              =>  'required|max:20',
            'model'                   =>  'required|max:150',
            'capacity'                =>  'required|max:50',
            'plateNo'                 =>  'required|max:50',
            'unitId'                  =>  'required',
            'remarks'                 =>  'required|max:150'
        ]);
                
        $data   =   [   'equipmentCode' =>  $request['equipmentCode'] , 
                        'bodyNumber'    =>  $request['bodyNumber'],
                        'model'         =>  $request['model'],
                        'capacity'      =>  $request['capacity'],
                        'plateNo'       =>  $request['plateNo'],
                        'remarks'       =>  $request['remarks'],
                        'unitId'        =>  $request['unitId'] 
                    ];
                
        Equipments::where('equipmentId','=',$id)->update($data);
                
        return response()->json([ 'status' => 200, 'message' => 'Updated']);
    }
    
}
