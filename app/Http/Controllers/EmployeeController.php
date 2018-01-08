<?php

namespace Ipm\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Ipm\EmployeePersonalInfo;

use JWTAuth;

class EmployeeController extends Controller
{
    protected $projectId;

    protected $role;


    public function __construct() {

        $token = JWTAuth::parseToken()->authenticate();

        $this->projectId = $token->projectId;

        $this->role = $token->role;
    }

    public function index(Request $request){
        $limit      = $request['limit'];
        $limitPage  = $request['page'] - 1;
        $offset     = $limit * $limitPage;
        $order      = strtoupper($request['order']);
        $field      = $request['field'];
        $filter     = $request['filter'];
        $project    = ($this->role == 1) ? $request['projectId'] : $this->projectId;

        $select     = 'ep.employeeId, ep.employeeNumber, ep.firstName, ep.middleName, ep.lastName, ep.profileImage, p.positionName, es.employeeStatusName, emps.employmentStatusName';

        $query        = DB::table('employeePersonalInfo as ep')
                      ->selectRaw($select)
                      ->leftJoin('employeeEmploymentInfo as ee','ee.employeeId','=','ep.employeeId')
                      ->leftJoin('positions as p','p.positionId','=','ee.positionId')
                      ->leftJoin('employeeStatus as es','es.employeeStatusId','=','ee.employeeStatusId')
                      ->leftJoin('employmentStatus as emps','emps.employmentStatusId','=','ee.employmentStatusId')
                      ->where('ep.projectId','=',$project)
                      ->where(function ($q) use($filter) {
                        $q->where('ep.employeeNumber','LIKE','%'.$filter.'%')
                          ->orWhere('ep.firstName','LIKE','%'.$filter.'%')
                          ->orWhere('ep.middleName','LIKE','%'.$filter.'%')
                          ->orWhere('ep.lastName','LIKE','%'.$filter.'%')
                          ->orWhere('p.positionName','LIKE','%'.$filter.'%');
                      });
        $count = $query->count();
        $get = $query->take($limit)
                ->skip($offset)
                ->orderBy('ep.'.$field,$order)
                ->get();
                      

        return response()->json([ 'status'  =>  200, 'count' => $count, 'data' =>  $get ]);
    }

    public function verify(Request $request){
        $value = $request['keyValue'];
        $id    = $request['keyId'];
        $status = 200;

        if($id == 0){
            $count = EmployeePersonalInfo::where('employeeNumber','=',$value)->count();

            ($count>0) ? $status = 422 : $status = 200;
        }
        else {

            $count = EmployeePersonalInfo::where('employeeNumber','=',$value)->where('employeeId','!=',$id)->count();

            ($count>0) ? $status = 422 : $status = 200;
        }

        return response()->json(compact('status'));
    }

}
