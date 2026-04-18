<?php

use App\Models\CommunityEvent;
use App\Models\ShopItem;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

test('dashboard shop item form can be opened', function () {
    fakeDiscordStatsForDashboardForms();

    $this->get(route('dashboard.shop-items.create'))
        ->assertOk()
        ->assertSeeText('Tambah Item Shop');
});

test('dashboard community event form can be opened', function () {
    fakeDiscordStatsForDashboardForms();

    $communityEvent = CommunityEvent::factory()->create();

    $this->get(route('dashboard.community-events.edit', $communityEvent))
        ->assertOk()
        ->assertSeeText('Edit Event');
});

test('dashboard shop items can be created', function () {
    $response = $this->post(route('dashboard.shop-items.store'), [
        'name' => 'Sky Hammer',
        'slug' => 'sky-hammer',
        'emoji' => '🔨',
        'badge_label' => 'HOT',
        'price' => 550,
        'currency' => 'Robux',
        'stars' => 4,
        'gradient_from' => '#112233',
        'gradient_to' => '#445566',
        'sort_order' => 90,
        'is_active' => '1',
    ]);

    $response->assertRedirect(route('dashboard', ['page' => 'shop']));

    $this->assertDatabaseHas('shop_items', [
        'slug' => 'sky-hammer',
        'badge_class' => 'bh',
        'price' => 550,
    ]);
});

test('dashboard shop items can be updated', function () {
    $shopItem = ShopItem::factory()->create([
        'name' => 'Old Blade',
        'slug' => 'old-blade',
        'badge_label' => 'HOT',
        'badge_class' => 'bh',
    ]);

    $response = $this->put(route('dashboard.shop-items.update', $shopItem), [
        'name' => 'Nova Blade',
        'slug' => 'nova-blade',
        'emoji' => '🗡️',
        'badge_label' => 'VIP',
        'price' => 720,
        'currency' => 'Robux',
        'stars' => 5,
        'gradient_from' => '#010203',
        'gradient_to' => '#040506',
        'sort_order' => 15,
        'is_active' => '1',
    ]);

    $response->assertRedirect(route('dashboard', ['page' => 'shop']));

    $this->assertDatabaseHas('shop_items', [
        'id' => $shopItem->id,
        'name' => 'Nova Blade',
        'slug' => 'nova-blade',
        'badge_class' => 'bv',
    ]);
});

test('dashboard shop items can be deleted', function () {
    $shopItem = ShopItem::factory()->create();

    $response = $this->delete(route('dashboard.shop-items.destroy', $shopItem));

    $response->assertRedirect(route('dashboard', ['page' => 'shop']));

    $this->assertDatabaseMissing('shop_items', [
        'id' => $shopItem->id,
    ]);
});

test('dashboard community events can be created', function () {
    $response = $this->post(route('dashboard.community-events.store'), [
        'name' => 'Arena Clash',
        'slug' => 'arena-clash',
        'icon' => '⚔️',
        'event_date' => '2026-05-01',
        'status' => 'live',
        'description' => 'Battle event terbaru untuk komunitas LYVA.',
        'sort_order' => 12,
        'is_active' => '1',
    ]);

    $response->assertRedirect(route('dashboard', ['page' => 'events']));

    $this->assertDatabaseHas('community_events', [
        'slug' => 'arena-clash',
        'status_label' => '🔴 Live',
        'status_class' => 'evl',
    ]);
});

test('dashboard community events can be updated', function () {
    $communityEvent = CommunityEvent::factory()->create([
        'name' => 'Old Event',
        'slug' => 'old-event',
        'status' => 'soon',
        'status_label' => '⏳ Soon',
        'status_class' => 'evs',
    ]);

    $response = $this->put(route('dashboard.community-events.update', $communityEvent), [
        'name' => 'Updated Event',
        'slug' => 'updated-event',
        'icon' => '🎯',
        'event_date' => '2026-05-07',
        'status' => 'finished',
        'description' => 'Event sudah selesai dan siap ditampilkan.',
        'sort_order' => 33,
        'is_active' => '1',
    ]);

    $response->assertRedirect(route('dashboard', ['page' => 'events']));

    $this->assertDatabaseHas('community_events', [
        'id' => $communityEvent->id,
        'slug' => 'updated-event',
        'status_label' => '✓ Selesai',
        'status_class' => 'evd',
    ]);
});

test('dashboard community events can be deleted', function () {
    $communityEvent = CommunityEvent::factory()->create();

    $response = $this->delete(route('dashboard.community-events.destroy', $communityEvent));

    $response->assertRedirect(route('dashboard', ['page' => 'events']));

    $this->assertDatabaseMissing('community_events', [
        'id' => $communityEvent->id,
    ]);
});

function fakeDiscordStatsForDashboardForms(): void
{
    Config::set('services.discord.invite_url', 'https://discord.gg/test-community');

    Http::fake([
        'https://discord.com/api/v10/invites/test-community*' => Http::response([
            'approximate_member_count' => 1053,
            'approximate_presence_count' => 595,
            'guild' => [
                'id' => '1425164983691382859',
                'name' => 'LYVA Community',
            ],
        ]),
    ]);
}
