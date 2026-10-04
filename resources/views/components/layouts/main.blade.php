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
            <div class="flex items-center gap-10">
                <ul class="flex gap-6 text-sm">
                    <li><a class="hover:text-blue-300" href="{{ route('home') }}">Inicio</a></li>
                    <li><a class="hover:text-blue-300" href="{{ route('services.index') }}">Servicios</a></li>
                    <li><a class="hover:text-blue-300" href="{{ route('blog.index') }}">Blog</a></li>
                </ul>
                <a class="flex size-9 items-center justify-center rounded-full hover:bg-blue-300 hover:text-zinc-900" href="{{ route('auth.login.form') }}" aria-label="Iniciar sesión">
                    <i data-lucide="user" class="size-5"></i>
                </a>
            </div>
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

    @unless (request()->routeIs('auth.login.*'))
        <footer class="bg-zinc-900 text-white">
            <section class="border-b border-zinc-800">
                <div class="mx-auto flex max-w-6xl flex-col gap-6 px-4 py-12 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h2 class="text-2xl font-semibold md:text-3xl">¿Listo para digitalizar tu local?</h2>
                        <p class="mt-2 max-w-md text-zinc-300">Elegí el servicio que mejor se adapta a tu restaurante, bar o cafetería.</p>
                    </div>
                    <a class="inline-block self-start rounded bg-blue-600 px-5 py-3 text-sm font-medium hover:bg-blue-500 md:self-auto" href="{{ route('services.index') }}">Ver servicios</a>
                </div>
            </section>

            <div class="mx-auto grid max-w-6xl gap-8 px-4 py-12 md:grid-cols-3">
                <div>
                    <a class="text-lg font-semibold" href="{{ route('home') }}">RestoCode</a>
                    <p class="mt-2 max-w-xs text-sm text-zinc-300">Menús QR, sitios web y reservas para restaurantes, bares y cafeterías.</p>
                </div>

                <nav aria-label="Pie de página">
                    <h2 class="text-sm font-semibold text-zinc-400">Navegación</h2>
                    <ul class="mt-4 flex flex-col gap-2 text-sm">
                        <li><a class="hover:text-blue-300" href="{{ route('home') }}">Inicio</a></li>
                        <li><a class="hover:text-blue-300" href="{{ route('services.index') }}">Servicios</a></li>
                        <li><a class="hover:text-blue-300" href="{{ route('blog.index') }}">Blog</a></li>
                    </ul>
                </nav>

                <address class="not-italic">
                    <h2 class="text-sm font-semibold text-zinc-400">Contacto</h2>
                    <ul class="mt-4 flex flex-col gap-2 text-sm">
                        <li>
                            <a class="flex items-center gap-2 hover:text-blue-300" href="mailto:hola@restocode.com">
                                <i data-lucide="mail" class="size-4 text-blue-600" aria-hidden="true"></i>
                                hola@restocode.com
                            </a>
                        </li>
                        <li>
                            <a class="flex items-center gap-2 hover:text-blue-300" href="tel:+541145678900">
                                <i data-lucide="phone" class="size-4 text-blue-600" aria-hidden="true"></i>
                                +54 11 4567-8900
                            </a>
                        </li>
                        <li class="flex items-center gap-2">
                            <i data-lucide="map-pin" class="size-4 text-blue-600" aria-hidden="true"></i>
                            Buenos Aires, Argentina
                        </li>
                    </ul>
                </address>
            </div>

            <div class="border-t border-zinc-800">
                <p class="mx-auto max-w-6xl px-4 py-6 text-sm text-zinc-400">© {{ date('Y') }} RestoCode · soluciones digitales para gastronomía</p>
            </div>
        </footer>
    @endunless
</body>
</html>
