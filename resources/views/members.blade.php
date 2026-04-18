@extends('layouts.app')

@section('title', 'Members — LYVA Community')

@section('content')
<section class="page-hero">
  <div class="page-glow"></div>
  <div class="page-kicker">👥 CORE TEAM</div>
  <h1 class="page-title">Owner, Admin, dan Staff LYVA</h1>
  <p class="page-copy">Halaman ini fokus ke tim inti Discord LYVA Community. Jadi yang tampil hanya owner, admin, dan staff, tanpa bot dan tanpa member biasa.</p>
</section>

<div class="divl"></div>

<div class="sw">
  <div class="sh">
    <div class="stag">🛡️ DISCORD LEADERSHIP</div>
    <h2 class="stitle">Tim Inti Community</h2>
    <p class="sdesc">Data diambil dari role Discord LYVA. Kalau akses daftar member Discord terbuka, nama orangnya akan ikut tampil otomatis di sini.</p>
  </div>

  <div class="mem-grid">
    @forelse($discordLeadership as $leadershipMember)
      <div class="mc">
        <div class="mc-avw">
          <div class="mc-av" style="border-color:{{ $leadershipMember['badge_class'] === 'ro' ? 'rgba(245,200,66,.5)' : ($leadershipMember['badge_class'] === 'ra' ? 'rgba(255,79,163,.5)' : 'rgba(61,142,255,.4)') }};background:{{ $leadershipMember['badge_class'] === 'ro' ? 'rgba(245,200,66,.08)' : ($leadershipMember['badge_class'] === 'ra' ? 'rgba(255,79,163,.08)' : 'rgba(26,110,245,.08)') }}">
            @if($leadershipMember['avatar_url'])
              <img src="{{ $leadershipMember['avatar_url'] }}" alt="{{ $leadershipMember['name'] }}" class="mc-av-img" loading="lazy" referrerpolicy="no-referrer">
            @else
              {{ $leadershipMember['avatar_text'] }}
            @endif
          </div>
          <div class="mc-on"></div>
        </div>
        <div class="mc-name">{{ $leadershipMember['name'] }}</div>
        <span class="mc-role {{ $leadershipMember['badge_class'] }}">{{ $leadershipMember['role'] }}</span>
        <p class="mc-meta">{{ $leadershipMember['meta'] }}</p>
      </div>
    @empty
      <div class="mc">
        <div class="mc-avw">
          <div class="mc-av" style="border-color:rgba(61,142,255,.4)">LY</div>
        </div>
        <div class="mc-name">Tim Inti Belum Tersedia</div>
        <span class="mc-role rm">Staff</span>
        <p class="mc-meta">Data role Discord belum berhasil dibaca sekarang. Coba refresh lagi sebentar.</p>
      </div>
    @endforelse
  </div>
</div>
@endsection
