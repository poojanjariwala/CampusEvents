@extends('layouts.app')

@section('content')
<section class="hero">
  <div class="wrap hero-grid">
    <div class="hero-copy">
      <p class="eyebrow">IT-25 (A &amp; B) &middot; Semester events</p>
      <h1>Find an event. Reserve a seat. Show up.</h1>
      <p class="lead">Hackathons, workshops, cultural nights and the inter-class cricket cup &mdash; everything the department is hosting this semester, with live seat counts and one-minute registration.</p>
      <div class="hero-actions">
        <a class="btn btn-primary" href="{{ route('events.index') }}">Browse events</a>
        <a class="btn btn-ghost" href="{{ route('about') }}">How it works</a>
      </div>
    </div>
    <aside class="hero-card" aria-label="Next event">
      @if ($next)
        <p class="eyebrow">Next up</p>
        <h2>{{ $next->title }}</h2>
        <p class="muted">{{ $next->starts_at->format('D, d M Y') }} &middot; {{ $next->starts_at->format('g:i A') }}<br>{{ $next->venue }}</p>
        <div class="countdown" data-target="{{ $next->starts_at->format('Y-m-d\TH:i:s') }}">
          <div><b data-u="d">--</b><span>days</span></div>
          <div><b data-u="h">--</b><span>hours</span></div>
          <div><b data-u="m">--</b><span>mins</span></div>
          <div><b data-u="s">--</b><span>secs</span></div>
        </div>
        <a class="btn btn-primary btn-block" href="{{ route('events.show', $next) }}">Register now</a>
      @else
        <h2>No upcoming events</h2>
        <p class="muted">New events are added regularly. Check back soon.</p>
      @endif
    </aside>
  </div>
</section>

<section class="stats">
  <div class="wrap stats-row">
    <div><b data-count="{{ $upcomingCount }}">0</b><span>Upcoming events</span></div>
    <div><b data-count="{{ $registrationCount }}">0</b><span>Registrations so far</span></div>
    <div><b data-count="{{ count(\App\Models\Event::CATEGORIES) }}">0</b><span>Event categories</span></div>
    <div><b data-count="{{ count(\App\Models\Registration::CLASS_OPTIONS) }}">0</b><span>Batches participating</span></div>
  </div>
</section>

<section class="section">
  <div class="wrap">
    <div class="section-head">
      <div>
        <h2>Coming up</h2>
        <p class="muted">The next few events on the calendar.</p>
      </div>
      <a class="link-arrow" href="{{ route('events.index') }}">View all events &rarr;</a>
    </div>
    <div class="grid-3">
      @forelse ($featured as $event)
        <x-event-card :event="$event" />
      @empty
        <p class="empty">Nothing scheduled right now.</p>
      @endforelse
    </div>
  </div>
</section>

<section class="section section-tint">
  <div class="wrap">
    <div class="section-head"><div><h2>Browse by category</h2></div></div>
    @php
        $blurbs = [
            'Technical' => 'Hackathons, quizzes and coding contests.',
            'Workshop'  => 'Hands-on sessions with a laptop on your lap.',
            'Seminar'   => 'Talks from alumni and industry guests.',
            'Cultural'  => 'Dance, music, drama and the annual fest.',
            'Sports'    => 'Inter-class tournaments and fitness drives.',
        ];
    @endphp
    <div class="cat-grid">
      @foreach (\App\Models\Event::CATEGORIES as $category)
        <a class="cat-card" href="{{ route('events.index', ['cat' => $category]) }}">
          <span class="pill pill-{{ strtolower($category) }}">{{ $category }}</span>
          <p>{{ $blurbs[$category] }}</p>
          <small>{{ $categoryCounts->get($category, 0) }} upcoming</small>
        </a>
      @endforeach
    </div>
  </div>
</section>

<section class="section">
  <div class="wrap">
    <div class="section-head"><div><h2>Register in three steps</h2></div></div>
    <ol class="steps">
      <li><h3>Pick an event</h3><p>Filter by category or search by name, venue or organiser.</p></li>
      <li><h3>Fill the form</h3><p>Name, email, enrolment number and your class &mdash; the same details the department already collects.</p></li>
      <li><h3>Get your reference</h3><p>You receive a registration ID instantly. Show it at the venue desk.</p></li>
    </ol>
  </div>
</section>
@endsection
