<?php

namespace Database\Factories;

use App\Models\ShopItem;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<ShopItem>
 */
class ShopItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);

        return [
            'name' => Str::title($name),
            'slug' => Str::slug($name).'-'.fake()->unique()->numberBetween(100, 999),
            'emoji' => fake()->randomElement(['🗡️', '👑', '🐉', '🔥', '🛸', '⚡', '🌙', '🎭']),
            'badge_label' => fake()->optional()->randomElement(['HOT', 'NEW', 'RARE', 'VIP']),
            'badge_class' => fake()->optional()->randomElement(['bh', 'bn', 'br', 'bv']),
            'price' => fake()->numberBetween(250, 1200),
            'currency' => 'Robux',
            'stars' => fake()->numberBetween(3, 5),
            'gradient_from' => fake()->randomElement(['#061428', '#1a0d3b', '#04342c', '#3a0d0d', '#071530', '#1a1a04']),
            'gradient_to' => fake()->randomElement(['#1a3a6b', '#3a1a6b', '#0a3b2e', '#5a1a1a', '#0d3b5c', '#3b3b0a']),
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
