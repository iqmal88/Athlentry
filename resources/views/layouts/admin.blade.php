<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Athlentry Admin' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700&family=Poppins:wght@400;600&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #0f172a, #1e3a8a);
        min-height: 100vh;
        color: #f8fafc;
    }
</style>
</head>
<body class="flex items-center justify-center">
    <main>
        @yield('content')
    </main>
</body>
</html>
