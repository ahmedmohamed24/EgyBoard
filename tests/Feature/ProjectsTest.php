<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectsTest extends TestCase
{
    use WithFaker,RefreshDatabase;
    
    /**@test*/
    public function test_only_auth_users_can_create_project()
    {
        // $this->actingAs(User::factory()->create()); //to fail
        $project=Project::factory()->raw();
        $this->post('/project', $project)->assertRedirect('login');
    }

    /**@test */
    public function test_user_can_create_project()
    {
        $this->withoutExceptionHandling();
        $this->signUserIn();
        $params=Project::factory()->raw();
        //when a post request got
        $this->post('/project', $params)->assertStatus(302)->assertSessionHasNoErrors();
        //test the data is set into DB
        $this->assertDatabaseHas('projects', $params);
        //test redirect to projects page to see this post
        $this->get('/project')->assertSee(Str::limit($params['title'], 25, '...'));
    }

    /**@test*/
    public function test_user_can_add_notes_to_project()
    {
        $this->withoutExceptionHandling();
        $this->signUserIn();
        $project=Project::factory()->create();
        $notes=['notes'=>'hello this is a test note'];
        $this->patch($project->path().'/notes', $notes)->assertRedirect()->assertSessionHasNoErrors();
        // $project->update(['notes'=>'hello this is a test note']);
        $this->assertDatabaseHas('projects', $notes);
    }

    /** @test */
    public function test_project_title_is_required()
    {
        $this->actingAs(User::factory()->create());
        $params=Project::factory()->raw(['title'=>'']);
     
        $this->post('/project', $params)->assertSessionHasErrors('title');
    }

    /**@test*/
    public function test_project_description_is_required()
    {
        $this->actingAs(User::factory()->create());
        $params=Project::factory()->raw(['description'=>'']);
        $this->post('/project', $params)->assertSessionHasErrors();
    }

    /**@test*/
    public function test_user_cannot_view_other_projects()
    {
        $user1=User::factory()->create();
        $user2=User::factory()->create();
        $this->actingAs($user1);
        $project=Project::factory()->create();
        $this->actingAs($user2);
        $this->get($project->path())->assertStatus(403);
    }

    /**@test*/
    public function test_user_can_view_project()
    {
        // $this->withoutExceptionHandling();
        $user=User::factory()->create();
        $this->actingAs($user);
        $project=Project::factory()->create(['owner'=>$user->id]);
        $this->get($project->path())->assertStatus(200);
    }

    /**@test*/
    public function test_project_is_updated_when_task_is_updated()
    {
        $this->withoutExceptionHandling();
        $this->signUserIn();
        $project=Project::factory()->create();
        $task=$project->addTask("test");
        //begin update section
        $newTask=Task::factory()->raw(['project'=>$project->id]);
        $this->patch($project->path().'/task/'."$task->id", $newTask);
        $this->assertEquals($project->updated_at, $task->updated_at);
    }

    /**@test*/
    public function test_user_can_update_project()
    {
        $this->withoutExceptionHandling();
        $this->signUserIn();
        $project=Project::factory()->create();
        $newData=['title'=>'new title','description'=>'lorem inpsum','notes'=>'hello this is a test note'];
        $this->patch($project->path(), $newData)->assertSessionHasNoErrors()->assertRedirect();
        $this->assertDatabaseHas('projects', $newData);
    }
}
