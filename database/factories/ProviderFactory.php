<?php

namespace Database\Factories;

use App\Models\Provider;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProviderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Provider::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
          'name' => $this->faker->name,
          'business_name' => $this->faker->company,
          'type_id' => $this->faker->numberBetween($min = 1, $max = 6),
          'email' => $this->faker->unique()->safeEmail,
          'email_verified_at' => now(),
          'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
          'contact' => $this->faker->numberBetween($min = 1000000000, $max = 9999999999),
          'address' => $this->faker->address,
          'locality' => 'Amrai',
          'latitude' => $this->faker->randomFloat($nbMaxDecimals=7, $min=19.227204, $max=19.243939),
          'longitude' => $this->faker->randomFloat($nbMaxDecimals=7, $min=73.125973, $max=73.148061),
          'last_seen' => $this->faker->dateTimeBetween($startDate = '-6 days', $endDate = 'now', $timezone = null),
          'business_document' => '/Documents/ProviderDocuments/1_business_document.pdf',
          'aadhar_card' => '/Documents/ProviderDocuments/1_business_document.pdf',
        ];
    }
}
