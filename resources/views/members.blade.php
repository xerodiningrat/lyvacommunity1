@extends('layouts.app')

@section('title', 'LYVACOMMUNITY | MEMBERS')

@section('content')
<div class="sw">
  <div class="sh">
    <div class="stag">🛡️ DISCORD LEADERSHIP</div>
    <h2 class="stitle">Struktur Kepengurusan</h2>
    <p class="sdesc">Data ditampilkan berdasarkan peran Discord LYVA. Apabila akses daftar anggota tersedia, nama dan profil anggota inti akan tersinkronisasi secara otomatis.</p>
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
        <div class="mc-name">Data Tim Inti Belum Tersedia</div>
        <span class="mc-role rm">Staff</span>
        <p class="mc-meta">Data struktur Discord belum berhasil dimuat saat ini. Silakan coba beberapa saat lagi.</p>
      </div>
    @endforelse
  </div>
</div>
@endsection
