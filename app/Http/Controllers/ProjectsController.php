<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects=Auth::user()->projects()->paginate(9);
        return view('projects.all', ['projects'=>$projects]);
    }
    public function store(Request $request)
    {
        //validate
        $data=$request->validate([
            'title'=>['required','string','max:244'],
            'description'=>['required','string'],
        ]);
        //presist
        Auth::user()->projects()->create($data);
        //redirect
        return redirect('/project');
    }
    public function show(Project $project)
    {
        //validate the user can see this project
        if($project->user->id !== Auth::id())
            abort(403);
        // if((int)$project->owner_id !== Auth::id())
        // $project=Project::findOrFail(request('project'));
        return view('projects.project', compact('project'));
    }
}
