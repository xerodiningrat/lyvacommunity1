<?php

use App\Models\CommunityEvent;
use App\Http\Controllers\ChatMessageController;
use App\Models\DiscordGalleryMedia;
use App\Models\LeaderboardEntry;
use App\Models\ShopItem;
use App\Http\Controllers\DiscordAuthController;
use App\Http\Controllers\DashboardCommunityEventController;
use App\Http\Controllers\DashboardShopItemController;
use App\Services\DiscordCommunityStats;
use App\Services\DiscordGallery;
use App\Services\DiscordLeadershipDirectory;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::get('/login', [DiscordAuthController::class, 'redirect'])->name('auth.discord.redirect');
Route::get('/auth/discord/callback', [DiscordAuthController::class, 'callback'])->name('auth.discord.callback');
Route::get('/logout', [DiscordAuthController::class, 'logout'])->name('auth.discord.logout');
Route::middleware('discord.auth')->group(function (): void {
    Route::get('/chat', [ChatMessageController::class, 'index'])->name('chat');
    Route::post('/chat', [ChatMessageController::class, 'store'])->name('chat.store');
    Route::get('/chat/state', [ChatMessageController::class, 'state'])->name('chat.state');
    Route::post('/chat/messages/{chatMessage}/react', [ChatMessageController::class, 'react'])->name('chat.react');
    Route::delete('/chat/messages/{chatMessage}', [ChatMessageController::class, 'destroy'])->name('chat.destroy');
});
Route::middleware('discord.core')->group(function (): void {
    Route::get('/dashboard', function (
        DiscordCommunityStats $discordCommunityStats,
        DiscordLeadershipDirectory $leadershipDirectory,
    ) {
        $community = $discordCommunityStats->get();
        $leadershipMembers = collect($leadershipDirectory->get())->values();
        $shopItems = ShopItem::query()->active()->ordered()->get();
        $communityEvents = CommunityEvent::query()->active()->ordered()->get();
        $leaderboardEntries = LeaderboardEntry::query()->active()->ordered()->get();
        $galleryMediaCount = DiscordGalleryMedia::query()->count();
        $catalogValue = (int) $shopItems->sum('price');
        $featuredItemsCount = $shopItems->filter(fn (ShopItem $shopItem) => filled($shopItem->badge_label))->count();
        $averageItemPrice = (int) round((float) ($shopItems->avg('price') ?? 0));
        $liveEventsCount = $communityEvents->where('status', 'live')->count();
        $upcomingEventsCount = $communityEvents->where('status', 'soon')->count();
        $finishedEventsCount = $communityEvents->where('status', 'finished')->count();
        $trackedRoleCount = $leadershipMembers->pluck('role')->unique()->count();
        $managementCount = $leadershipMembers->filter(function (array $member): bool {
            $roleName = mb_strtolower($member['role']);

            return str_contains($roleName, 'owner')
                || str_contains($roleName, 'admin')
                || str_contains($roleName, 'manager');
        })->count();

        $inventoryBreakdown = collect([
            ['label' => 'HOT', 'color' => '#1a6ef5', 'count' => $shopItems->where('badge_label', 'HOT')->count()],
            ['label' => 'RARE', 'color' => '#f5c842', 'count' => $shopItems->where('badge_label', 'RARE')->count()],
            ['label' => 'NEW', 'color' => '#00e5b8', 'count' => $shopItems->where('badge_label', 'NEW')->count()],
            ['label' => 'VIP', 'color' => '#ff4fa3', 'count' => $shopItems->where('badge_label', 'VIP')->count()],
            [
                'label' => 'LAINNYA',
                'color' => '#091833',
                'count' => $shopItems->filter(fn (ShopItem $shopItem) => blank($shopItem->badge_label))->count(),
            ],
        ])->filter(fn (array $segment) => $segment['count'] > 0)->values();

        $inventoryCircumference = 251.33;
        $inventoryDashOffset = 0.0;
        $inventorySegments = $inventoryBreakdown->map(function (array $segment) use ($inventoryBreakdown, $inventoryCircumference, &$inventoryDashOffset): array {
            $segmentLength = round(
                $inventoryCircumference * ($segment['count'] / max($inventoryBreakdown->sum('count'), 1)),
                2,
            );

            $segment['dash_array'] = sprintf('%.2f %.2f', $segmentLength, $inventoryCircumference);
            $segment['dash_offset'] = sprintf('%.2f', -$inventoryDashOffset);
            $inventoryDashOffset += $segmentLength;

            return $segment;
        });

        return view('dashboard', [
            'dashboardCommunity' => $community,
            'dashboardStats' => [
                'total_members' => (int) ($community['total_members'] ?? 0),
                'catalog_value' => $catalogValue,
                'active_members' => (int) ($community['active_members'] ?? 0),
                'gallery_media' => $galleryMediaCount,
            ],
            'dashboardTopPlayers' => $leaderboardEntries->take(5)->values(),
            'dashboardLeadership' => $leadershipMembers->map(function (array $member): array {
                $roleName = mb_strtolower($member['role']);

                return [
                    ...$member,
                    'role_class' => match (true) {
                        str_contains($roleName, 'owner') => 'c-own',
                        str_contains($roleName, 'admin'), str_contains($roleName, 'manager') => 'c-adm',
                        default => 'c-mod',
                    },
                    'avatar_state' => filled($member['avatar_url']) ? 'Avatar Discord' : 'Inisial',
                ];
            })->values(),
            'dashboardMemberStats' => [
                'total_members' => (int) ($community['total_members'] ?? 0),
                'active_members' => (int) ($community['active_members'] ?? 0),
                'leadership_members' => $leadershipMembers->count(),
                'management_members' => $managementCount,
                'tracked_roles' => $trackedRoleCount,
            ],
            'dashboardShopItems' => $shopItems->take(8)->values(),
            'dashboardShopStats' => [
                'catalog_value' => $catalogValue,
                'item_count' => $shopItems->count(),
                'average_price' => $averageItemPrice,
                'featured_items' => $featuredItemsCount,
                'inventory_segments' => $inventorySegments,
            ],
            'dashboardEvents' => $communityEvents->take(6)->values(),
            'dashboardEventStats' => [
                'total' => $communityEvents->count(),
                'live' => $liveEventsCount,
                'upcoming' => $upcomingEventsCount,
                'finished' => $finishedEventsCount,
            ],
        ]);
    })->name('dashboard');

    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::resource('shop-items', DashboardShopItemController::class)
            ->except(['index', 'show']);
        Route::resource('community-events', DashboardCommunityEventController::class)
            ->except(['index', 'show']);
    });
});
Route::get('/gallery', function (DiscordGallery $discordGallery) {
    return view('gallery', [
        'galleryMedia' => $discordGallery->paginate(12)->withQueryString(),
    ]);
})->name('gallery');
Route::get('/shop', function () {
    return view('shop', [
        'shopItems' => ShopItem::query()->active()->ordered()->get(),
    ]);
})->name('shop');
Route::get('/members', function (DiscordLeadershipDirectory $leadershipDirectory) {
    return view('members', [
        'discordLeadership' => $leadershipDirectory->get(),
    ]);
})->name('members');
Route::get('/events', function () {
    return view('events', [
        'communityEvents' => CommunityEvent::query()->active()->ordered()->get(),
    ]);
})->name('events');
Route::get('/leaderboard', function () {
    $entries = LeaderboardEntry::query()->active()->ordered()->get();
    $topPoints = max((int) ($entries->first()?->points ?? 0), 1);

    return view('leaderboard', [
        'leaderboardEntries' => $entries,
        'topLeaderboardPoints' => $topPoints,
    ]);
})->name('leaderboard');
