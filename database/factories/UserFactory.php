<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = User::class;
    public function definition(): array
    {
        return [
            'username' => $this->faker->unique()->userName(),
            'department' => $this->faker->randomElement(['IT', 'HR', 'Finance', 'Sales', 'Marketing']),
            'email' => $this->faker->unique()->safeEmail(),
            'full_name' => $this->faker->name(),
            'phone' => $this->faker->unique()->numerify('628###########'),
            'role' => $this->faker->randomElement(['Admin', 'User']),
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
