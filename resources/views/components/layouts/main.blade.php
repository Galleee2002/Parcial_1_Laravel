<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} · RestoCode</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col bg-white text-zinc-900 antialiased">
    <header class="bg-zinc-900 text-white">
        <nav class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4">
            <a class="text-lg font-semibold" href="{{ route('home') }}">RestoCode</a>
            <ul class="flex gap-6 text-sm">
                <li><a class="hover:text-blue-300" href="{{ route('home') }}">Inicio</a></li>
                <li><a class="hover:text-blue-300" href="{{ route('services.index') }}">Servicios</a></li>
                <li><a class="hover:text-blue-300" href="{{ route('blog.index') }}">Blog</a></li>
            </ul>
        </nav>
    </header>

    @isset($hero)
        {{ $hero }}
    @endisset

    <main class="mx-auto w-full max-w-6xl flex-1 px-4 py-8">
        @if (session()->has('feedback.message'))
            <div @class([
                'mb-6 rounded border px-4 py-3',
                'border-green-200 bg-green-50 text-green-800' => session('feedback.type', 'success') === 'success',
                'border-red-200 bg-red-50 text-red-800' => session('feedback.type', 'success') === 'danger',
            ])>{{ session('feedback.message') }}</div>
        @endif

        {{ $slot }}
    </main>

    <footer class="border-t border-zinc-200 py-4">
        <p class="mx-auto max-w-6xl px-4 text-sm text-zinc-500">RestoCode · soluciones digitales para gastronomía</p>
    </footer>
</body>
</html>
