<?php

namespace App\Providers;

use App\Services\DiscordCommunityStats;
use App\Services\DiscordGallery;
use Throwable;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(DiscordCommunityStats $discordCommunityStats, DiscordGallery $discordGallery): void
    {
        View::composer('*', function ($view) use ($discordCommunityStats, $discordGallery): void {
            $community = [
                'active_members' => null,
                'total_members' => null,
                'events_count' => 0,
                'years_active' => null,
                'founded_year' => null,
                'invite_url' => (string) config('services.discord.invite_url', ''),
                'server_name' => null,
            ];
            $gallery = [];

            try {
                $community = $discordCommunityStats->get();

                if (request()->routeIs('home')) {
                    $gallery = $discordGallery->get(5);
                }
            } catch (Throwable $exception) {
                report($exception);
            }

            $view->with('discordCommunity', $community);
            $view->with('discordGallery', $gallery);
        });
    }
}
