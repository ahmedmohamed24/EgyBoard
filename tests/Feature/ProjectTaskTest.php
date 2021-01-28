<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTaskTest extends TestCase
{
    use WithFaker,RefreshDatabase;

    /**@test*/
    public function test_user_can_add_project(){
        $this->withoutExceptionHandling();
        $this->signUserIn();
        $project=auth()->user()->projects()->create(
            Project::factory()->raw()
        );
        $task=Task::factory()->raw(['owner_id'=>auth()->id()]);
        $this->post($project->path().'/task',$task)->assertRedirect();
        $this->get($project->path())->assertSee($task);
    }

    /**@test*/
    public function test_task_body_is_required(){
        // $this->withoutExceptionHandling();
        $this->signUserIn();
        $project=auth()->user()->projects()->create(
            Project::factory()->raw()
        );
        $task=Task::factory()->raw(['body'=>'','project_id'=>$project->id]);
        $this->post($project->path().'/task',$task)->assertSessionHasErrors('body');
    }

    /**@test*/
    public function test_only_project_owner_can_add_task_to_it()
    {
        // $this->withoutExceptionHandling();
        $this->signUserIn();
        $project=Project::factory()->create(['owner_id'=>auth()->id()]);
        $task=Task::factory()->raw();
        $this->signUserIn();
        $this->post($project->path().'/task',$task)->assertSessionHasErrors();
        
    }

    /**@test*/
    public function test_task_must_have_a_project(){
        // $this->withoutExceptionHandling();
        $this->signUserIn();
        $this->post('/project/3/task')->assertSessionHasNoErrors();
    
    }
}
