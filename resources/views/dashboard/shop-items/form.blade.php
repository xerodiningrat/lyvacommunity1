@extends('layouts.app')

@section('title', $shopFormTitle.' - LYVA Dashboard')

@section('content')
<section class="page-hero">
  <div class="page-glow"></div>
  <div class="page-kicker">Dashboard Shop</div>
  <h1 class="page-title">{{ $shopFormTitle }}</h1>
  <p class="page-copy">{{ $shopFormSubtitle }}</p>
  <div class="page-actions">
    <a href="{{ route('dashboard', ['page' => 'shop']) }}" class="btn btn-g">← Kembali ke Dashboard</a>
  </div>
</section>

<div class="divl"></div>

<section class="sw">
  @if ($errors->any())
    <div class="fc" style="max-width:880px;margin:0 auto 18px;border-color:rgba(255,68,68,.4);">
      <div class="fc-name">Validasi belum lengkap</div>
      <div class="fc-desc">
        @foreach ($errors->all() as $error)
          <div>{{ $error }}</div>
        @endforeach
      </div>
    </div>
  @endif

  <div class="fc" style="max-width:880px;margin:0 auto;padding:32px;">
    <form method="POST" action="{{ $shopFormAction }}" style="display:grid;gap:16px;">
      @csrf
      @if ($shopFormMethod !== 'POST')
        @method($shopFormMethod)
      @endif

      <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px;">
        <div>
          <label for="name" style="display:block;margin-bottom:8px;color:var(--white);font-weight:700;">Nama Item</label>
          <input id="name" name="name" type="text" class="mi" value="{{ old('name', $shopItem->name) }}" placeholder="Cyber Blade X">
        </div>
        <div>
          <label for="slug" style="display:block;margin-bottom:8px;color:var(--white);font-weight:700;">Slug</label>
          <input id="slug" name="slug" type="text" class="mi" value="{{ old('slug', $shopItem->slug) }}" placeholder="cyber-blade-x">
        </div>
        <div>
          <label for="emoji" style="display:block;margin-bottom:8px;color:var(--white);font-weight:700;">Emoji</label>
          <input id="emoji" name="emoji" type="text" class="mi" value="{{ old('emoji', $shopItem->emoji) }}" placeholder="🗡️">
        </div>
        <div>
          <label for="badge_label" style="display:block;margin-bottom:8px;color:var(--white);font-weight:700;">Badge</label>
          <select id="badge_label" name="badge_label" class="mi">
            <option value="">Tanpa badge</option>
            @foreach (['HOT', 'RARE', 'NEW', 'VIP'] as $badgeLabel)
              <option value="{{ $badgeLabel }}" @selected(old('badge_label', $shopItem->badge_label) === $badgeLabel)>{{ $badgeLabel }}</option>
            @endforeach
          </select>
        </div>
        <div>
          <label for="price" style="display:block;margin-bottom:8px;color:var(--white);font-weight:700;">Harga</label>
          <input id="price" name="price" type="number" min="0" class="mi" value="{{ old('price', $shopItem->price) }}" placeholder="450">
        </div>
        <div>
          <label for="currency" style="display:block;margin-bottom:8px;color:var(--white);font-weight:700;">Mata Uang</label>
          <input id="currency" name="currency" type="text" class="mi" value="{{ old('currency', $shopItem->currency) }}" placeholder="Robux">
        </div>
        <div>
          <label for="stars" style="display:block;margin-bottom:8px;color:var(--white);font-weight:700;">Bintang</label>
          <input id="stars" name="stars" type="number" min="0" max="5" class="mi" value="{{ old('stars', $shopItem->stars) }}">
        </div>
        <div>
          <label for="sort_order" style="display:block;margin-bottom:8px;color:var(--white);font-weight:700;">Urutan</label>
          <input id="sort_order" name="sort_order" type="number" min="0" class="mi" value="{{ old('sort_order', $shopItem->sort_order) }}">
        </div>
        <div>
          <label for="gradient_from" style="display:block;margin-bottom:8px;color:var(--white);font-weight:700;">Gradient Dari</label>
          <input id="gradient_from" name="gradient_from" type="text" class="mi" value="{{ old('gradient_from', $shopItem->gradient_from) }}" placeholder="#061428">
        </div>
        <div>
          <label for="gradient_to" style="display:block;margin-bottom:8px;color:var(--white);font-weight:700;">Gradient Ke</label>
          <input id="gradient_to" name="gradient_to" type="text" class="mi" value="{{ old('gradient_to', $shopItem->gradient_to) }}" placeholder="#1a3a6b">
        </div>
      </div>

      <label style="display:flex;align-items:center;gap:10px;color:var(--text2);font-weight:600;">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $shopItem->is_active))>
        Item aktif dan tampil di dashboard / halaman shop
      </label>

      <div class="page-actions" style="justify-content:flex-start;">
        <button type="submit" class="btn btn-p">{{ $shopFormMethod === 'POST' ? 'Simpan Item' : 'Update Item' }}</button>
        <a href="{{ route('dashboard', ['page' => 'shop']) }}" class="btn btn-g">Batal</a>
      </div>
    </form>
  </div>
</section>
@endsection
