<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase,WithFaker;
    /**@test*/
    public function test_user_can_has_projects(){
        $this->withoutExceptionHandling();
        $user=User::factory()->create();
        $this->assertInstanceOf(Collection::class,$user->projects);
    }

    /**@test*/
    public function test_guest_cannot_create_project(){
        $this->withoutExceptionHandling();
        $this->actingAs(User::factory()->create());
        $this->get('project/create')->assertStatus(200);
    }
}
