<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} · RestoCode</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white text-zinc-900 antialiased">
    <header>
        <nav class="bg-zinc-900 text-white">
            <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4">
                <a class="text-lg font-semibold" href="{{ route('home') }}">RestoCode</a>
                <ul class="flex gap-6">
                    <li>
                        <a class="hover:text-zinc-300" href="{{ route('home') }}">Inicio</a>
                    </li>
                    <li>
                        <a class="hover:text-zinc-300" href="{{ url('/servicios') }}">Servicios</a>
                    </li>
                    <li>
                        <a class="hover:text-zinc-300" href="{{ url('/blog') }}">Blog</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    @if (session()->has('feedback.message'))
        <div class="mx-auto mt-3 max-w-6xl px-4">
            <div class="rounded border border-green-200 bg-green-50 px-4 py-3 text-green-800">
                {{ session('feedback.message') }}
            </div>
        </div>
    @endif

    <main>
        {{ $slot }}
    </main>

    <footer class="mt-12 border-t border-zinc-200 py-4">
        <div class="mx-auto max-w-6xl px-4">
            <p>RestoCode · soluciones digitales para gastronomía</p>
        </div>
    </footer>
</body>
</html>
