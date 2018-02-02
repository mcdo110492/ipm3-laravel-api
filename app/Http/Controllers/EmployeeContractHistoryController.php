<?php

namespace Ipm\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use Ipm\EmployeeContractHistory;

class EmployeeContractHistoryController extends Controller
{
    public function index($id){
        
        $employeeId = $id;

        $get = DB::table('employeeContractHistory as ec')
               ->leftJoin('contractTypes as ct','ct.contractTypeId','=','ec.contractTypeId')
               ->where('ec.employeeId','=',$employeeId)
               ->orderBy('ec.contractStart','DESC')
               ->get();

        return response()->json(['status' => 200, 'data' => $get]);
    }

    public function store(Request $request, $id){
        $employeeId = $id;
        $request->validate([
            'contractTypeId'    =>  'required',
            'contractStart'     =>  'required',
            'contractEnd'       =>  'required'
        ]);

        $data = ['employeeId' => $employeeId, 'contractTypeId' => $request['contractTypeId'], 'contractStart' => $request['contractStart'], 'contractEnd' => $request['contractEnd'], 'contractExtension' => $request['contractExtension'],'remarks' => $request['remarks']];

        $createdData = EmployeeContractHistory::create($data);

        $get = DB::table('employeeContractHistory as ec')
        ->leftJoin('contractTypes as ct','ct.contractTypeId','=','ec.contractTypeId')
        ->where('ec.employeeContractId','=',$createdData->employeeContractId)
        ->get()->first();

        return response()->json([ 'status'  =>  201 , 'message'   =>  'Created', 'createdData' => $get ]);
    }

    public function update(Request $request, $id){
        $contract = EmployeeContractHistory::findOrFail($id);

        $request->validate([
            'contractTypeId'    =>  'required',
            'contractStart'     =>  'required',
            'contractEnd'       =>  'required'
        ]);

        $data = ['contractTypeId' => $request['contractTypeId'], 'contractStart' => $request['contractStart'], 'contractEnd' => $request['contractEnd'], 'contractExtension' => $request['contractExtension'],'remarks' => $request['remarks']];

        $contract->update($data);
        
        $get = DB::table('employeeContractHistory as ec')
        ->leftJoin('contractTypes as ct','ct.contractTypeId','=','ec.contractTypeId')
        ->where('ec.employeeContractId','=',$id)
        ->get()->first();

        return response()->json([ 'status' => 200, 'message' => 'Updated','updatedData' => $get]);

    }

}
