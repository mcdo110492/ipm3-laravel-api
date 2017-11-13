<?php

namespace Ipm\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use Ipm\EmployeeAccountInfo;

class EmployeeAccountController extends Controller
{
    
    public function getAccount($id) {
        
        $get = EmployeeAccountInfo::select('userId,username,status')->where('employeeId','=',$id)->get();
        
        return response()->json([ 'status' => 200, 'data' => $get ]);
    }
        
    public function verifyUsername(Request $request){

        $value = $request['keyValue'];
        $id    = $request['keyId'];
        $status = 200;
        
        if($id == 0) {

            $count = EmployeeAccountInfo::where('username','=',$value)->count();
        
            ($count>0) ? $status = 422 : $status = 200;
        }
        else {
        
            $count = EmployeeAccountInfo::where('username','=',$value)->where('userId','!=',$id)->count();
        
            ($count>0) ? $status = 422 : $status = 200;

        }
        
        return response()->json(compact('status'));

    }
        
    public function updateAccountUsername(Request $request, $id) {
        
        $account = EmployeeAccountInfo::findOrFail($id);
        
        $validatedData = $request->validate([
            'username'  =>  [ 'required','max:50',
                              Rule::unique('employeeAccountInfo')->ignore($id,'employeeAccountId')
            ]
        ]);
        
        $account->update($validatedData);
        
        return response()->json([ 'status' => 200, 'message' => 'Updated' ]);

    }
        
    public function updateAccountStatus(Request $request, $id) {
        
        $account = EmployeeAccountInfo::findOrFail($id);
        
        $validatedData = $request->validate([
            'status'    =>  'required|numeric'
        ]);
        
        $account->update($validatedData);
        
        return response()->json([ 'status' => 200, 'message' => 'Status has been change' ]);
        
    }
        
    public function updateAccountResetPassword(Request $request, $id){
        
        $account = EmployeeAccountInfo::findOrFail($id);
        
        $get    = $account->get();
        
        $username = $get->username;
        
        $data = [
            'password' => $username
        ];
        
        $account->update($data);
        
        return response()->json([ 'status' => 200 , 'message' => 'Password has been reset. And the new password is the username.' ]);
                
    }

}
