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
        <nav class="border-b border-zinc-800 bg-zinc-950 text-zinc-50">
            <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4">
                <a class="group flex items-center gap-2 text-lg font-semibold tracking-tight focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-blue-500" href="{{ route('home') }}">
                    <span class="size-1.5 rounded-full bg-cyan-400" aria-hidden="true"></span>
                    <span>Resto<span class="text-blue-500 transition-colors group-hover:text-blue-400">Code</span></span>
                </a>
                <ul class="flex gap-6 text-sm font-medium">
                    <li>
                        <a @class([
                            'transition-colors focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-blue-500',
                            'text-blue-500' => request()->routeIs('home'),
                            'text-zinc-400 hover:text-blue-400' => ! request()->routeIs('home'),
                        ]) href="{{ route('home') }}" @if (request()->routeIs('home')) aria-current="page" @endif>Inicio</a>
                    </li>
                    <li>
                        <a @class([
                            'transition-colors focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-blue-500',
                            'text-blue-500' => request()->routeIs('services.*'),
                            'text-zinc-400 hover:text-blue-400' => ! request()->routeIs('services.*'),
                        ]) href="{{ route('services.index') }}" @if (request()->routeIs('services.*')) aria-current="page" @endif>Servicios</a>
                    </li>
                    <li>
                        <a @class([
                            'transition-colors focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-blue-500',
                            'text-blue-500' => request()->routeIs('blog.*'),
                            'text-zinc-400 hover:text-blue-400' => ! request()->routeIs('blog.*'),
                        ]) href="{{ route('blog.index') }}" @if (request()->routeIs('blog.*')) aria-current="page" @endif>Blog</a>
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
