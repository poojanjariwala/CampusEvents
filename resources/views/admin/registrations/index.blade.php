@extends('layouts.admin')

@section('title', 'Registrations')

@section('content')
<section class="page-head"><div class="wrap row-between">
  <div><h1>Registrations</h1><p class="muted">{{ $registrations->count() }} shown.</p></div>
  <a class="btn btn-primary" href="{{ route('admin.registrations.export', array_filter(['event' => $eventId])) }}">Download CSV</a>
</div></section>

<section class="section tight"><div class="wrap">
  <form class="toolbar" method="get" action="{{ route('admin.registrations.index') }}">
    <label class="sr-only" for="event">Filter by event</label>
    <select id="event" name="event" onchange="this.form.submit()">
      <option value="0">All events</option>
      @foreach ($events as $event)
        <option value="{{ $event->id }}" {{ $eventId === $event->id ? 'selected' : '' }}>{{ $event->title }}</option>
      @endforeach
    </select>
    <noscript><button class="btn btn-primary" type="submit">Filter</button></noscript>
  </form>

  <div class="card table-wrap">
    <table class="table">
      <thead><tr><th>Ref</th><th>Name</th><th>Event</th><th>Enrolment</th><th>Class</th><th>Contact</th><th class="right"></th></tr></thead>
      <tbody>
        @forelse ($registrations as $r)
          <tr>
            <td><code>{{ $r->refCode() }}</code></td>
            <td>{{ $r->name }}<br><small class="muted">{{ $r->created_at->format('d M, g:i A') }}</small></td>
            <td>{{ $r->event?->title ?? 'Removed event' }}</td>
            <td>{{ $r->enrollment }}</td>
            <td>{{ $r->class_name }}</td>
            <td>{{ $r->email }}<br><small class="muted">{{ $r->phone }}</small></td>
            <td class="right">
              <form method="post" action="{{ route('admin.registrations.destroy', $r) }}" class="inline" data-confirm="Remove the registration for {{ $r->name }}?">
                @csrf
                @method('DELETE')
                @if ($eventId)<input type="hidden" name="event" value="{{ $eventId }}">@endif
                <button class="btn btn-small btn-danger" type="submit">Remove</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="7" class="muted">No registrations found.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div></section>
@endsection
