@extends('layouts.app')

@section('title', 'Gallery — LYVA Community')

@section('content')
<section class="page-hero">
  <div class="page-glow"></div>
  <div class="page-kicker">🖼️ DISCORD GALLERY</div>
  <h1 class="page-title">Momen Terbaik LYVA</h1>
  <p class="page-copy">Halaman ini menampilkan semua foto dan video dari channel Discord gallery LYVA Community. Setiap upload baru dari Discord akan ikut muncul di sini lewat integrasi otomatis.</p>
  <div class="page-actions">
    <a href="{{ $discordCommunity['invite_url'] ?? '#' }}" class="btn btn-p" target="_blank" rel="noreferrer">💬 Buka Discord</a>
    <a href="{{ route('home') }}" class="btn btn-g">🏠 Kembali Home</a>
  </div>
</section>

<div class="divl"></div>

<div class="sw">
  <div class="sh">
    <div class="stag">📸 LIVE FROM DISCORD</div>
    <h2 class="stitle">Gallery Community</h2>
    <p class="sdesc">Sekarang gallery dimuat per halaman biar loading lebih ringan. Tiap halaman menampilkan 12 media terbaru dari Discord.</p>
  </div>
  @php($galleryCardClasses = ['gi s2', 'gi tall', 'gi', 'gi', 'gi s2'])
  <div class="gal-grid">
    @forelse($galleryMedia as $index => $galleryItem)
      <div class="{{ $galleryCardClasses[$index] ?? 'gi' }}">
        @if($galleryItem['media_type'] === 'video')
          <video class="gi-media" controls preload="none" playsinline>
            <source src="{{ $galleryItem['media_url'] }}">
          </video>
        @else
          <img src="{{ $galleryItem['media_url'] }}" alt="{{ $galleryItem['title'] }}" class="gi-media" loading="lazy">
        @endif
        <div class="gi-ov"><div><div class="gi-name">{{ $galleryItem['title'] }}</div><div class="gi-meta">{{ $galleryItem['author'] }} • {{ \Illuminate\Support\Carbon::parse($galleryItem['posted_at'])->format('d M Y') }}</div></div></div>
      </div>
    @empty
      <div class="gi s2"><div class="gi-ph"><span class="gi-em">🖼️</span><span class="gi-lsm">NO MEDIA YET</span></div><div class="gi-ov"><div><div class="gi-name">Gallery Discord belum ada media</div><div class="gi-meta">Upload foto atau video ke channel gallery Discord untuk tampil di sini</div></div></div></div>
    @endforelse
  </div>

  @if($galleryMedia->hasPages())
    <div class="page-actions" style="margin-top:32px">
      @if($galleryMedia->onFirstPage())
        <span class="btn btn-g" style="opacity:.55;pointer-events:none">← Sebelumnya</span>
      @else
        <a href="{{ $galleryMedia->previousPageUrl() }}" class="btn btn-g">← Sebelumnya</a>
      @endif

      <span class="btn btn-g" style="pointer-events:none">
        Halaman {{ $galleryMedia->currentPage() }} / {{ $galleryMedia->lastPage() }}
      </span>

      @if($galleryMedia->hasMorePages())
        <a href="{{ $galleryMedia->nextPageUrl() }}" class="btn btn-p">Berikutnya →</a>
      @else
        <span class="btn btn-p" style="opacity:.55;pointer-events:none">Berikutnya →</span>
      @endif
    </div>
  @endif
</div>
@endsection
