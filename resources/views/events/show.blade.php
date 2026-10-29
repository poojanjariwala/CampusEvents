@extends('layouts.app')

@section('title', $event->title)

@section('content')
@php
    $left = $event->seatsLeft();
    $taken = $event->seatsTaken();
    $past = $event->isPast();
@endphp
<section class="page-head">
  <div class="wrap">
    <p class="crumbs"><a href="{{ route('home') }}">Home</a> / <a href="{{ route('events.index') }}">Events</a> / {{ $event->title }}</p>
    <span class="pill pill-{{ $event->categoryClass() }}">{{ $event->category }}</span>
    <h1>{{ $event->title }}</h1>
  </div>
</section>

<section class="section tight">
  <div class="wrap detail-grid">
    <div>
      <div class="card">
        <h2>About this event</h2>
        @foreach (preg_split('/\R{2,}/', $event->description) as $para)
          <p>{{ trim($para) }}</p>
        @endforeach
        <dl class="facts">
          <div><dt>Date</dt><dd>{{ $event->starts_at->format('l, d F Y') }}</dd></div>
          <div><dt>Time</dt><dd>{{ $event->starts_at->format('g:i A') }}</dd></div>
          <div><dt>Venue</dt><dd>{{ $event->venue }}</dd></div>
          <div><dt>Organised by</dt><dd>{{ $event->organizer }}</dd></div>
          <div><dt>Entry</dt><dd>{{ $event->fee > 0 ? 'Rs. ' . $event->fee . ' per participant' : 'Free' }}</dd></div>
        </dl>
      </div>

      <div class="card">
        <h2>Seat availability</h2>
        <div class="meter" role="progressbar" aria-valuemin="0" aria-valuemax="{{ $event->capacity }}" aria-valuenow="{{ $taken }}">
          <span style="width: {{ $event->fillPercent() }}%"></span>
        </div>
        <p class="muted">{{ $taken }} of {{ $event->capacity }} seats booked &middot; <strong>{{ $left }} left</strong></p>
      </div>
    </div>

    <aside>
      @if ($past)
        <div class="card"><h2>Registration closed</h2><p class="muted">This event has already taken place.</p></div>
      @elseif ($left === 0)
        <div class="card"><h2>Registration full</h2><p class="muted">All seats are booked. Check other events on the <a href="{{ route('events.index') }}">events page</a>.</p></div>
      @else
        <form class="gform" method="post" action="{{ route('events.register', $event) }}" novalidate id="reg-form">
          @csrf
          <div class="gform-head">
            <h2>Register for this event</h2>
            <p>Fill every field marked with a red asterisk.</p>
          </div>
          @if ($errors->has('form'))<div class="flash flash-error">{{ $errors->first('form') }}</div>@endif

          <div class="q {{ $errors->has('name') ? 'has-error' : '' }}">
            <label for="name">Full name <i>*</i></label>
            <input id="name" name="name" type="text" autocomplete="name" value="{{ old('name') }}" required>
            <small class="err">{{ $errors->first('name') }}</small>
          </div>

          <div class="q {{ $errors->has('email') ? 'has-error' : '' }}">
            <label for="email">Email <i>*</i></label>
            <input id="email" name="email" type="email" autocomplete="email" value="{{ old('email') }}" required>
            <small class="err">{{ $errors->first('email') }}</small>
          </div>

          <div class="q {{ $errors->has('enrollment') ? 'has-error' : '' }}">
            <label for="enrollment">Enrolment number <i>*</i></label>
            <input id="enrollment" name="enrollment" type="text" value="{{ old('enrollment') }}" required>
            <small class="err">{{ $errors->first('enrollment') }}</small>
          </div>

          <div class="q {{ $errors->has('phone') ? 'has-error' : '' }}">
            <label for="phone">Mobile number <i>*</i></label>
            <input id="phone" name="phone" type="tel" inputmode="numeric" maxlength="10" autocomplete="tel" value="{{ old('phone') }}" required>
            <small class="err">{{ $errors->first('phone') }}</small>
          </div>

          <fieldset class="q {{ $errors->has('class_name') ? 'has-error' : '' }}">
            <legend>Class <i>*</i></legend>
            @foreach ($classOptions as $option)
              <label class="radio">
                <input type="radio" name="class_name" value="{{ $option }}" {{ old('class_name') === $option ? 'checked' : '' }}>
                <span class="dot"></span>{{ $option }}
              </label>
            @endforeach
            <small class="err">{{ $errors->first('class_name') }}</small>
          </fieldset>

          <div class="q {{ $errors->has('consent') ? 'has-error' : '' }}">
            <label class="check">
              <input type="checkbox" name="consent" value="1" {{ old('consent') ? 'checked' : '' }}>
              <span class="box"></span>
              <span>I confirm the details above are correct and will carry my college ID card.</span>
            </label>
            <small class="err">{{ $errors->first('consent') }}</small>
          </div>

          <div class="gform-foot">
            <button class="btn btn-primary" type="submit">Submit registration</button>
            <button class="btn-text" type="reset">Clear form</button>
          </div>
        </form>
      @endif
    </aside>
  </div>
</section>
@endsection
