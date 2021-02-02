<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class InvitationTest extends TestCase
{
    use RefreshDatabase;

    // @test
    public function testUserCanInviteOthers()
    {
        $this->withoutExceptionHandling();
        $this->signUserIn();
        $project = Project::factory()->create();
        $otherUser = User::factory()->create();
        $project->invite($otherUser);
        $this->signUserIn($otherUser);
        $this->get("/project/{$project->id}")->assertSee($project->title);
    }
}