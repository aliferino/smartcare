<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'SmartCare' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
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
</head>
<body class="bg-[#F8F9FA] overflow-hidden">
    <div class="flex h-screen w-full overflow-hidden">
        @include('layouts.partials.sidebar')

        <main class="flex-1 overflow-y-auto">
            <div class="p-8">
                @yield('content')
            </div>
        </main>
    </div>
</body>
<script>
    lucide.createIcons();
</script>
</html>