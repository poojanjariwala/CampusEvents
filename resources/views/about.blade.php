@extends('layouts.app')

@section('title', 'About')

@section('content')
<section class="page-head">
  <div class="wrap">
    <h1>About CampusEvents</h1>
    <p class="muted">A college event management site built for the Web Technology self-learning component, IT-25 (A &amp; B).</p>
  </div>
</section>

<section class="section tight">
  <div class="wrap two-col">
    <div class="card">
      <h2>Why this exists</h2>
      <p>Event notices on the department WhatsApp groups get buried within an hour. Registrations happen on three different Google Forms and nobody knows how many seats are left until the day itself.</p>
      <p>CampusEvents puts the whole calendar on one page, tracks seats as people register, and gives organisers a single admin panel to manage events and export attendee lists.</p>
    </div>
    <div class="card">
      <h2>What students can do</h2>
      <ul class="ticks">
        <li>Browse upcoming and past events by category</li>
        <li>Search by name, venue or organiser</li>
        <li>See live seat availability</li>
        <li>Register once and get a printable reference</li>
        <li>Subscribe to the XML event feed</li>
      </ul>
    </div>
  </div>

  <div class="wrap">
    <div class="card">
      <h2>Syllabus topics used in this project</h2>
      <table class="table">
        <thead><tr><th>Topic</th><th>Where it is used</th></tr></thead>
        <tbody>
          <tr><td>HTML</td><td>Semantic Blade templates: header, main, section, article, form, fieldset, dl</td></tr>
          <tr><td>CSS</td><td>Custom properties, grid and flexbox, responsive breakpoints, print styles for the ticket</td></tr>
          <tr><td>JavaScript</td><td>Live event search, form validation, countdown timer, animated counters, mobile menu</td></tr>
          <tr><td>PHP</td><td>Object-oriented models, controllers, form requests, sessions, CSV export</td></tr>
          <tr><td>Laravel</td><td>Routing, controllers, Blade layouts and components, Eloquent models, migrations, seeders, form request validation, middleware, authentication</td></tr>
          <tr><td>XML</td><td>The <a href="{{ route('feed') }}">public event feed</a> is generated with PHP's DOM and displayed through an XSLT stylesheet</td></tr>
        </tbody>
      </table>
    </div>
  </div>
</section>
@endsection
