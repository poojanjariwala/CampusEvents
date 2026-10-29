@extends('layouts.app')

@section('title', 'Registration confirmed')

@section('content')
<section class="section">
  <div class="wrap narrow">
    <div class="ticket">
      <div class="ticket-top">
        <p class="eyebrow">Registration confirmed</p>
        <h1>You're in, {{ \Illuminate\Support\Str::before($registration->name, ' ') }}.</h1>
        <p class="muted">Keep this reference handy &mdash; the volunteers at the venue desk will ask for it.</p>
      </div>
      <div class="ticket-ref">{{ $registration->refCode() }}</div>
      <dl class="facts">
        <div><dt>Event</dt><dd>{{ $registration->event->title }}</dd></div>
        <div><dt>When</dt><dd>{{ $registration->event->starts_at->format('D, d M Y, g:i A') }}</dd></div>
        <div><dt>Where</dt><dd>{{ $registration->event->venue }}</dd></div>
        <div><dt>Name</dt><dd>{{ $registration->name }}</dd></div>
        <div><dt>Enrolment</dt><dd>{{ $registration->enrollment }}</dd></div>
        <div><dt>Class</dt><dd>{{ $registration->class_name }}</dd></div>
      </dl>
      <div class="hero-actions">
        <button class="btn btn-primary" type="button" onclick="window.print()">Print this ticket</button>
        <a class="btn btn-ghost" href="{{ route('events.index') }}">Browse more events</a>
      </div>
    </div>
  </div>
</section>
@endsection
