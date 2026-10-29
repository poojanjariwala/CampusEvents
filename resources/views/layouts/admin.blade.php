<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title', 'Admin') | {{ config('app.name') }} Admin</title>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="admin-body">
<header class="site-header">
  <div class="wrap header-row">
    <a class="brand" href="{{ route('admin.dashboard') }}">
      <span class="brand-mark">CE</span>
      <span class="brand-text"><strong>{{ config('app.name') }} Admin</strong><small>Signed in as {{ auth()->user()->name }}</small></span>
    </a>
    <button class="nav-toggle" aria-label="Toggle menu" aria-expanded="false" aria-controls="main-nav"><span></span><span></span><span></span></button>
    <nav id="main-nav" class="main-nav">
      <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
      <a href="{{ route('admin.events.index') }}" class="{{ request()->routeIs('admin.events.*') ? 'active' : '' }}">Events</a>
      <a href="{{ route('admin.registrations.index') }}" class="{{ request()->routeIs('admin.registrations.*') ? 'active' : '' }}">Registrations</a>
      <a href="{{ route('admin.messages.index') }}" class="{{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">Messages</a>
      <a href="{{ route('home') }}">View site</a>
      <form method="POST" action="{{ route('admin.logout') }}" class="inline">
        @csrf
        <button type="submit" class="nav-logout">Log out</button>
      </form>
    </nav>
  </div>
</header>
<main>
  <x-flash />
  @yield('content')
</main>
<script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
