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
        <aside data-sidebar class="sticky top-0 flex h-screen w-60 shrink-0 flex-col bg-zinc-900 px-4 py-6 text-white transition-all duration-300">
            <button data-sidebar-toggle class="absolute -right-4 top-8 z-10 flex size-8 items-center justify-center rounded-full border border-zinc-200 bg-white text-zinc-700 shadow transition-transform duration-300 hover:bg-zinc-100 focus:outline-2 focus:outline-blue-600" type="button" aria-label="Compactar menú" aria-expanded="true">
                <i data-lucide="chevron-left" class="size-4" aria-hidden="true"></i>
            </button>

            <a class="flex items-center gap-3 px-3 text-base font-semibold" href="{{ route('admin.posts.index') }}">
                <i data-lucide="utensils-crossed" class="size-5 shrink-0" aria-hidden="true"></i>
                <span class="whitespace-nowrap" data-sidebar-label>RestoCode · Admin</span>
            </a>

            <nav class="mt-8 flex-1">
                <ul class="flex flex-col gap-1 text-sm font-semibold">
                    <li>
                        <a @class([
                            'flex items-center gap-3 rounded-lg px-3 py-2.5 hover:bg-zinc-800 hover:text-white',
                            'bg-zinc-800 text-white' => request()->routeIs('admin.posts.*'),
                            'text-zinc-300' => ! request()->routeIs('admin.posts.*'),
                        ]) href="{{ route('admin.posts.index') }}" @if (request()->routeIs('admin.posts.*')) aria-current="page" @endif>
                            <i data-lucide="newspaper" @class([
                                'size-5 shrink-0',
                                'text-blue-300' => request()->routeIs('admin.posts.*'),
                                'text-zinc-400' => ! request()->routeIs('admin.posts.*'),
                            ]) aria-hidden="true"></i>
                            <span data-sidebar-label>Entradas</span>
                        </a>
                    </li>
                    <li>
                        <a class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-zinc-300 hover:bg-zinc-800 hover:text-white" href="{{ route('home') }}">
                            <i data-lucide="globe" class="size-5 shrink-0 text-zinc-400" aria-hidden="true"></i>
                            <span data-sidebar-label>Ver sitio</span>
                        </a>
                    </li>
                </ul>
            </nav>

            @auth
                <div class="border-t border-zinc-800 pt-4">
                    <form action="{{ route('auth.logout.process') }}" method="post">
                        @csrf
                        <button class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold text-zinc-300 hover:bg-zinc-800 hover:text-white" type="submit">
                            <i data-lucide="log-out" class="size-5 shrink-0 text-zinc-400" aria-hidden="true"></i>
                            <span data-sidebar-label>Cerrar sesión</span>
                        </button>
                    </form>
                </div>
            @endauth
        </aside>

        <div class="flex flex-1 flex-col">
            <main class="flex-1 px-8 py-6">
                @if (session()->has('feedback.message'))
                    <div @class([
                        'mb-6 rounded border px-4 py-3',
                        'border-green-200 bg-green-50 text-green-800' => session('feedback.type', 'success') === 'success',
                        'border-red-200 bg-red-50 text-red-800' => session('feedback.type', 'success') === 'danger',
                    ])>{{ session('feedback.message') }}</div>
                @endif

                {{ $slot }}
            </main>

            <footer class="border-t border-zinc-200 px-8 py-4">
                <p class="text-sm text-zinc-500">RestoCode · panel de administración</p>
            </footer>
        </div>
    </div>
</body>
</html>
