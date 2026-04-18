<?php

namespace App\Providers;

use App\Services\DiscordCommunityStats;
use App\Services\DiscordGallery;
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
            $view->with('discordCommunity', $discordCommunityStats->get());
            $view->with('discordGallery', request()->routeIs('home') ? $discordGallery->get(5) : []);
        });
    }
}
