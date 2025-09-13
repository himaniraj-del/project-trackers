<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Task;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(4),
            'status' => $this->faker->randomElement(['todo','in_progress','done']),
            'due_date' => $this->faker->optional()->dateTimeBetween('now','+30 days'),
            'priority' => $this->faker->randomElement(['low','medium','high']),
            'notes' => $this->faker->optional()->paragraph(),
        ];
    }
}
