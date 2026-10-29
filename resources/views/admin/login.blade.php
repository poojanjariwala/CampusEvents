<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin login | {{ config('app.name') }}</title>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="login-body">
  <div class="login-box">
    <a class="brand" href="{{ route('home') }}"><span class="brand-mark">CE</span><span class="brand-text"><strong>{{ config('app.name') }}</strong><small>Admin panel</small></span></a>
    <form class="gform" method="post" action="{{ route('admin.login.store') }}">
      @csrf
      <div class="gform-head"><h2>Sign in</h2><p>Organisers and faculty coordinators only.</p></div>
      @if ($errors->any())
        <div class="flash flash-error">{{ $errors->first('form') ?: $errors->first() }}</div>
      @endif
      <div class="q">
        <label for="email">Email <i>*</i></label>
        <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="username" required autofocus>
      </div>
      <div class="q">
        <label for="password">Password <i>*</i></label>
        <input id="password" name="password" type="password" autocomplete="current-password" required>
      </div>
      <div class="gform-foot"><button class="btn btn-primary" type="submit">Sign in</button><a class="btn-text" href="{{ route('home') }}">Back to site</a></div>
    </form>
  </div>
</body>
</html>
