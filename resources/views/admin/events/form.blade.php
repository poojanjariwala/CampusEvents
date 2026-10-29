@extends('layouts.admin')

@php
    $editing = $event->exists;
    $startsAt = old('starts_at', $event->starts_at?->format('Y-m-d\TH:i'));
@endphp

@section('title', $editing ? 'Edit event' : 'Add event')

@section('content')
<section class="page-head"><div class="wrap">
  <p class="crumbs"><a href="{{ route('admin.events.index') }}">Events</a> / {{ $editing ? 'Edit' : 'Add' }}</p>
  <h1>{{ $editing ? 'Edit event' : 'Add a new event' }}</h1>
</div></section>

<section class="section tight"><div class="wrap narrow">
  <form class="gform wide" method="post" novalidate id="event-form"
        action="{{ $editing ? route('admin.events.update', $event) : route('admin.events.store') }}">
    @csrf
    @if ($editing) @method('PUT') @endif

    <div class="q {{ $errors->has('title') ? 'has-error' : '' }}">
      <label for="title">Event title <i>*</i></label>
      <input id="title" name="title" type="text" value="{{ old('title', $event->title) }}" required>
      <small class="err">{{ $errors->first('title') }}</small>
    </div>

    <div class="q {{ $errors->has('category') ? 'has-error' : '' }}">
      <label for="category">Category <i>*</i></label>
      <select id="category" name="category">
        @foreach (\App\Models\Event::CATEGORIES as $c)
          <option value="{{ $c }}" {{ old('category', $event->category) === $c ? 'selected' : '' }}>{{ $c }}</option>
        @endforeach
      </select>
      <small class="err">{{ $errors->first('category') }}</small>
    </div>

    <div class="q {{ $errors->has('starts_at') ? 'has-error' : '' }}">
      <label for="starts_at">Date and start time <i>*</i></label>
      <input id="starts_at" name="starts_at" type="datetime-local" value="{{ $startsAt }}" required>
      <small class="err">{{ $errors->first('starts_at') }}</small>
    </div>

    <div class="field-row">
      <div class="q {{ $errors->has('venue') ? 'has-error' : '' }}">
        <label for="venue">Venue <i>*</i></label>
        <input id="venue" name="venue" type="text" value="{{ old('venue', $event->venue) }}" required>
        <small class="err">{{ $errors->first('venue') }}</small>
      </div>
      <div class="q {{ $errors->has('organizer') ? 'has-error' : '' }}">
        <label for="organizer">Organised by <i>*</i></label>
        <input id="organizer" name="organizer" type="text" value="{{ old('organizer', $event->organizer) }}" required>
        <small class="err">{{ $errors->first('organizer') }}</small>
      </div>
    </div>

    <div class="field-row">
      <div class="q {{ $errors->has('capacity') ? 'has-error' : '' }}">
        <label for="capacity">Seats <i>*</i></label>
        <input id="capacity" name="capacity" type="number" min="1" max="5000" value="{{ old('capacity', $event->capacity) }}" required>
        <small class="err">{{ $errors->first('capacity') }}</small>
      </div>
      <div class="q {{ $errors->has('fee') ? 'has-error' : '' }}">
        <label for="fee">Entry fee (Rs., 0 for free) <i>*</i></label>
        <input id="fee" name="fee" type="number" min="0" max="10000" value="{{ old('fee', $event->fee) }}" required>
        <small class="err">{{ $errors->first('fee') }}</small>
      </div>
    </div>

    <div class="q {{ $errors->has('description') ? 'has-error' : '' }}">
      <label for="description">Description <i>*</i></label>
      <textarea id="description" name="description" rows="6" required>{{ old('description', $event->description) }}</textarea>
      <small class="err">{{ $errors->first('description') }}</small>
    </div>

    <div class="gform-foot">
      <button class="btn btn-primary" type="submit">{{ $editing ? 'Save changes' : 'Add event' }}</button>
      <a class="btn-text" href="{{ route('admin.events.index') }}">Cancel</a>
    </div>
  </form>
</div></section>
@endsection
