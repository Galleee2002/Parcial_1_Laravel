<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} · Panel RestoCode</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-zinc-50 text-zinc-900 antialiased">
    <div class="flex min-h-screen">
        <header class="w-60 shrink-0 border-r border-zinc-800 bg-zinc-950 text-zinc-50">
            <nav class="flex flex-col gap-6 px-4 py-6">
                <a class="group flex items-center gap-2 text-lg font-semibold tracking-tight focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-blue-500" href="{{ route('admin.posts.index') }}">
                    <span class="size-1.5 rounded-full bg-cyan-400" aria-hidden="true"></span>
                    <span>Resto<span class="text-blue-500 transition-colors group-hover:text-blue-400">Code</span> · Admin</span>
                </a>
                <ul class="flex flex-col gap-3 text-sm font-medium">
                    <li>
                        <a @class([
                            'transition-colors focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-blue-500',
                            'text-blue-500' => request()->routeIs('admin.posts.*'),
                            'text-zinc-400 hover:text-blue-400' => ! request()->routeIs('admin.posts.*'),
                        ]) href="{{ route('admin.posts.index') }}" @if (request()->routeIs('admin.posts.*')) aria-current="page" @endif>Entradas</a>
                    </li>
                    <li>
                        <a class="text-zinc-400 transition-colors hover:text-blue-400 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-blue-500" href="{{ route('home') }}">Ver sitio</a>
                    </li>
                </ul>
            </nav>
        </header>

        <div class="flex flex-1 flex-col">
            @if (session()->has('feedback.message'))
                <div class="px-8 pt-6">
                    <div class="rounded border border-green-200 bg-green-50 px-4 py-3 text-green-800">
                        {{ session('feedback.message') }}
                    </div>
                </div>
            @endif

            <main class="flex-1 px-8 py-6">
                {{ $slot }}
            </main>

            <footer class="border-t border-zinc-200 px-8 py-4">
                <p class="text-sm text-zinc-500">RestoCode · panel de administración</p>
            </footer>
        </div>
    </div>
</body>
</html>
