<?php

namespace Ipm\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Ipm\User;

use JWTAuth;

class UserController extends Controller
{

    protected $userId;

    public function __construct(){

        $token = JWTAuth::parseToken()->authenticate();

        $this->userId = $token->userId;

    }

    public function changePassword(Request $request){
        $credentials = $request->validate([
            'oldPassword'       =>  'required',
            'password'          =>  'required',
            'confirmPassword'   =>  'required'
        ]);
        $where = ['userId' => $this->userId];

       $getUser = DB::table('users')->where($where)->get()->first();

       $checkPassword = Hash::check($credentials['oldPassword'], $getUser->password);

       if(!$checkPassword){

        return response()->json(['status' => 403, 'message' => "Password is invalid"]);

       }

       $data = ['password' => Hash::make($credentials['password'])];

       User::where($where)->update($data);

       return response()->json(['status' => 200, 'message' => "Password Changed Successfully"]);

    }

    public function changeProfilePicture(Request $request){
        $userId  = $this->userId;
        if($request->hasFile('profilePicture')){

            $request->validate([
                'profilePicture'     =>  'mimes:jpeg,jpg|max:5000'
            ]);
            

            //Check if inquiry exists in the database
            $q = User::findOrFail($userId);

            $path = $request->profilePicture->store("avatars");


            $data = ['profileImage' => $path];
                
               
            $q->update($data);

            return response()->json(['status' => 200, 'message' => "Profile Picture Has Been Changed Successfully.","path" => $path]);

        }

        return response()->json(['status' => 404, 'message' => "File not found."]);
    }

}
