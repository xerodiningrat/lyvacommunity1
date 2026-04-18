@extends('layouts.app')

@section('title', 'LYVACOMMUNITY | DASHBOARD SHOP')

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

  <div class="fc form-shell">
    <form method="POST" action="{{ $shopFormAction }}" style="display:grid;gap:16px;">
      @csrf
      @if ($shopFormMethod !== 'POST')
        @method($shopFormMethod)
      @endif

      <div class="form-grid">
        <div class="form-field">
          <label for="name">Nama Item</label>
          <input id="name" name="name" type="text" class="mi" value="{{ old('name', $shopItem->name) }}" placeholder="Cyber Blade X">
        </div>
        <div class="form-field">
          <label for="slug">Slug</label>
          <input id="slug" name="slug" type="text" class="mi" value="{{ old('slug', $shopItem->slug) }}" placeholder="cyber-blade-x">
        </div>
        <div class="form-field">
          <label for="emoji">Emoji</label>
          <input id="emoji" name="emoji" type="text" class="mi" value="{{ old('emoji', $shopItem->emoji) }}" placeholder="🗡️">
        </div>
        <div class="form-field">
          <label for="badge_label">Badge</label>
          <select id="badge_label" name="badge_label" class="mi">
            <option value="">Tanpa badge</option>
            @foreach (['HOT', 'RARE', 'NEW', 'VIP'] as $badgeLabel)
              <option value="{{ $badgeLabel }}" @selected(old('badge_label', $shopItem->badge_label) === $badgeLabel)>{{ $badgeLabel }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-field">
          <label for="price">Harga</label>
          <input id="price" name="price" type="number" min="0" class="mi" value="{{ old('price', $shopItem->price) }}" placeholder="450">
        </div>
        <div class="form-field">
          <label for="currency">Mata Uang</label>
          <input id="currency" name="currency" type="text" class="mi" value="{{ old('currency', $shopItem->currency) }}" placeholder="Robux">
        </div>
        <div class="form-field">
          <label for="stars">Bintang</label>
          <input id="stars" name="stars" type="number" min="0" max="5" class="mi" value="{{ old('stars', $shopItem->stars) }}">
        </div>
        <div class="form-field">
          <label for="sort_order">Urutan</label>
          <input id="sort_order" name="sort_order" type="number" min="0" class="mi" value="{{ old('sort_order', $shopItem->sort_order) }}">
        </div>
        <div class="form-field">
          <label for="gradient_from">Gradient Dari</label>
          <input id="gradient_from" name="gradient_from" type="text" class="mi" value="{{ old('gradient_from', $shopItem->gradient_from) }}" placeholder="#061428">
        </div>
        <div class="form-field">
          <label for="gradient_to">Gradient Ke</label>
          <input id="gradient_to" name="gradient_to" type="text" class="mi" value="{{ old('gradient_to', $shopItem->gradient_to) }}" placeholder="#1a3a6b">
        </div>
      </div>

      <label class="check-row">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $shopItem->is_active))>
        Item aktif dan tampil di dashboard / halaman shop
      </label>

      <div class="page-actions form-actions">
        <button type="submit" class="btn btn-p">{{ $shopFormMethod === 'POST' ? 'Simpan Item' : 'Update Item' }}</button>
        <a href="{{ route('dashboard', ['page' => 'shop']) }}" class="btn btn-g">Batal</a>
      </div>
    </form>
  </div>
</section>
@endsection
