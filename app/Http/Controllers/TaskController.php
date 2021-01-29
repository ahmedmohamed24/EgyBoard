<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function store(Project $project,Request $request)
    {
        $request->validate([
            'body'=>['required','string']
        ]);
        //make sure only project owner can add task to it
        $this->authorize('update',$project);
        $project->addTask($request->body);
        return redirect($project->path());
    } 

    public function update(Project $project , Task $task, Request $request)
    {
        //validate 
        $request->validate([
            'body'=>['required','string'],
            'status'=>['in:on,null,0,1']
        ]);
        $this->authorize('update',$project);
        //logic
        try{
            $task->update([
                'body'=>$request->body,
                'status'=>$request->status?1:0
            ]);
            //redirect
            return back()->with('msg','successfully update');
        }
        catch(Exception $e){
            return back()->withErrors($e->getMessage());
        }

    }
}
