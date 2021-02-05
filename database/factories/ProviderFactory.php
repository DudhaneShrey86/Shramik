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
          'type_id' => $this->faker->numberBetween($min = 1, $max = 3),
          'email' => $this->faker->unique()->safeEmail,
          'email_verified_at' => now(),
          'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
          'contact' => $this->faker->numberBetween($min = 1000000000, $max = 9999999999),
          'address' => $this->faker->address,
          'locality' => 'Amrai',
          'latitude' => $this->faker->randomFloat($nbMaxDecimals=7, $min=19.228762, $max=19.245195),
          'longitude' => $this->faker->randomFloat($nbMaxDecimals=7, $min=73.118252, $max=73.152455),
          'last_seen' => now(),
          'business_document' => '/Documents/ProviderDocuments/1_business_document.pdf',
          'aadhar_card' => '/Documents/ProviderDocuments/1_business_document.pdf',
        ];
    }
}
