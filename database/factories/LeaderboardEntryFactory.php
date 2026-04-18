<?php

namespace Database\Factories;

use App\Models\LeaderboardEntry;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<LeaderboardEntry>
 */
class LeaderboardEntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->userName();

        return [
            'player_name' => $name,
            'player_slug' => Str::slug($name).'-'.fake()->unique()->numberBetween(100, 999),
            'avatar_emoji' => fake()->randomElement(['⚡', '🐉', '🌙', '🎯', '🌺', '🦊']),
            'headline' => fake()->randomElement(['LYVA Legend', 'Pro Gamer', 'Admin', 'Pro', 'Member', 'Moderator']),
            'points' => fake()->numberBetween(10000, 100000),
            'wins' => fake()->numberBetween(5, 80),
            'events_joined' => fake()->numberBetween(5, 120),
            'season' => 'Season 1',
            'source' => fake()->randomElement(['manual', 'event']),
            'source_reference' => null,
            'sort_order' => fake()->numberBetween(1, 50),
            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (): array => [
            'is_active' => false,
        ]);
    }
}
