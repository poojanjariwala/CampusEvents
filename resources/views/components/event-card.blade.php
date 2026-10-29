@props(['event'])

@php
    $left = $event->seatsLeft();
    $past = $event->isPast();
@endphp

<article class="event-card" data-search="{{ strtolower($event->title . ' ' . $event->venue . ' ' . $event->organizer . ' ' . $event->category) }}">
  <div class="date-block">
    <span class="d">{{ $event->starts_at->format('d') }}</span>
    <span class="m">{{ $event->starts_at->format('M') }}</span>
    <span class="y">{{ $event->starts_at->format('Y') }}</span>
  </div>
  <div class="event-body">
    <span class="pill pill-{{ $event->categoryClass() }}">{{ $event->category }}</span>
    <h3><a href="{{ route('events.show', $event) }}">{{ $event->title }}</a></h3>
    <ul class="meta">
      <li>{{ $event->starts_at->format('g:i A') }}</li>
      <li>{{ $event->venue }}</li>
      <li>{{ $event->fee > 0 ? 'Rs. ' . $event->fee : 'Free entry' }}</li>
    </ul>
    <div class="card-foot">
      @if ($past)
        <span class="seats closed">Event completed</span>
      @elseif ($left === 0)
        <span class="seats full">Registration full</span>
      @else
        <span class="seats">{{ $left }} seats left</span>
      @endif
      <a class="link-arrow" href="{{ route('events.show', $event) }}">Details &rarr;</a>
    </div>
  </div>
</article>
