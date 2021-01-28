<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Project $project,Request $request){
        $request->validate([
            'body'=>['required']
        ]);
        if((int)$project->owner_id !== auth()->id())
            return back()->withErrors('not auth');
        $project->addTask($request->body);
        return redirect($project->path());
    } 
}
