@extends('layouts.app')

@section('title', 'LYVACOMMUNITY | GALLERY')

@section('content')
<section class="page-hero">
  <div class="page-glow"></div>
  <div class="page-kicker">🖼️ DISCORD GALLERY</div>
  <h1 class="page-title">Galeri Komunitas LYVA</h1>
  <p class="page-copy">Halaman ini menampilkan dokumentasi visual dari aktivitas LYVA Community yang tersinkronisasi dari kanal galeri Discord secara berkala.</p>
  <div class="page-actions">
    <a href="{{ $discordCommunity['invite_url'] ?? '#' }}" class="btn btn-p" target="_blank" rel="noreferrer">💬 Kunjungi Discord</a>
    <a href="{{ route('home') }}" class="btn btn-g">🏠 Kembali ke Beranda</a>
  </div>
</section>

<div class="divl"></div>

<div class="sw">
  <div class="sh">
    <div class="stag">📸 LIVE FROM DISCORD</div>
    <h2 class="stitle">Dokumentasi Komunitas</h2>
    <p class="sdesc">Media ditampilkan per halaman untuk menjaga performa dan kenyamanan akses. Setiap halaman memuat 12 unggahan terbaru dari Discord.</p>
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
      <div class="gi s2"><div class="gi-ph"><span class="gi-em">🖼️</span><span class="gi-lsm">NO MEDIA YET</span></div><div class="gi-ov"><div><div class="gi-name">Belum ada media yang dipublikasikan</div><div class="gi-meta">Unggah foto atau video ke kanal galeri Discord agar konten tampil di halaman ini.</div></div></div></div>
    @endforelse
  </div>

  @if($galleryMedia->hasPages())
    <div class="page-actions" style="margin-top:32px">
      @if($galleryMedia->onFirstPage())
        <span class="btn btn-g" style="opacity:.55;pointer-events:none">← Halaman Sebelumnya</span>
      @else
        <a href="{{ $galleryMedia->previousPageUrl() }}" class="btn btn-g">← Halaman Sebelumnya</a>
      @endif

      <span class="btn btn-g" style="pointer-events:none">
        Halaman {{ $galleryMedia->currentPage() }} / {{ $galleryMedia->lastPage() }}
      </span>

      @if($galleryMedia->hasMorePages())
        <a href="{{ $galleryMedia->nextPageUrl() }}" class="btn btn-p">Halaman Berikutnya →</a>
      @else
        <span class="btn btn-p" style="opacity:.55;pointer-events:none">Halaman Berikutnya →</span>
      @endif
    </div>
  @endif
</div>
@endsection
