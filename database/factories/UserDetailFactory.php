<?php

namespace Database\Factories;

use App\Models\UserDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UserDetail>
 */
class UserDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'phone' => fake()->phoneNumber(),
            'gender' => fake()->randomElement(['male', 'female']),
            'birth_date' => fake()->date(),
            'occupation' => fake()->jobTitle(),
            'institution' => fake()->company(),
            'city' => fake()->city(),
            'address' => fake()->address(),
        ];
    }
}
