<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Exception;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * stores the task to a project.
     */
    public function store(Project $project, Request $request)
    {
        $request->validate([
            'body' => ['required', 'string'],
        ]);
        //make sure only project owner can add task to it
        $this->authorize('update', $project);
        $project->addTask($request->body);

        return redirect($project->path());
    }

    /**
     * update the task.
     */
    public function update(Project $project, Task $task, Request $request)
    {
        $this->authorize('update', $project);
        //validate
        $request->validate([
            'body' => ['required', 'string'],
            'status' => ['in:on,null,0,1'],
        ]);
        //logic
        try {
            $task->update([
                'body' => $request->body,
                'status' => $request->status ? 1 : 0,
            ]);
            //redirect
            return back()->with('msg', 'successfully update');
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}