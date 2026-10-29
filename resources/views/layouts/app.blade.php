<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@hasSection('title')@yield('title') | {{ config('app.name') }}@else{{ config('app.name') }} | College Event Management @endif</title>
<meta name="description" content="Browse and register for technical, cultural and sports events at the Department of Information Technology.">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
<header class="site-header">
  <div class="wrap header-row">
    <a class="brand" href="{{ route('home') }}">
      <span class="brand-mark">CE</span>
      <span class="brand-text"><strong>{{ config('app.name') }}</strong><small>Department of Information Technology</small></span>
    </a>
    <button class="nav-toggle" aria-label="Toggle menu" aria-expanded="false" aria-controls="main-nav"><span></span><span></span><span></span></button>
    <nav id="main-nav" class="main-nav">
      <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
      <a href="{{ route('events.index') }}" class="{{ request()->routeIs('events.*') ? 'active' : '' }}">Events</a>
      <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About</a>
      <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
      <a href="{{ route('admin.login') }}" class="nav-admin">Admin</a>
    </nav>
  </div>
</header>
<main>
  <x-flash />
  @yield('content')
</main>
<footer class="site-footer">
  <div class="wrap footer-grid">
    <div>
      <h4>{{ config('app.name') }}</h4>
      <p>One place for every technical, cultural and sports event on campus. Built for the WT SL component, IT-25 (A &amp; B).</p>
    </div>
    <div>
      <h4>Explore</h4>
      <ul>
        <li><a href="{{ route('events.index') }}">All events</a></li>
        <li><a href="{{ route('events.index', ['cat' => 'Technical']) }}">Technical</a></li>
        <li><a href="{{ route('events.index', ['cat' => 'Cultural']) }}">Cultural</a></li>
        <li><a href="{{ route('feed') }}">XML feed</a></li>
      </ul>
    </div>
    <div>
      <h4>Get in touch</h4>
      <ul>
        <li>Department of Information Technology</li>
        <li>events&#64;campusevents.local</li>
        <li>Mon&ndash;Sat, 9:30 AM &ndash; 4:30 PM</li>
      </ul>
    </div>
  </div>
  <div class="wrap footer-bottom">&copy; {{ date('Y') }} {{ config('app.name') }} &middot; IT-25 WT_SL Component</div>
</footer>
<script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
