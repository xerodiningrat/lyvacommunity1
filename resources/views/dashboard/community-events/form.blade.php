@extends('layouts.app')

@section('title', 'LYVACOMMUNITY | DASHBOARD EVENTS')

@section('content')
<section class="page-hero">
  <div class="page-glow"></div>
  <div class="page-kicker">Dashboard Events</div>
  <h1 class="page-title">{{ $eventFormTitle }}</h1>
  <p class="page-copy">{{ $eventFormSubtitle }}</p>
  <div class="page-actions">
    <a href="{{ route('dashboard', ['page' => 'events']) }}" class="btn btn-g">← Kembali ke Dashboard</a>
  </div>
</section>

<div class="divl"></div>

<section class="sw">
  @if ($errors->any())
    <div class="fc" style="max-width:880px;margin:0 auto 18px;border-color:rgba(255,68,68,.4);">
      <div class="fc-name">Validasi belum lengkap</div>
      <div class="fc-desc">
        @foreach ($errors->all() as $error)
          <div>{{ $error }}</div>
        @endforeach
      </div>
    </div>
  @endif

  <div class="fc form-shell">
    <form method="POST" action="{{ $eventFormAction }}" style="display:grid;gap:16px;">
      @csrf
      @if ($eventFormMethod !== 'POST')
        @method($eventFormMethod)
      @endif

      <div class="form-grid">
        <div class="form-field">
          <label for="name">Nama Event</label>
          <input id="name" name="name" type="text" class="mi" value="{{ old('name', $communityEvent->name) }}" placeholder="Mega Battle Tournament">
        </div>
        <div class="form-field">
          <label for="slug">Slug</label>
          <input id="slug" name="slug" type="text" class="mi" value="{{ old('slug', $communityEvent->slug) }}" placeholder="mega-battle-tournament">
        </div>
        <div class="form-field">
          <label for="icon">Icon</label>
          <input id="icon" name="icon" type="text" class="mi" value="{{ old('icon', $communityEvent->icon) }}" placeholder="⚔️">
        </div>
        <div class="form-field">
          <label for="event_date">Tanggal</label>
          <input id="event_date" name="event_date" type="date" class="mi" value="{{ old('event_date', optional($communityEvent->event_date)->format('Y-m-d') ?? $communityEvent->event_date) }}">
        </div>
        <div class="form-field">
          <label for="status">Status</label>
          <select id="status" name="status" class="mi">
            @foreach (['live' => 'Live', 'soon' => 'Soon', 'finished' => 'Finished'] as $statusValue => $statusLabel)
              <option value="{{ $statusValue }}" @selected(old('status', $communityEvent->status) === $statusValue)>{{ $statusLabel }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-field">
          <label for="sort_order">Urutan</label>
          <input id="sort_order" name="sort_order" type="number" min="0" class="mi" value="{{ old('sort_order', $communityEvent->sort_order) }}">
        </div>
      </div>

      <div class="form-field">
        <label for="description">Deskripsi</label>
        <textarea id="description" name="description" class="mi" style="min-height:160px;resize:vertical;">{{ old('description', $communityEvent->description) }}</textarea>
      </div>

      <label class="check-row">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $communityEvent->is_active))>
        Event aktif dan tampil di dashboard / halaman events
      </label>

      <div class="page-actions form-actions">
        <button type="submit" class="btn btn-p">{{ $eventFormMethod === 'POST' ? 'Simpan Event' : 'Update Event' }}</button>
        <a href="{{ route('dashboard', ['page' => 'events']) }}" class="btn btn-g">Batal</a>
      </div>
    </form>
  </div>
</section>
@endsection
