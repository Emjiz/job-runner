<?php

namespace Database\Factories;

use App\Models\BackgroundJob;
use Illuminate\Database\Eloquent\Factories\Factory;

class BackgroundJobFactory extends Factory
{
    protected $model = BackgroundJob::class;

    public function definition()
    {
        return [
            'class' => $this->faker->word,  // Generates a random word for the 'class' attribute
            'method' => $this->faker->word, // Generates a random word for the 'method' attribute
            'parameters' => json_encode([
                'param1' => $this->faker->word,
                'param2' => $this->faker->numberBetween(1, 100)
            ]),  // Encodes parameters as a JSON string, assuming they are stored as JSON
            'status' => $this->faker->randomElement(['pending', 'completed', 'failed', 'in_progress']), // Example statuses
            'retry_count' => $this->faker->numberBetween(0, 5),  // Random number between 0 and 5 for retry_count
            'priority' => $this->faker->randomElement(['low', 'medium', 'high']), // Random priority
            'scheduled_at' => $this->faker->dateTimeBetween('now', '+1 week'),  // Random scheduled date within the next week
        ];
    }
}
