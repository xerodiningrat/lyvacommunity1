@extends('layouts.app')

@section('title', 'Shop — LYVA Community')

@section('content')
<section class="page-hero">
  <div class="page-glow"></div>
  <div class="page-kicker">🛒 LYVA SHOP</div>
  <h1 class="page-title">Item Eksklusif</h1>
  <p class="page-copy">Halaman shop sekarang sudah terhubung ke backend. Semua item ditarik dari database, jadi nanti tinggal update data item tanpa edit Blade satu-satu lagi.</p>
</section>

<div class="divl"></div>

<div class="sw">
  <div class="sh">
    <div class="stag">🎯 BACKEND CONNECTED</div>
    <h2 class="stitle">Katalog LYVA</h2>
    <p class="sdesc">Item yang aktif otomatis tampil di sini berdasarkan data shop di backend.</p>
  </div>

  <div class="shop-grid">
    @forelse($shopItems as $shopItem)
      <div class="sc">
        <div class="sc-img" style="background:linear-gradient(145deg,{{ $shopItem->gradient_from }},{{ $shopItem->gradient_to }})">
          <div class="sc-shine"></div>
          {{ $shopItem->emoji }}
          @if($shopItem->badge_label)
            <div class="sc-badge {{ $shopItem->badge_class }}">{{ $shopItem->badge_label }}</div>
          @endif
        </div>
        <div class="sc-body">
          <div class="sc-name">{{ $shopItem->name }}</div>
          <div class="sc-pr">
            <span class="sc-pv">🪙 {{ number_format($shopItem->price) }}</span>
            <span class="sc-stars">{{ str_repeat('★', $shopItem->stars).str_repeat('☆', max(0, 5 - $shopItem->stars)) }}</span>
          </div>
          <div class="sc-pu">{{ $shopItem->currency }}</div>
          <button class="sc-btn" onclick="addCart('{{ addslashes($shopItem->name) }}')">🛒 Add to Cart</button>
        </div>
      </div>
    @empty
      <div class="sc">
        <div class="sc-img" style="background:linear-gradient(145deg,#071530,#0d3b5c)">
          <div class="sc-shine"></div>
          🛒
        </div>
        <div class="sc-body">
          <div class="sc-name">Shop Belum Ada Item</div>
          <div class="sc-pr">
            <span class="sc-pv">🪙 0</span>
            <span class="sc-stars">☆☆☆☆☆</span>
          </div>
          <div class="sc-pu">Robux</div>
          <button class="sc-btn" type="button">Segera Hadir</button>
        </div>
      </div>
    @endforelse
  </div>
</div>
@endsection
