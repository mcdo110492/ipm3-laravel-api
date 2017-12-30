<?php

namespace Ipm\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Ipm\Projects;

class ProjectsController extends Controller
{
    public function index(Request $request){

        $limit      = $request['limit'];
        $limitPage  = $request['page'] - 1;
        $offset     = $limit * $limitPage;
        $order      = strtoupper($request['order']);
        $field      = $request['field'];
        $filter     = $request['filter'];

        $query      = Projects::where($field,'LIKE','%'.$filter.'%')->orWhere('projectName','LIKE','%'.$filter.'%');
        $count      = $query->count();
        $get        = $query->take($limit)->skip($offset)->orderBy($field,$order)->get();

        return response()->json([ 'status' => 200, 'count' => $count, 'data' => $get ]);

    }

    public function all() {

        $get = Projects::all();
        
        return response()->json([ 'status' => 200, 'data' => $get ]);

    }

    public function verifyCode(Request $request){
        $value = $request['keyValue'];
        $id    = $request['keyId'];
        $status = 200;

        if($id == 0){
            $count = Projects::where('projectCode','=',$value)->count();

            ($count>0) ? $status = 422 : $status = 200;
        }
        else {

            $count = Projects::where('projectCode','=',$value)->where('projectId','!=',$id)->count();

            ($count>0) ? $status = 422 : $status = 200;
        }

        return response()->json(compact('status'));
    }

 
    public function store(Request $request){

        $request->validate([
            'projectCode'   =>  'required|max:20|unique:projects,projectCode',
            'projectName'   =>  'required|max:150'
        ]);

        $data   =   [ 'projectCode' =>  $request['projectCode'] , 'projectName' =>  $request['projectName'] ];

       $createdData = Projects::create($data);


        return response()->json([ 'status'  =>  201 , 'message'   =>  'Created', 'createdData' => $createdData ]);

    }

    public function update(Request $request, $id){

        $project = Projects::findOrFail($id);

        $request->validate([
            'projectCode'   =>  [ 'required','max:20',
                                   Rule::unique('projects')->ignore($id,'projectId')
            ],
            'projectName'   =>  'required|max:150'
        ]);

        $data = [ 'projectCode' => $request['projectCode'] , 'projectName' => $request['projectName'] ];

       $project->update($data);

        return response()->json([ 'status' => 200, 'message' => 'Updated', 'createdData' => $project]);
    }

}
