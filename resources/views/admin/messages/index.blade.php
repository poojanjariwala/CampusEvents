@extends('layouts.admin')

@section('title', 'Messages')

@section('content')
<section class="page-head"><div class="wrap">
  <h1>Messages</h1>
  <p class="muted">{{ $messages->count() }} received from the contact form.</p>
</div></section>

<section class="section tight"><div class="wrap">
  @forelse ($messages as $m)
    <article class="card msg">
      <div class="row-between">
        <div>
          <h3>{{ $m->subject }}</h3>
          <p class="muted">{{ $m->name }} &middot; <a href="mailto:{{ $m->email }}">{{ $m->email }}</a> &middot; {{ $m->created_at->format('d M Y, g:i A') }}</p>
        </div>
        <form method="post" action="{{ route('admin.messages.destroy', $m) }}" class="inline" data-confirm="Delete this message?">
          @csrf
          @method('DELETE')
          <button class="btn btn-small btn-danger" type="submit">Delete</button>
        </form>
      </div>
      <p class="msg-body">{!! nl2br(e($m->body)) !!}</p>
    </article>
  @empty
    <p class="empty">No messages yet.</p>
  @endforelse
</div></section>
@endsection
