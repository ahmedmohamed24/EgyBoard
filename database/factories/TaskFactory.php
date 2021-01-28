<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user_id=auth()->id()??User::factory()->create();
        return [
            'body'=>$this->faker->sentence(),
            'owner_id'=>$user_id,
            'project_id'=>function() use ($user_id){
                return Project::factory()->create(['owner_id'=>$user_id]);
            }
        ];
    }
}
