<?php

namespace Database\Factories;

use App\Enums\RoleNames;
use App\Models\User;
use Faker\Core\Uuid;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'surname' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'phone' => fake()->unique()->e164PhoneNumber(),
            'birthdate' => fake()->dateTimeBetween('-70 years', '-18 years')->format('Y-m-d'),
            'password' => Hash::make('SomeTestPassword'),
            'remember_token' => \Ramsey\Uuid\Uuid::uuid4()->getHex(),
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
    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            $user->assignRole(RoleNames::CUSTOMER->value);
        });
    }

    public function withEmail(string $email) {
        return $this->state(function (array $attrs) use ($email) {
            return [
                'email' => $email
            ];
        });
    }
}
