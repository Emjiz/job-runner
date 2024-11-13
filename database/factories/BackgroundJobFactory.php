<?php

// database/factories/BackgroundJobFactory.php
namespace Database\Factories;

use App\Models\BackgroundJob;
use Illuminate\Database\Eloquent\Factories\Factory;

class BackgroundJobFactory extends Factory
{
    protected $model = BackgroundJob::class;

    public function definition()
    {
        return [
            'class' => $this->faker->word,
            'method' => $this->faker->word,
            'parameters' => json_encode([
                'param1' => $this->faker->word,
                'param2' => $this->faker->numberBetween(1, 100),
            ]),
            'status' => $this->faker->randomElement(['pending', 'running', 'completed', 'failed', 'canceled']),
            'retry_count' => $this->faker->numberBetween(0, 5),
            'priority' => $this->faker->randomElement([1, 2, 3, 4, 5]),
            'scheduled_at' => $this->faker->dateTimeBetween('now', '+1 week'),
        ];
    }
}
