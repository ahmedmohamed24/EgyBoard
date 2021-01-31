<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Project;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RecordActivityTest extends TestCase
{
    use WithFaker,RefreshDatabase;

    /**@test*/
    public function test_create_project()
    {
        $this->withoutExceptionHandling();
        Project::factory()->create();
        $this->assertDatabaseCount('activities',1);
    }

    /**@test*/
    public function test_activity_should_have_a_description()
    {
        $this->withoutExceptionHandling();
        Project::factory()->create();
        $this->assertDatabaseHas('activities',['description'=>'new project created']);
    }
    
    /**@test */
    public function test_update_project()
    {
        // $this->withoutExceptionHandling();
        $this->signUserIn();
        $project=Project::factory()->create();
        $data=['notes'=>'tested'];
        $project->update($data);
        // $this->patch($project->path(),$data);
        $this->assertDatabaseCount('activities',2);
    }

    /**@test*/
    public function test_create_task()
    {
        $this->withoutExceptionHandling();
        $this->signUserIn();
        $project=Project::factory()->create();
        $project->addTask('test');
        $this->assertDatabaseCount('activities',2);
    }

    /**@test*/
    public function test_update_task()
    {
        $this->withoutExceptionHandling();
        $this->signUserIn();
        $project=Project::factory()->create();
        $project->addTask('test');
        $project->tasks()->first()->update(['body'=>'test again']);
        $project->tasks()->first()->update(['body'=>'test again again']);
        $this->assertDatabaseCount('activities',4);
    }

    /**@test*/
    public function test_complete_task()
    {
        $this->withoutExceptionHandling();
        $this->signUserIn();
        $project=Project::factory()->create();
        $project->addTask('first time');
        $project->tasks()->first()->update([
            'status'=>1
        ]);
        $this->assertDatabaseHas('activities',['description'=>'task completed'])->assertDatabaseCount('activities',3);
    }

    /**@test*/
    public function test_incomplete_task()
    {
        $this->withoutExceptionHandling();
        $this->signUserIn();
        $project=Project::factory()->create();
        $project->addTask('first time');
        $project->tasks()->first()->update([
            'status'=>1
        ]);
        $project->tasks()->first()->update([
            'status'=>0
        ]);
        $this->assertDatabaseHas('activities',['description'=>'task marked as in completed']);
    }

}

