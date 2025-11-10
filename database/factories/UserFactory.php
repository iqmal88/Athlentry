<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'Name' => $this->faker->name(),
            'Email' => $this->faker->unique()->safeEmail(),
            'Password' => Hash::make('password123'),
            'MatricNo' => strtoupper($this->faker->bothify('A####')),
            'Role' => 'student',
            'MedicalHistory' => $this->faker->sentence(6),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
