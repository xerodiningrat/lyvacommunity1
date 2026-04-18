@extends('layouts.app')

@section('title', 'LYVA Community — Roblox Indonesia')

@section('content')
<section class="hero">
  <div class="hero-glow"></div>
  <div class="hero-badge">🟢 Online &nbsp;•&nbsp; {{ $discordCommunity['active_members'] !== null ? number_format($discordCommunity['active_members']) . ' Member Aktif' : 'Komunitas Discord LYVA' }}</div>
  <h1 class="hero-title">LYVA<br><span class="ol">COMMUNITY</span></h1>
  <p class="hero-sub">Komunitas Roblox terbaik dan paling aktif di Indonesia. Sekarang menu navbar sudah punya halaman sendiri, jadi lebih rapi buat jelajah gallery, shop, member, event, dan leaderboard.</p>
  <div class="hero-btns">
    <button class="btn btn-p" onclick="om('mJoin')">🚀 Gabung Sekarang</button>
    <a href="{{ route('gallery') }}" class="btn btn-g">🖼️ Lihat Gallery</a>
  </div>
  <div class="hero-stats">
    <div class="h-stat"><div class="h-stat-n">{{ ($discordCommunity['total_members'] ?? null) !== null ? number_format($discordCommunity['total_members']) . '+' : '0' }}</div><div class="h-stat-l">Members</div></div>
    <div class="h-div"></div>
    <div class="h-stat"><div class="h-stat-n">{{ $discordCommunity['events_count'] ?? 0 }}</div><div class="h-stat-l">Events</div></div>
    <div class="h-div"></div>
    <div class="h-stat"><div class="h-stat-n">{{ $discordCommunity['years_active'] ?? 0 }}</div><div class="h-stat-l">Tahun</div></div>
  </div>
</section>

<div class="divl"></div>

<div class="sw">
  <div class="sh">
    <div class="stag">⚡ Explore LYVA</div>
    <h2 class="stitle">Pilih Halaman Utama</h2>
    <p class="sdesc">Sekarang setiap menu punya halaman sendiri. Klik salah satu untuk masuk ke bagian yang kamu mau.</p>
  </div>
  <div class="feat-grid">
    <a href="{{ route('gallery') }}" class="fc"><div class="fc-icon">🖼️</div><div class="fc-name">Gallery</div><div class="fc-desc">Lihat screenshot asli dari channel gallery Discord LYVA yang otomatis ditarik ke website.</div><span class="fc-arr">↗</span></a>
    <a href="{{ route('shop') }}" class="fc"><div class="fc-icon">🛒</div><div class="fc-name">Shop</div><div class="fc-desc">Buka halaman item eksklusif, bundle rare, dan highlight produk komunitas LYVA.</div><span class="fc-arr">↗</span></a>
    <a href="{{ route('members') }}" class="fc"><div class="fc-icon">👥</div><div class="fc-name">Members</div><div class="fc-desc">Kenalan dengan member unggulan, admin, moderator, dan pemain yang paling aktif.</div><span class="fc-arr">↗</span></a>
    <a href="{{ route('events') }}" class="fc"><div class="fc-icon">🎉</div><div class="fc-name">Events</div><div class="fc-desc">Pantau event yang sedang live, turnamen mendatang, dan aktivitas komunitas terbaru.</div><span class="fc-arr">↗</span></a>
    <a href="{{ route('leaderboard') }}" class="fc"><div class="fc-icon">🏆</div><div class="fc-name">Leaderboard</div><div class="fc-desc">Cek ranking pemain terbaik dan progres top member LYVA Community bulan ini.</div><span class="fc-arr">↗</span></a>
    <a href="{{ $discordCommunity['invite_url'] ?? '#' }}" class="fc" target="_blank" rel="noreferrer"><div class="fc-icon">💬</div><div class="fc-name">Discord Server</div><div class="fc-desc">Masuk ke server Discord resmi LYVA untuk ngobrol, upload screenshot, dan ikut event.</div><span class="fc-arr">↗</span></a>
  </div>
</div>

<div class="divl"></div>

<div class="sw">
  <div class="sh">
    <div class="stag">🖼️ Preview</div>
    <h2 class="stitle">Gallery Terbaru</h2>
    <p class="sdesc">Cuplikan terbaru dari channel gallery Discord LYVA. Buka halaman Gallery untuk lihat semuanya.</p>
  </div>
  @php($galleryCardClasses = ['gi s2', 'gi tall', 'gi', 'gi', 'gi s2'])
  <div class="gal-grid">
    @forelse(collect($discordGallery)->take(5) as $index => $galleryItem)
      <a href="{{ route('gallery') }}" class="{{ $galleryCardClasses[$index] ?? 'gi' }}">
        @if($galleryItem['media_type'] === 'video')
          <video class="gi-media" muted playsinline preload="none">
            <source src="{{ $galleryItem['media_url'] }}">
          </video>
        @else
          <img src="{{ $galleryItem['media_url'] }}" alt="{{ $galleryItem['title'] }}" class="gi-media" loading="lazy">
        @endif
        <div class="gi-ov"><div><div class="gi-name">{{ $galleryItem['title'] }}</div><div class="gi-meta">{{ $galleryItem['author'] }} • {{ \Illuminate\Support\Carbon::parse($galleryItem['posted_at'])->format('d M Y') }}</div></div></div>
      </a>
    @empty
      <div class="gi s2"><div class="gi-ph"><span class="gi-em">🖼️</span><span class="gi-lsm">DISCORD GALLERY</span></div><div class="gi-ov"><div><div class="gi-name">Gallery Discord belum ada gambar</div><div class="gi-meta">Upload screenshot ke channel gallery Discord untuk tampil di sini</div></div></div></div>
      <div class="gi tall"><div class="gi-ph"><span class="gi-em">⚡</span><span class="gi-lsm">LYVA</span></div></div>
      <div class="gi"><div class="gi-ph"><span class="gi-em">🚀</span><span class="gi-lsm">EVENT</span></div></div>
      <div class="gi"><div class="gi-ph"><span class="gi-em">🎮</span><span class="gi-lsm">COMMUNITY</span></div></div>
      <div class="gi s2"><div class="gi-ph"><span class="gi-em">📸</span><span class="gi-lsm">SCREENSHOTS</span></div></div>
    @endforelse
  </div>
</div>
@endsection
