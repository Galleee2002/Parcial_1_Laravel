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
        <header class="w-60 shrink-0 bg-zinc-900 text-white">
            <nav class="flex flex-col gap-6 px-4 py-6">
                <a class="text-lg font-semibold" href="{{ route('admin.posts.index') }}">RestoCode · Admin</a>
                <ul class="flex flex-col gap-3 text-sm">
                    <li>
                        <a @class([
                            'hover:text-blue-300',
                            'text-blue-300' => request()->routeIs('admin.posts.*'),
                        ]) href="{{ route('admin.posts.index') }}" @if (request()->routeIs('admin.posts.*')) aria-current="page" @endif>Entradas</a>
                    </li>
                    <li><a class="hover:text-blue-300" href="{{ route('home') }}">Ver sitio</a></li>
                    @auth
                        <li>
                            <form action="{{ route('auth.logout.process') }}" method="post">
                                @csrf
                                <button class="text-left hover:text-blue-300" type="submit">{{ auth()->user()->email }} (Cerrar sesión)</button>
                            </form>
                        </li>
                    @endauth
                </ul>
            </nav>
        </header>

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
