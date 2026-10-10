@php
    // Redirect cleanly or render main Heads or Tails with Doubling mode active
@endphp
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="refresh" content="0; url={{ route('heads-or-tails') }}?mode=doubling">
    <script>window.location.href = "{{ route('heads-or-tails') }}?mode=doubling";</script>
</head>
<body>
</body>
</html>
