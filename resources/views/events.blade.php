@extends('layouts.app')

@section('title', 'Events — LYVA Community')

@section('content')
<section class="page-hero">
  <div class="page-glow"></div>
  <div class="page-kicker">🎉 EVENTS</div>
  <h1 class="page-title">Event & Kompetisi</h1>
  <p class="page-copy">Halaman event sekarang sudah tersambung ke backend. Semua jadwal tampil dari database, jadi nanti tinggal update event tanpa edit Blade satu-satu.</p>
</section>

<div class="divl"></div>

<div class="sw">
  <div class="sh">
    <div class="stag">📅 BACKEND CONNECTED</div>
    <h2 class="stitle">Agenda LYVA</h2>
    <p class="sdesc">Jadwal live, upcoming, dan event selesai ditarik langsung dari data event di backend.</p>
  </div>

  <div class="ev-list">
    @forelse($communityEvents as $event)
      <div class="evc">
        <div class="ev-date">
          <div class="ev-day">{{ $event->event_date->format('d') }}</div>
          <div class="ev-mon">{{ strtoupper($event->event_date->format('M')) }}</div>
        </div>
        <span class="ev-ic">{{ $event->icon }}</span>
        <div class="ev-inf">
          <div class="ev-name">{{ $event->name }}</div>
          <div class="ev-desc">{{ $event->description }}</div>
        </div>
        <span class="evb {{ $event->status_class }}">{{ $event->status_label }}</span>
      </div>
    @empty
      <div class="evc">
        <div class="ev-date">
          <div class="ev-day">--</div>
          <div class="ev-mon">---</div>
        </div>
        <span class="ev-ic">🎉</span>
        <div class="ev-inf">
          <div class="ev-name">Belum Ada Event Aktif</div>
          <div class="ev-desc">Data event dari backend belum tersedia sekarang. Tambahkan event baru agar tampil di halaman ini.</div>
        </div>
        <span class="evb evd">Kosong</span>
      </div>
    @endforelse
  </div>
</div>
@endsection
