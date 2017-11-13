<?php

namespace Ipm\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Ipm\Shifts;

use JWTAuth;

class ShiftsController extends Controller
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
            
            $count      = Shifts::where('projectId','=',$project)->count();
            $get        = DB::table('shifts as s')
                          ->leftJoin('collectionSchedules as cs','cs.collectionScheduleId','=','s.collectionScheduleId')
                          ->leftJoin('collectionTypes as ct','ct.collectionTypeId','=','s.collectionTypeId')
                          ->lectJoin('equipments as e','e.equipmentId','=','s.equipmentId')
                          ->where('s.projectId','=',$project)
                          ->where(function ($q) use($filter) {
                            $q->where('e.equipmentCode','LIKE','%'.$filter.'%')
                              ->orWhere('e.bodyNumber','LIKE','%'.$filter.'%')
                              ->orWhere('cs.collectionTypeName','LIKE','%'.$filter.'%')
                              ->orWhere('cs.collectionScheduleName','LIKE','%'.$filter.'%');
                          })
                          ->take($limit)
                          ->skip($offset)
                          ->orderBy('s.'.$field,$order)
                          ->get();
            
            return response()->json([ 'status' => 200, 'count' => $count, 'data' => $get ]);
        }
            
        public function all(Request $request) {
            $project = ($this->role == 1) ? $request['projectId'] : $this->projectId;
            $get = Shifts::where('projectId','=',$project)->all();
                            
            return response()->json([ 'status' => 200, 'data' => $get ]);
                    
        }
                    
        public function verifyData(Request $request) {
            
            $value      = $request['keyValue'];
            $id         = $request['keyId'];
            $keyField   = $request['keyField'];
            $project    = ($this->role == 1) ? $request['projectId'] : $this->projectId;  
            $status = 200;
                    
            if($id == 0){
                $count = Shifts::where($keyField,'=',$value)->where('projectId','=',$project)->count();
                    
                ($count>0) ? $status = 422 : $status = 200;
            }
            else {
                    
                $count = Shifts::where($keyField,'=',$value)->where('shiftId','!=',$id)->where('projectId','=',$project)->count();
                    
                ($count>0) ? $status = 422 : $status = 200;
            }
                    
            return response()->json(compact('status'));
        }
                    
                     
        public function store(Request $request){
                    
            $request->validate([
                'equipmentId'             =>  'required',
                'collectionScheduleId'    =>  'required',
                'collectionTypeId'        =>  'required',
                'geofenceName'            =>  'required|max:150',
                'sectors'                 =>  'required|max:150',
                'shiftTime'               =>  'required',
            ]);
    
            $project = ($this->role == 1) ? $request['projectId'] : $this->projectId;
                    
            $data   =   [ 'equipmentId'             =>  $request['equipmentId'] , 
                          'collectionScheduleId'    =>  $request['collectionScheduleId'],
                          'collectionTypeId'        =>  $request['collectionTypeId'],
                          'geofenceName'            =>  $request['geofenceName'],
                          'sectors'                 =>  $request['sectors'],
                          'shiftTime'               =>  $request['shiftTime'],
                          'projectId'               =>  $project 
                        ];
                    
                Shifts::create($data);
                    
            return response()->json([ 'status'  =>  201 , 'message'   =>  'Created' ]);
                    
        }
                    
        public function update(Request $request, $id){
                    
            $request->validate([
                'equipmentId'             =>  'required',
                'collectionScheduleId'    =>  'required',
                'collectionTypeId'        =>  'required',
                'geofenceName'            =>  'required|max:150',
                'sectors'                 =>  'required|max:150',
                'shiftTime'               =>  'required',
            ]);
                    
            $data   =   [   'equipmentId'             =>  $request['equipmentId'] , 
                            'collectionScheduleId'    =>  $request['collectionScheduleId'],
                            'collectionTypeId'        =>  $request['collectionTypeId'],
                            'geofenceName'            =>  $request['geofenceName'],
                            'sectors'                 =>  $request['sectors'],
                            'shiftTime'               =>  $request['shiftTime']
                        ];
                    
            Shifts::where('shiftId','=',$id)->update($data);
                    
            return response()->json([ 'status' => 200, 'message' => 'Updated']);
        }
        

}
