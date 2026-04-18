<?php

namespace Database\Seeders;

use App\Models\CommunityEvent;
use Illuminate\Database\Seeder;

class CommunityEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect([
            [
                'name' => 'Mega Battle Tournament',
                'slug' => 'mega-battle-tournament',
                'icon' => '⚔️',
                'event_date' => '2026-04-18',
                'status' => 'live',
                'status_label' => '🔴 Live',
                'status_class' => 'evl',
                'description' => 'Tournament PvP terbesar! 1v1, 2v2, 5v5. Total hadiah 50.000 Robux menanti pemenang!',
                'sort_order' => 10,
                'is_active' => true,
            ],
            [
                'name' => 'Build Challenge #12',
                'slug' => 'build-challenge-12',
                'icon' => '🏗️',
                'event_date' => '2026-04-22',
                'status' => 'soon',
                'status_label' => '⏳ Soon',
                'status_class' => 'evs',
                'description' => 'Tema Futuristic City. Hadiah 15.000 Robux menanti pemenang terbaik!',
                'sort_order' => 20,
                'is_active' => true,
            ],
            [
                'name' => 'Costume Night Contest',
                'slug' => 'costume-night-contest',
                'icon' => '🎭',
                'event_date' => '2026-04-25',
                'status' => 'soon',
                'status_label' => '⏳ Soon',
                'status_class' => 'evs',
                'description' => 'Pamerkan outfit terbaik dan biarkan vote komunitas menentukan pemenang.',
                'sort_order' => 30,
                'is_active' => true,
            ],
            [
                'name' => 'Speed Racing League',
                'slug' => 'speed-racing-league',
                'icon' => '🏎️',
                'event_date' => '2026-04-10',
                'status' => 'finished',
                'status_label' => '✓ Selesai',
                'status_class' => 'evd',
                'description' => 'Kompetisi balap bulanan dengan hadiah 20.000 Robux dan trophy eksklusif juara 1.',
                'sort_order' => 40,
                'is_active' => true,
            ],
        ])->each(function (array $event): void {
            CommunityEvent::query()->updateOrCreate(
                ['slug' => $event['slug']],
                $event,
            );
        });
    }
}
