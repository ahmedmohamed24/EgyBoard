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
    public function test_user_can_add_task()
    {
        $this->withoutExceptionHandling();
        $this->signUserIn();
        $project=auth()->user()->projects()->create(
            Project::factory()->raw()
        );
        $task=Task::factory()->raw(['owner'=>auth()->id()]);
        $this->post($project->path().'/task',$task)->assertRedirect();
        $this->get($project->path())->assertSee($task);
    }

    /**@test*/
    public function test_task_body_is_required_on_create()
    {
        // $this->withoutExceptionHandling();
        $this->signUserIn();
        $project=auth()->user()->projects()->create(
            Project::factory()->raw()
        );
        $task=Task::factory()->raw(['body'=>'','project'=>$project->id]);
        $this->post($project->path().'/task',$task)->assertSessionHasErrors('body');
        // $this->post($project->path().'/task',$task)->assertSessionHasNoErrors();
    }

    /**@test*/
    public function test_only_project_owner_can_add_task_to_it()
    {
        // $this->withoutExceptionHandling();
        $this->signUserIn();
        $project=Project::factory()->create();
        $task=Task::factory()->raw();
        $this->signUserIn();
        $this->post($project->path().'/task',$task)->assertForbidden();
        $this->assertDatabaseMissing('tasks',$task) ;
        
    }

    /**@test*/
    public function test_task_must_have_a_project()
    {
        // $this->withoutExceptionHandling();
        $this->signUserIn();
        $this->post('/project/ahmed/task')->assertStatus(404);
    
    }

    /**@test*/
    public function test_user_can_update_a_task()
    {
        // $this->withoutExceptionHandling();
        $this->signUserIn();
        $project=Project::factory()->create();
        $task=$project->addTask("test");
        //begin update section
        $newTask=Task::factory()->raw(['project'=>$project->id]);
        $this->patch($project->path().'/task/'."$task->id",$newTask)->assertStatus(302)->assertSessionHasNoErrors();
        $this->assertDatabaseHas('tasks',$newTask);
    }

    /**@test*/
    public function test_task_body_is_required_on_update()
    {
        $this->signUserIn();
        $project=Project::factory()->create();
        $task=$project->addTask("test");
        //begin update section
        $newTask=['body'=>''];
        $this->patch($task->path(),$newTask)->assertSessionHasErrors('body');
    }

    /**@test*/
    public function test_only_owner_can_update_his_task()
    {
        // $this->withoutExceptionHandling();
        $this->signUserIn();
        $user1Project=Project::factory()->create();
        $task=$user1Project->addTask("test");
        $this->signUserIn();
        //try to update after signing in with another account
        $newTask=Task::factory()->raw();
        $this->patch($task->path(),$newTask)->assertForbidden();
    }

    /**@test completed or not*/
    public function test_user_can_change_task_status()
    {
        // $this->withoutExceptionHandling();
        $this->signUserIn();
        $project=Project::factory()->create();
        $task=$project->addTask("test");
        $newTask=Task::factory()->raw(['body'=>'hello','status'=>1,'project'=>$project->id]);
        $this->patch($task->path(),$newTask)->assertSessionHasNoErrors()->assertStatus(302);
        $this->assertDatabaseHas('tasks',$newTask);
    } 

    /**@test*/
    public function test_every_task_has_a_path()
    {
        $this->withoutExceptionHandling();
        $this->signUserIn();
        $project=Project::factory()->create();
        $task=$project->addTask("test");
        $this->assertNotNull($task->path());
    }
    /**@test*/
    public function test_every_task_must_have_project()
    {
        $this->withoutExceptionHandling();
        $this->signUserIn();
        // $task=Task::factory()->create(['project'=>null]);
        $task=Task::factory()->create();
        $this->assertInstanceOf(Project::class,$task->getProject);
    }

}
