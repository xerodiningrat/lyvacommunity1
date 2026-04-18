<?php

namespace Database\Seeders;

use App\Models\ShopItem;
use Illuminate\Database\Seeder;

class ShopItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect([
            [
                'name' => 'Cyber Blade X',
                'slug' => 'cyber-blade-x',
                'emoji' => '🗡️',
                'badge_label' => 'HOT',
                'badge_class' => 'bh',
                'price' => 450,
                'currency' => 'Robux',
                'stars' => 5,
                'gradient_from' => '#061428',
                'gradient_to' => '#1a3a6b',
                'sort_order' => 10,
                'is_active' => true,
            ],
            [
                'name' => 'Golden Crown',
                'slug' => 'golden-crown',
                'emoji' => '👑',
                'badge_label' => 'RARE',
                'badge_class' => 'br',
                'price' => 999,
                'currency' => 'Robux',
                'stars' => 5,
                'gradient_from' => '#1a0d3b',
                'gradient_to' => '#3a1a6b',
                'sort_order' => 20,
                'is_active' => true,
            ],
            [
                'name' => 'Dragon Wings',
                'slug' => 'dragon-wings',
                'emoji' => '🐉',
                'badge_label' => 'NEW',
                'badge_class' => 'bn',
                'price' => 750,
                'currency' => 'Robux',
                'stars' => 4,
                'gradient_from' => '#04342c',
                'gradient_to' => '#0a3b2e',
                'sort_order' => 30,
                'is_active' => true,
            ],
            [
                'name' => 'Fire Aura Pack',
                'slug' => 'fire-aura-pack',
                'emoji' => '🔥',
                'badge_label' => 'HOT',
                'badge_class' => 'bh',
                'price' => 380,
                'currency' => 'Robux',
                'stars' => 4,
                'gradient_from' => '#3a0d0d',
                'gradient_to' => '#5a1a1a',
                'sort_order' => 40,
                'is_active' => true,
            ],
            [
                'name' => 'UFO Ride',
                'slug' => 'ufo-ride',
                'emoji' => '🛸',
                'badge_label' => 'NEW',
                'badge_class' => 'bn',
                'price' => 620,
                'currency' => 'Robux',
                'stars' => 4,
                'gradient_from' => '#071530',
                'gradient_to' => '#0d3b5c',
                'sort_order' => 50,
                'is_active' => true,
            ],
            [
                'name' => 'Thunder Armor',
                'slug' => 'thunder-armor',
                'emoji' => '⚡',
                'badge_label' => 'VIP',
                'badge_class' => 'bv',
                'price' => 890,
                'currency' => 'Robux',
                'stars' => 5,
                'gradient_from' => '#1a1a04',
                'gradient_to' => '#3b3b0a',
                'sort_order' => 60,
                'is_active' => true,
            ],
            [
                'name' => 'Moon Katana',
                'slug' => 'moon-katana',
                'emoji' => '🌙',
                'badge_label' => null,
                'badge_class' => null,
                'price' => 540,
                'currency' => 'Robux',
                'stars' => 4,
                'gradient_from' => '#1a043a',
                'gradient_to' => '#3a0a6b',
                'sort_order' => 70,
                'is_active' => true,
            ],
            [
                'name' => 'Phantom Mask',
                'slug' => 'phantom-mask',
                'emoji' => '🎭',
                'badge_label' => 'NEW',
                'badge_class' => 'bn',
                'price' => 320,
                'currency' => 'Robux',
                'stars' => 3,
                'gradient_from' => '#003a3a',
                'gradient_to' => '#006060',
                'sort_order' => 80,
                'is_active' => true,
            ],
        ])->each(function (array $item): void {
            ShopItem::query()->updateOrCreate(
                ['slug' => $item['slug']],
                $item,
            );
        });
    }
}
