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

    public function getUsers(Request $request){
        $limit      = $request['limit'];
        $limitPage  = $request['page'] - 1;
        $offset     = $limit * $limitPage;
        $order      = strtoupper($request['order']);
        $field      = $request['field'];
        $filter     = $request['filter'];
        $project    = $request['projectId'];

        $query      = User::where("projectId","=",$project)->where(function($q) use ($field,$filter){
            $q->where($field,'LIKE','%'.$filter.'%')
            ->orWhere('username','LIKE','%'.$filter.'%');
        });
        $count      = $query->count();
        $get        = $query->take($limit)->skip($offset)->orderBy($field,$order)->get();

        return response()->json([ 'status' => 200, 'count' => $count, 'data' => $get ]);

    }

    public function addUser(Request $request) {
        $credentials = $request->validate([
            'username'      =>  'required|unique:users,username',
            'profileName'   =>  'required',
            'role'          =>  'required',
            'projectId'     =>  'required'
        ]);
        
        $data = [
            'username'  =>  $credentials['username'],
            'password'  =>  Hash::make($credentials['username']),
            'profileName'   =>  $credentials['profileName'],
            'role' => $credentials['role'],
            'projectId' => $credentials['projectId']
        ];

        User::create($data);

        return response()->json(['status' => 200, 'message' => "New User has been added."]);

    }

    public function resetPassword(Request $request){
        $credentials = $request->validate([
            'userId'    =>  'required',
            'username'  =>  'required'
        ]);

        $data = [
            "password"  =>  Hash::make($credentials['username'])
        ];

        User::findOrFail($credentials['userId'])->update($data);

        return response()->json(['status' => 200, 'message' => "Password has been reset. Default password is the username."]);
    }

    public function changeStatus(Request $request){
        $credentials = $request->validate([
            'userId'    =>  'required',
            'status'    =>  'required'
        ]);

        $q = User::findOrFail($credentials['userId']);
        $q->update(['status' => $credentials['status']]);

        return response()->json(['status' => 200, 'message' => "Status has been changed"]);
    }

    public function checkUsername(Request $request){
        $username = $request['keyValue'];

        $count = DB::table('users')->where(['username' => $username])->count();

        if($count > 0){
            return response()->json(['status' => 403]);
        }

        return response()->json(['status' => 200]);
    }

}
