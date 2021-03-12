<?php

namespace Database\Factories;

use App\Models\Task;
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
        return [
          'provider_id' => $this->faker->numberBetween($min = 1, $max = 100),
          'consumer_id' => $this->faker->numberBetween($min = 1, $max = 60),
          'title' => $this->faker->realText($maxNbChars = 100, $indexSize = 2),
          'description' => $this->faker->realText($maxNbChars = 300, $indexSize = 2),
          'status' => $this->faker->numberBetween($min = 0, $max = 2),
          'created_at' => $this->faker->dateTimeBetween($startDate = '-4 days', $endDate = 'now', $timezone = null),
        ];
    }
}
