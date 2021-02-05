<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class ActivityTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    // @test
    // public function testUserMayHaveOtherMembersActivities()
    // {
    //     //having one user, create a project and invite 2 members, when one make changes
    //     //the others should see this activities
    //     $this->withoutExceptionHandling();
    //     $owner = User::factory()->create();
    //     $this->signUserIn($owner);
    //     $project = Project::factory()->create();
    //     $firstMember = User::factory()->create();
    //     $secondMember = User::factory()->create();
    //     $project->invite($firstMember);
    //     $project->invite($secondMember);
    //     $this->signUserIn($firstMember);
    //     $project->addTask('test');
    //     $this->signUserIn($secondMember);
    //     $this->assertCount(auth()->user()->getActivities->count(), 2);
    // }
}