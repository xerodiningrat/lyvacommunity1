@extends('layouts.app')

@section('title', 'LYVACOMMUNITY | EVENTS')

@section('content')
<section class="page-hero">
  <div class="page-glow"></div>
  <div class="page-kicker">🎉 EVENTS</div>
  <h1 class="page-title">Agenda Event & Kompetisi</h1>
  <p class="page-copy">Halaman ini memuat agenda kegiatan komunitas yang dikelola melalui backend, sehingga pembaruan jadwal dan status event dapat dilakukan secara lebih efisien.</p>
</section>

<div class="divl"></div>

<div class="sw">
  <div class="sh">
    <div class="stag">📅 EVENT SCHEDULE</div>
    <h2 class="stitle">Agenda LYVA</h2>
    <p class="sdesc">Informasi event aktif, mendatang, dan yang telah selesai ditampilkan langsung dari data resmi komunitas.</p>
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
          <div class="ev-name">Belum Ada Event yang Dipublikasikan</div>
          <div class="ev-desc">Data agenda belum tersedia saat ini. Tambahkan event baru melalui backend agar tampil pada halaman ini.</div>
        </div>
        <span class="evb evd">Belum Tersedia</span>
      </div>
    @endforelse
  </div>
</div>
@endsection
