@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<section class="page-head"><div class="wrap">
  <h1>Dashboard</h1>
  <p class="muted">Overview of events, registrations and messages.</p>
</div></section>

<section class="section tight"><div class="wrap">
  <div class="stat-cards">
    <div class="card stat"><span>Total events</span><b>{{ $eventCount }}</b></div>
    <div class="card stat"><span>Upcoming</span><b>{{ $upcoming->count() }}</b></div>
    <div class="card stat"><span>Registrations</span><b>{{ $registrationCount }}</b></div>
    <div class="card stat"><span>Messages</span><b>{{ $messageCount }}</b></div>
  </div>

  <div class="two-col">
    <div class="card">
      <h2>Seats filled per event</h2>
      @forelse ($upcoming as $event)
        <div class="bar-row">
          <div class="bar-label"><span>{{ $event->title }}</span><small>{{ $event->seatsTaken() }}/{{ $event->capacity }}</small></div>
          <div class="meter"><span style="width: {{ $event->fillPercent() }}%"></span></div>
        </div>
      @empty
        <p class="muted">No upcoming events.</p>
      @endforelse
    </div>

    <div class="card">
      <h2>Latest registrations</h2>
      @if ($recent->isNotEmpty())
        <table class="table compact">
          <thead><tr><th>Name</th><th>Event</th><th>Class</th></tr></thead>
          <tbody>
            @foreach ($recent as $r)
              <tr><td>{{ $r->name }}</td><td>{{ $r->event?->title ?? 'Removed event' }}</td><td>{{ $r->class_name }}</td></tr>
            @endforeach
          </tbody>
        </table>
      @else
        <p class="muted">No registrations yet.</p>
      @endif
      <p><a class="link-arrow" href="{{ route('admin.registrations.index') }}">All registrations &rarr;</a></p>
    </div>
  </div>
</div></section>
@endsection
