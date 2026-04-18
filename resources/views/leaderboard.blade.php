@extends('layouts.app')

@section('title', 'LYVACOMMUNITY | LEADERBOARD')

@section('content')
<section class="page-hero">
  <div class="page-glow"></div>
  <div class="page-kicker">🏆 RANKING</div>
  <h1 class="page-title">Leaderboard LYVA Community</h1>
  <p class="page-copy">Halaman ini menampilkan peringkat pemain berdasarkan data komunitas yang dikelola melalui backend dan siap dikembangkan ke sistem penilaian otomatis di tahap berikutnya.</p>
</section>

<div class="divl"></div>

<div class="sw">
  <div class="sh">
    <div class="stag">📊 PERFORMANCE OVERVIEW</div>
    <h2 class="stitle">Peringkat Musim Berjalan</h2>
    <p class="sdesc">Data peringkat saat ini dikelola melalui backend dengan struktur yang telah disiapkan untuk mendukung integrasi penilaian otomatis ke depannya.</p>
  </div>

  <div class="lb-list">
    @forelse($leaderboardEntries as $index => $entry)
      @php
        $position = $index + 1;
        $cardClass = match ($position) {
            1 => 'lbc t1',
            2 => 'lbc t2',
            3 => 'lbc t3',
            default => 'lbc',
        };
        $rankClass = match ($position) {
            1 => 'lb-rank r1',
            2 => 'lb-rank r2',
            3 => 'lb-rank r3',
            default => 'lb-rank rn',
        };
        $rankLabel = match ($position) {
            1 => '🥇',
            2 => '🥈',
            3 => '🥉',
            default => '#'.$position,
        };
        $barWidth = max(8, (int) round(($entry->points / $topLeaderboardPoints) * 100));
        $barStyle = match ($position) {
            2 => 'background:linear-gradient(90deg,#c0c0c0,#e8e8e8)',
            3 => 'background:linear-gradient(90deg,#cd7f32,#e8a060)',
            default => '',
        };
      @endphp
      <div class="{{ $cardClass }}">
        <div class="{{ $rankClass }}">{{ $rankLabel }}</div>
        <span class="lb-av">{{ $entry->avatar_emoji }}</span>
        <div class="lb-inf">
          <div class="lb-name">{{ $entry->player_name }}</div>
          <div class="lb-sub">{{ $entry->headline ?? $entry->season }} • {{ number_format($entry->wins) }} Wins • {{ number_format($entry->events_joined) }} Events</div>
        </div>
        <div class="lb-bar-w">
          <div class="lb-bar" style="width:{{ $barWidth }}%;{{ $barStyle }}"></div>
        </div>
        <div class="lb-pts">{{ number_format($entry->points) }}</div>
      </div>
    @empty
      <div class="lbc">
        <div class="lb-rank rn">#0</div>
        <span class="lb-av">🏆</span>
        <div class="lb-inf">
          <div class="lb-name">Data Leaderboard Belum Tersedia</div>
          <div class="lb-sub">Tambahkan data peringkat melalui backend agar klasemen dapat ditampilkan pada halaman ini.</div>
        </div>
        <div class="lb-bar-w">
          <div class="lb-bar" style="width:8%"></div>
        </div>
        <div class="lb-pts">0</div>
      </div>
    @endforelse
  </div>
</div>
@endsection
