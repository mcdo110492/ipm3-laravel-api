<?php

namespace Ipm\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Ipm\EmployeeCompensations;

class EmployeeCompensationsController extends Controller
{
   
    public function index($id){
        
        $employeeId = $id;

        $get = DB::table('employeeCompensations as ec')
               ->leftJoin('salaryTypes as st','st.salaryTypeId','=','ec.salaryTypeId')
               ->where('ec.employeeId','=',$employeeId)
               ->orderBy('ec.effectiveDate','DESC')
               ->get();

        return response()->json(['status' => 200, 'data' => $get]);
    }

    public function verify(Request $request, $empId){
        $keyId      =   $request['keyId'];
        $keyValue   =   $request['keyValue'];
        $employeeId =   $empId;

        $status     = 200;
        $query      =  EmployeeCompensations::where('employeeId','=',$employeeId)->where('salaryTypeId','=',$keyValue);

        if($keyId == 0){
            $count = $query->count();

            ($count>0) ? $status = 422 : $status = 200 ;
        }
        else{
            $count = $query->where('employeeCompensationId','!=',$keyId)->count();

            ($count>0) ? $status = 422 : $status = 200 ;
        }
    }

         
    public function store(Request $request, $id){
        $employeeId             = $id;
        $request->validate([
            'salaryTypeId'        =>  ['required', Rule::unique('employeeCompensations')->where(function ($query) use ($employeeId) {
                                            return $query->where('employeeId',$employeeId);
                                      })],
            'salary'              => 'required|max:20',
            'effectiveDate'       => 'required'
        ]);
        
        $data   =   [ 'salaryTypeId' =>  $request['salaryTypeId'], 'employeeId' => $employeeId, 'salary' => $request['salary'],'effectiveDate' => $request['effectiveDate'], 'remarks' => $request['remarks'] ];
        
        $createdData = EmployeeCompensations::create($data);

        $get = DB::table('employeeCompensations as ec')
                ->leftJoin('salaryTypes as st','st.salaryTypeId','=','ec.salaryTypeId')
                ->where('ec.employeeCompensationId','=',$createdData->employeeCompensationId)
                ->get()->first();
        
        return response()->json([ 'status'  =>  201 , 'message'   =>  'Created', 'createdData' => $get ]);
        
    }
        
    public function update(Request $request, $id){
        $compensations = EmployeeCompensations::findorFail($id);
        $employeeId    = $request['employeeId'];
        $request->validate([
            'salaryTypeId'   =>  [ 'required', 'max:20',
                                   Rule::unique('employeeCompensations')->where(function ($query) use ($employeeId) {
                                       return $query->where('employeeId',$employeeId);
                                   })->ignore($id,'salaryTypeId')
            ],
            'salary'        =>  'required',
            'effectiveDate' =>  'required'   
        ]);
        
        $data   =   [ 'salaryTypeId' =>  $request['salaryTypeId'], 'salary' => $request['salary'],'effectiveDate' => $request['effectiveDate'], 'remarks' => $request['remarks'] ];
        
        $compensations->update($data);

        $get = DB::table('employeeCompensations as ec')
        ->leftJoin('salaryTypes as st','st.salaryTypeId','=','ec.salaryTypeId')
        ->where('ec.employeeCompensationId','=',$id)
        ->get()->first();
        
        return response()->json([ 'status' => 200, 'message' => 'Updated','updatedData' => $get]);
    }
}
