@extends('layouts.app')

@section('title', 'Events')

@section('content')
@php
    // current filters, used to build every chip link
    $base = array_filter(['cat' => $category, 'q' => $term, 'show' => $show]);
@endphp
<section class="page-head">
  <div class="wrap">
    <h1>All events</h1>
    <p class="muted">Showing {{ $events->count() }} {{ \Illuminate\Support\Str::plural('event', $events->count()) }}{{ $category ? ' in ' . $category : '' }}.</p>
  </div>
</section>

<section class="section tight">
  <div class="wrap">
    <form class="toolbar" method="get" action="{{ route('events.index') }}">
      <input type="hidden" name="show" value="{{ $show }}">
      @if ($category)<input type="hidden" name="cat" value="{{ $category }}">@endif
      <label class="sr-only" for="q">Search events</label>
      <input id="q" type="search" name="q" value="{{ $term }}" placeholder="Search by name, venue or organiser">
      <button class="btn btn-primary" type="submit">Search</button>
    </form>

    <div class="chips">
      <a class="chip {{ $category === null ? 'on' : '' }}" href="{{ route('events.index', array_diff_key($base, ['cat' => 1])) }}">All</a>
      @foreach (\App\Models\Event::CATEGORIES as $c)
        <a class="chip {{ $category === $c ? 'on' : '' }}" href="{{ route('events.index', array_merge($base, ['cat' => $c])) }}">{{ $c }}</a>
      @endforeach
      <span class="chip-gap"></span>
      <a class="chip {{ $show === 'upcoming' ? 'on' : '' }}" href="{{ route('events.index', array_merge($base, ['show' => 'upcoming'])) }}">Upcoming</a>
      <a class="chip {{ $show === 'past' ? 'on' : '' }}" href="{{ route('events.index', array_merge($base, ['show' => 'past'])) }}">Past</a>
      <a class="chip {{ $show === 'all' ? 'on' : '' }}" href="{{ route('events.index', array_merge($base, ['show' => 'all'])) }}">All dates</a>
    </div>

    <div class="grid-3" id="event-grid">
      @foreach ($events as $event)
        <x-event-card :event="$event" />
      @endforeach
    </div>
    <p class="empty" id="no-results" @if ($events->isNotEmpty()) hidden @endif>No events match your filters. <a href="{{ route('events.index') }}">Clear filters</a></p>
  </div>
</section>
@endsection
