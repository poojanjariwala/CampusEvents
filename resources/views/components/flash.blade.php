@if (session('success'))
  <div class="wrap"><div class="flash flash-success">{{ session('success') }}</div></div>
@endif
@if (session('error'))
  <div class="wrap"><div class="flash flash-error">{{ session('error') }}</div></div>
@endif
