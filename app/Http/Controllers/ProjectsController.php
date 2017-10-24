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

        $count      = Projects::count();
        $get        = Projects::where($field,'LIKE','%'.$filter.'%')->orWhere('projectName','LIKE','%'.$filter.'%')->take($limit)->skip($offset)->orderBy($field,$order)->get();

        return response()->json([ 'status' => 200, 'count' => $count, 'data' => $get ]);

    }

    public function all() {

        $get = Projects::all();
        
        return response()->json([ 'status' => 200, 'data' => $get ]);

    }

 
    public function store(Request $request){

        $request->validate([
            'projectCode'   =>  'required|unique:projects,projectCode',
            'projectName'   =>  'required'
        ]);

        $data   =   [ 'projectCode' =>  $request['projectCode'] , 'projectName' =>  $request['projectName'] ];

        Projects::create($data);

        return response()->json([ 'status'  =>  201 , 'message'   =>  'Created' ]);

    }

    public function update(Request $request, $id){

        $request->validate([
            'projectCode'   =>  [ 'required',
                                   Rule::unique('projects')->ignore($id,'projectId')
            ],
            'projectName'   =>  'required'
        ]);

        $data = [ 'projectCode' => $request['projectCode'] , 'projectName' => $request['projectName'] ];

        Projects::where('projectId','=',$id)->update($data);

        return response()->json([ 'status' => 200, 'message' => 'Updated']);
    }

}
