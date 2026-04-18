@extends('layouts.app')

@section('title', 'LYVACOMMUNITY | HOME')

@section('content')
<section class="hero">
  <div class="hero-glow"></div>
  <div class="hero-badge">🟢 Online &nbsp;•&nbsp; {{ $discordCommunity['active_members'] !== null ? number_format($discordCommunity['active_members']) . ' Member Aktif' : 'Komunitas Discord LYVA' }}</div>
  <h1 class="hero-title">LYVA<br><span class="ol">COMMUNITY</span></h1>
  <p class="hero-sub">LYVA Community adalah komunitas Roblox Indonesia yang menghadirkan ruang kolaboratif untuk bermain, berkembang, dan berpartisipasi dalam berbagai aktivitas komunitas secara lebih terstruktur.</p>
  <div class="hero-btns">
    <a href="{{ $discordAuthUser ? (($discordAuthUser['is_core_member'] ?? false) ? route('dashboard') : route('home')) : route('auth.discord.redirect') }}" class="btn btn-p">
      {{ $discordAuthUser ? (($discordAuthUser['is_core_member'] ?? false) ? '🧭 Akses Dashboard' : '🏠 Kembali ke Beranda') : '🔐 Login dengan Discord' }}
    </a>
    <a href="{{ route('gallery') }}" class="btn btn-g">🖼️ Jelajahi Galeri</a>
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
    <div class="stag">⚡ EXPLORE LYVA</div>
    <h2 class="stitle">Jelajahi Halaman Utama</h2>
    <p class="sdesc">Setiap halaman dirancang untuk menampilkan informasi komunitas secara lebih jelas, mulai dari galeri, katalog, tim inti, agenda kegiatan, hingga papan peringkat.</p>
  </div>
  <div class="feat-grid">
    <a href="{{ route('gallery') }}" class="fc"><div class="fc-icon">🖼️</div><div class="fc-name">Gallery</div><div class="fc-desc">Dokumentasi visual terbaik dari aktivitas komunitas yang dikurasi langsung dari kanal Discord LYVA.</div><span class="fc-arr">↗</span></a>
    <a href="{{ route('shop') }}" class="fc"><div class="fc-icon">🛒</div><div class="fc-name">Shop</div><div class="fc-desc">Katalog item komunitas yang menampilkan koleksi unggulan, item eksklusif, dan pembaruan produk terbaru.</div><span class="fc-arr">↗</span></a>
    <a href="{{ route('members') }}" class="fc"><div class="fc-icon">👥</div><div class="fc-name">Members</div><div class="fc-desc">Profil tim inti dan personel kunci yang berperan dalam pengelolaan serta pengembangan komunitas.</div><span class="fc-arr">↗</span></a>
    <a href="{{ route('events') }}" class="fc"><div class="fc-icon">🎉</div><div class="fc-name">Events</div><div class="fc-desc">Informasi agenda, turnamen, dan kegiatan komunitas yang sedang berlangsung maupun yang akan datang.</div><span class="fc-arr">↗</span></a>
    <a href="{{ route('leaderboard') }}" class="fc"><div class="fc-icon">🏆</div><div class="fc-name">Leaderboard</div><div class="fc-desc">Rekap performa pemain terbaik berdasarkan perolehan poin, kemenangan, dan partisipasi event.</div><span class="fc-arr">↗</span></a>
    <a href="{{ $discordCommunity['invite_url'] ?? '#' }}" class="fc" target="_blank" rel="noreferrer"><div class="fc-icon">💬</div><div class="fc-name">Discord Server</div><div class="fc-desc">Akses kanal komunikasi resmi LYVA Community untuk berdiskusi, berjejaring, dan mengikuti aktivitas harian.</div><span class="fc-arr">↗</span></a>
  </div>
</div>

<div class="divl"></div>

<div class="sw">
  <div class="sh">
    <div class="stag">🖼️ PREVIEW</div>
    <h2 class="stitle">Sorotan Galeri Terbaru</h2>
    <p class="sdesc">Cuplikan konten terbaru dari galeri komunitas. Buka halaman Gallery untuk melihat dokumentasi lengkap secara menyeluruh.</p>
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
      <div class="gi s2"><div class="gi-ph"><span class="gi-em">🖼️</span><span class="gi-lsm">DISCORD GALLERY</span></div><div class="gi-ov"><div><div class="gi-name">Galeri komunitas belum menampilkan media</div><div class="gi-meta">Unggah screenshot atau video ke kanal galeri Discord agar konten tampil di halaman ini.</div></div></div></div>
      <div class="gi tall"><div class="gi-ph"><span class="gi-em">⚡</span><span class="gi-lsm">LYVA</span></div></div>
      <div class="gi"><div class="gi-ph"><span class="gi-em">🚀</span><span class="gi-lsm">EVENT</span></div></div>
      <div class="gi"><div class="gi-ph"><span class="gi-em">🎮</span><span class="gi-lsm">COMMUNITY</span></div></div>
      <div class="gi s2"><div class="gi-ph"><span class="gi-em">📸</span><span class="gi-lsm">SCREENSHOTS</span></div></div>
    @endforelse
  </div>
</div>
@endsection
