<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'SmartCare' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Fredoka', sans-serif;}
        h1, b, strong { font-weight: 500; }
        h2, h3, { font-weight: 400; }
        .custom-link { color: #94a3b8; text-decoration: none; transition: all 0.2s; }
        .custom-link:hover { color: #000000; }
    </style>

    @stack('styles')
</head>
<body class="bg-[#F8F9FA]">
    
    @yield('body')

    <script>
        lucide.createIcons();
    </script>
    @stack('scripts')
</body>
</html>