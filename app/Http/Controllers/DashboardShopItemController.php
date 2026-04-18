<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShopItemRequest;
use App\Http\Requests\UpdateShopItemRequest;
use App\Models\ShopItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DashboardShopItemController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('dashboard.shop-items.form', [
            'shopItem' => new ShopItem([
                'currency' => 'Robux',
                'stars' => 5,
                'sort_order' => 0,
                'is_active' => true,
            ]),
            'shopFormAction' => route('dashboard.shop-items.store'),
            'shopFormMethod' => 'POST',
            'shopFormTitle' => 'Tambah Item Shop',
            'shopFormSubtitle' => 'Buat item baru untuk catalog LYVA.',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShopItemRequest $request): RedirectResponse
    {
        ShopItem::query()->create($this->validatedPayload($request));

        return to_route('dashboard', ['page' => 'shop'])
            ->with('status', 'Item shop berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShopItem $shopItem): View
    {
        return view('dashboard.shop-items.form', [
            'shopItem' => $shopItem,
            'shopFormAction' => route('dashboard.shop-items.update', $shopItem),
            'shopFormMethod' => 'PUT',
            'shopFormTitle' => 'Edit Item Shop',
            'shopFormSubtitle' => 'Perbarui detail item yang sudah tampil di dashboard.',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShopItemRequest $request, ShopItem $shopItem): RedirectResponse
    {
        $shopItem->update($this->validatedPayload($request));

        return to_route('dashboard', ['page' => 'shop'])
            ->with('status', 'Item shop berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShopItem $shopItem): RedirectResponse
    {
        $shopItem->delete();

        return to_route('dashboard', ['page' => 'shop'])
            ->with('status', 'Item shop berhasil dihapus.');
    }

    /**
     * @return array{name:string,slug:string,emoji:string,badge_label:?string,badge_class:?string,price:int,currency:string,stars:int,gradient_from:string,gradient_to:string,sort_order:int,is_active:bool}
     */
    private function validatedPayload(StoreShopItemRequest|UpdateShopItemRequest $request): array
    {
        /** @var array{name:string,slug:string,emoji:string,badge_label:?string,price:int,currency:string,stars:int,gradient_from:string,gradient_to:string,sort_order:int,is_active:bool} $validated */
        $validated = $request->validated();

        $validated['badge_class'] = match ($validated['badge_label']) {
            'HOT' => 'bh',
            'NEW' => 'bn',
            'RARE' => 'br',
            'VIP' => 'bv',
            default => null,
        };

        return $validated;
    }
}
