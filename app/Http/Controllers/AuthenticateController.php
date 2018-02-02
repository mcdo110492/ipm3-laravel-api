<?php

namespace Ipm\Http\Controllers;

use Illuminate\Http\Request;

use Ipm\User;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthenticateController extends Controller
{
    public function authenticate(Request $request){
        
        $credentials = $request->only('username','password');

        try {

            $username       = $credentials['username'];
            $password       = $credentials['password'];

            $checkUsernameIfExist = User::where('username','=',$username)->count();

            if($checkUsernameIfExist == 0){
                return response()->json(['status' => 401, 'error' => 'Invalid Credentials']);
            }

            $where          = ['username' => $username, 'status' => 1];

            $checkStatus    = User::where($where)->count();

            if($checkStatus == 0){
                return response()->json(['status' => 403 ,'error' => 'Status Inactive']);
            }

            $user           = User::where($where)->get()->first();

            $role           = $user['role'];

            $projectId      = $user['projectId'];

            $userId         = $user['userId'];

            $customClaims   = ['role' => $role, 'projectId' => $projectId, 'userId' => $userId];

            $status         = 200;

            $profileName    = $user['profileName'];

            $profileImage   = $user['profileImage'];

            $jwtWhere       = ['username' => $username, 'password' => $password];

             // verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($jwtWhere,$customClaims) )
            {
             
                return response()->json([ 'status' => 401,'error' => 'Invalid Credentials'], 200);
             
            }


        }
        catch (JWTException $e) {
            return response()->json([ 'status' => 500, 'error' => 'Error. Unable to Create the Session' ],500);
        }

        return response()->json(compact('token', 'profileName', 'profileImage', 'role', 'status'));
    }
}
