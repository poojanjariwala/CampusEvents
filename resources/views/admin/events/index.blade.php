@extends('layouts.admin')

@section('title', 'Manage events')

@section('content')
<section class="page-head"><div class="wrap row-between">
  <div><h1>Events</h1><p class="muted">{{ $events->count() }} in total.</p></div>
  <a class="btn btn-primary" href="{{ route('admin.events.create') }}">Add event</a>
</div></section>

<section class="section tight"><div class="wrap">
  <div class="card table-wrap">
    <table class="table">
      <thead><tr><th>Title</th><th>Category</th><th>Date</th><th>Venue</th><th>Booked</th><th class="right">Actions</th></tr></thead>
      <tbody>
        @forelse ($events as $event)
          <tr>
            <td><a href="{{ route('events.show', $event) }}" target="_blank" rel="noopener">{{ $event->title }}</a>@if ($event->isPast()) <small class="muted">(past)</small>@endif</td>
            <td><span class="pill pill-{{ $event->categoryClass() }}">{{ $event->category }}</span></td>
            <td>{{ $event->starts_at->format('d M Y') }}<br><small class="muted">{{ $event->starts_at->format('g:i A') }}</small></td>
            <td>{{ $event->venue }}</td>
            <td>{{ $event->seatsTaken() }}/{{ $event->capacity }}</td>
            <td class="right actions">
              <a class="btn btn-small btn-ghost" href="{{ route('admin.registrations.index', ['event' => $event->id]) }}">Attendees</a>
              <a class="btn btn-small btn-ghost" href="{{ route('admin.events.edit', $event) }}">Edit</a>
              <form method="post" action="{{ route('admin.events.destroy', $event) }}" class="inline" data-confirm="Delete &quot;{{ $event->title }}&quot; and all its registrations?">
                @csrf
                @method('DELETE')
                <button class="btn btn-small btn-danger" type="submit">Delete</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="6" class="muted">No events yet. Add your first one.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div></section>
@endsection
