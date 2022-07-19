<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {

        $status = ['open', 'completed', 'canceled'];

        return [
            'title' => fake()->name(),
            'description' =>  fake()->text(),
            'tasks_status_id' => random_int(1, 3),
            'expiration' => now()
        ];
    }
}
