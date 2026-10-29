@extends('layouts.app')

@section('title', 'Contact')

@section('content')
<section class="page-head">
  <div class="wrap">
    <h1>Contact the organisers</h1>
    <p class="muted">Questions about an event, a registration or hosting your own? Write to us.</p>
  </div>
</section>

<section class="section tight">
  <div class="wrap detail-grid">
    <form class="gform" method="post" action="{{ route('contact.send') }}" novalidate id="contact-form">
      @csrf
      <div class="gform-head"><h2>Send a message</h2><p>Fields marked with a red asterisk are required.</p></div>

      <div class="q {{ $errors->has('name') ? 'has-error' : '' }}">
        <label for="c-name">Name <i>*</i></label>
        <input id="c-name" name="name" type="text" value="{{ old('name') }}" required>
        <small class="err">{{ $errors->first('name') }}</small>
      </div>
      <div class="q {{ $errors->has('email') ? 'has-error' : '' }}">
        <label for="c-email">Email <i>*</i></label>
        <input id="c-email" name="email" type="email" value="{{ old('email') }}" required>
        <small class="err">{{ $errors->first('email') }}</small>
      </div>
      <div class="q {{ $errors->has('subject') ? 'has-error' : '' }}">
        <label for="c-subject">Subject <i>*</i></label>
        <input id="c-subject" name="subject" type="text" value="{{ old('subject') }}" required>
        <small class="err">{{ $errors->first('subject') }}</small>
      </div>
      <div class="q {{ $errors->has('message') ? 'has-error' : '' }}">
        <label for="c-message">Message <i>*</i></label>
        <textarea id="c-message" name="message" rows="5" required>{{ old('message') }}</textarea>
        <small class="err">{{ $errors->first('message') }}</small>
      </div>
      <div class="gform-foot"><button class="btn btn-primary" type="submit">Send message</button></div>
    </form>

    <aside>
      <div class="card">
        <h2>Event desk</h2>
        <dl class="facts">
          <div><dt>Location</dt><dd>IT Department office, Block B, 2nd floor</dd></div>
          <div><dt>Email</dt><dd>events&#64;campusevents.local</dd></div>
          <div><dt>Hours</dt><dd>Mon&ndash;Sat, 9:30 AM &ndash; 4:30 PM</dd></div>
        </dl>
      </div>
      <div class="card">
        <h2>Want to host an event?</h2>
        <p>Faculty coordinators and class representatives can request a slot. Mention the date, expected turnout and venue in your message.</p>
      </div>
    </aside>
  </div>
</section>
@endsection
