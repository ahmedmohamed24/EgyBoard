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
        $project=Auth::user()->projects()->create($this->validateRequest($request));
        return redirect($project->path());
    }
    public function show(Project $project)
    {
        $this->authorize('update',$project);
        return view('projects.project', compact('project'));
    }
    public function updateNotes(Project $project,Request $request)
    {
        $this->authorize('update',$project);
        $request->validate([
            'notes'=>'nullable|string'
        ]);
        $project->update([
            'notes'=>$request->notes
        ]);
        //may return message of success
        return back();
    }
    public function update(Request $request,Project $project)
    {
        $this->authorize('update',$project);
        $project->update($this->validateRequest($request));
        //may return a success message
        return back();
    
    }
    public function edit(Project $project)
    {
        $this->authorize('update',$project);
        return view('projects.edit',compact('project'));
    }
    protected function validateRequest(Request $request)
    {
       return $request->validate([
            'title'=>['required','string','max:244'],
            'description'=>['required','string'],
            'notes'=>['nullable','string'],
        ]);
    }
}
