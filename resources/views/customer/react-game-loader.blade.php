<!DOCTYPE html>
<html lang="en" class="{{ auth()->check() && auth()->user()->theme === 'light' ? 'light-theme' : '' }}">
<head>
  <meta charset="utf-8">
  <title>{{ $title ?? 'Casino Game' }} - 1XGAMES</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&family=Cinzel:wght@600;700;900&display=swap" rel="stylesheet">
  
  <script>
    window.IS_AUTH = {{ Auth::check() ? 'true' : 'false' }};
    window.USER_BALANCE = {{ Auth::check() ? (float)(Auth::user()->balance ?? 1000.00) : 1000.00 }};
    window.CSRF_TOKEN = "{{ csrf_token() }}";
  </script>

  @viteReactRefresh
  @vite(['resources/css/app.css', 'resources/js/app.jsx'])
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen overflow-x-hidden font-sans">
  <div id="react-game-root" data-game="{{ $gameKey }}" data-config='@json($settings ?? [])'></div>
</body>
</html>
