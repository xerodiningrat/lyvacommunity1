<?php

namespace Database\Seeders;

use App\Models\LeaderboardEntry;
use Illuminate\Database\Seeder;

class LeaderboardEntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect([
            [
                'player_name' => 'ThunderZ',
                'player_slug' => 'thunderz',
                'avatar_emoji' => '⚡',
                'headline' => 'LYVA Legend',
                'points' => 98450,
                'wins' => 42,
                'events_joined' => 91,
                'season' => 'Season 1',
                'source' => 'manual',
                'source_reference' => null,
                'sort_order' => 10,
                'is_active' => true,
            ],
            [
                'player_name' => 'DragonLord',
                'player_slug' => 'dragonlord',
                'avatar_emoji' => '🐉',
                'headline' => 'Pro Gamer',
                'points' => 87200,
                'wins' => 37,
                'events_joined' => 78,
                'season' => 'Season 1',
                'source' => 'manual',
                'source_reference' => null,
                'sort_order' => 20,
                'is_active' => true,
            ],
            [
                'player_name' => 'MoonGirl',
                'player_slug' => 'moongirl',
                'avatar_emoji' => '🌙',
                'headline' => 'Admin',
                'points' => 82750,
                'wins' => 31,
                'events_joined' => 74,
                'season' => 'Season 1',
                'source' => 'manual',
                'source_reference' => null,
                'sort_order' => 30,
                'is_active' => true,
            ],
            [
                'player_name' => 'AimBot99',
                'player_slug' => 'aimbot99',
                'avatar_emoji' => '🎯',
                'headline' => 'Pro',
                'points' => 77300,
                'wins' => 24,
                'events_joined' => 63,
                'season' => 'Season 1',
                'source' => 'manual',
                'source_reference' => null,
                'sort_order' => 40,
                'is_active' => true,
            ],
            [
                'player_name' => 'PinkStar',
                'player_slug' => 'pinkstar',
                'avatar_emoji' => '🌺',
                'headline' => 'Member',
                'points' => 65100,
                'wins' => 18,
                'events_joined' => 56,
                'season' => 'Season 1',
                'source' => 'manual',
                'source_reference' => null,
                'sort_order' => 50,
                'is_active' => true,
            ],
            [
                'player_name' => 'FoxByte',
                'player_slug' => 'foxbyte',
                'avatar_emoji' => '🦊',
                'headline' => 'Moderator',
                'points' => 61800,
                'wins' => 16,
                'events_joined' => 52,
                'season' => 'Season 1',
                'source' => 'manual',
                'source_reference' => null,
                'sort_order' => 60,
                'is_active' => true,
            ],
        ])->each(function (array $entry): void {
            LeaderboardEntry::query()->updateOrCreate(
                ['player_slug' => $entry['player_slug']],
                $entry,
            );
        });
    }
}
