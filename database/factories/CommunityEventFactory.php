<?php

namespace Database\Factories;

use App\Models\CommunityEvent;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<CommunityEvent>
 */
class CommunityEventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);
        $statuses = [
            ['status' => 'live', 'label' => '🔴 Live', 'class' => 'evl'],
            ['status' => 'soon', 'label' => '⏳ Soon', 'class' => 'evs'],
            ['status' => 'finished', 'label' => '✓ Selesai', 'class' => 'evd'],
        ];
        $status = fake()->randomElement($statuses);

        return [
            'name' => Str::title($name),
            'slug' => Str::slug($name).'-'.fake()->unique()->numberBetween(100, 999),
            'icon' => fake()->randomElement(['⚔️', '🏗️', '🎭', '🏎️', '🎮', '🚀']),
            'event_date' => fake()->dateTimeBetween('-7 days', '+30 days'),
            'status' => $status['status'],
            'status_label' => $status['label'],
            'status_class' => $status['class'],
            'description' => fake()->sentence(16),
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
