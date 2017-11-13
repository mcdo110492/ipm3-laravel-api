<?php

namespace Ipm\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use Ipm\EmployeeLicenseInfo;

class EmployeeLicenseController extends Controller
{
    
    public function getLicenses($id) {
        
        $get = EmployeeLicenseInfo::where('employeeId','=',$id)->get();
        
        return response()->json([ 'status' => 200, 'data' => $get ]);

    }
        
    public function verifyLicenses(Request $request) {

        $value = $request['keyValue'];
        $id    = $request['keyId'];
        $status = 200;
        
        if($id == 0){

            $count = EmployeeLicenseInfo::where('licenseNumber','=',$value)->count();
        
            ($count>0) ? $status = 422 : $status = 200;
        }
        else {
        
            $count = EmployeeLicenseInfo::where('licenseNumber','=',$value)->where('employeeLicenseId','!=',$id)->count();
        
            ($count>0) ? $status = 422 : $status = 200;

        }
        
        return response()->json(compact('status'));

    }
        
    public function storeLicense(Request $request, $id) {
        
        $validatedData = $request->validate([
            'licenseNumber'     =>  'required|unique:employeeLicenseInfo,licenseNumber',
            'licenseType'       =>  'required',
            'dateIssued'        =>  'required|date',
            'dateExpiry'        =>  'required|date'
        ]);
                
        $newData                =   array_prepend($validatedData,$id,'employeeId');
        
        EmployeeLicenseInfo::create($newData);
        
        return response()->json([ 'status' => 201, 'message' => 'Created' ]);
        
    }
        
    public function updateLicense(Request $request, $id){
        
        $license = EmployeeLicenseInfo::findOrFail($id);
        
        $validatedData = $request->validate([
            'licenseNumber' =>  [ 'required',
                                   Rule::unique('employeeLicenseInfo')->ignore($id,'employeeLicenseId')
            ],
            'licenseType'   =>  'required',
            'dateIssued'    =>  'required|date',
            'dateExpiry'    =>  'required|date'
        ]);
        
        $license->update($validatedData);
        
        return response()->json([ 'status' => 200, 'message' => 'Updated' ]);
        
    }

}
