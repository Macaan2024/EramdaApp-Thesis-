<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Agencies list
        $agencies = ['BFP', 'CDRRMO', 'Hospital', 'BDRRMC'];

        // Pick a random agency
        $agency = $this->faker->randomElement($agencies);

        // Match user_type based on agency
        $userTypesByAgency = [
            'BFP'      => ['Operation Officer', 'Responders', 'Team Leader Responders'],
            'CDRRMO'   => ['Operation Officer', 'Responders', 'Team Leader Responders'],
            'BDRRMC'   => ['Operation Officer', 'Responders', 'Team Leader Responders'],
            'Hospital' => ['Nurse Chief'],
        ];

        $userType = $this->faker->randomElement($userTypesByAgency[$agency]);

        return [
            'agencies'        => $agency,
            'user_type'       => $userType,
            'email'           => $this->faker->unique()->safeEmail(),
            'password'        => Hash::make('password'), // hashed default password
            'lastname'        => $this->faker->lastName(),
            'firstname'       => $this->faker->firstName(),
            'gender'          => $this->faker->randomElement(['m', 'f']),
            'position'        => $this->faker->jobTitle(),
            'photo'           => null,
            'contact_number'  => $this->faker->phoneNumber(),
            'status'          => $this->faker->randomElement(['Pending', 'Inactive', 'Active']),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
