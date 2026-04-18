@extends('layouts.app')

@section('title', 'Leaderboard — LYVA Community')

@section('content')
<section class="page-hero">
  <div class="page-glow"></div>
  <div class="page-kicker">🏆 RANKING</div>
  <h1 class="page-title">Top Players LYVA</h1>
  <p class="page-copy">Leaderboard sekarang sudah manual dari database, tapi strukturnya sudah siap kalau nanti mau dihitung otomatis dari hasil event atau sumber komunitas lain.</p>
</section>

<div class="divl"></div>

<div class="sw">
  <div class="sh">
    <div class="stag">📊 BACKEND CONNECTED</div>
    <h2 class="stitle">Ranking Season Ini</h2>
    <p class="sdesc">Data rank disimpan manual dulu di backend, dengan kolom poin, wins, event joined, season, dan source supaya nanti gampang diotomatisasi.</p>
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
          <div class="lb-name">Leaderboard Belum Ada Data</div>
          <div class="lb-sub">Tambahkan rank manual di database agar tabel ranking muncul di sini.</div>
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
