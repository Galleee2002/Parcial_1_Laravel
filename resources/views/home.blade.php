<x-layouts.main>
    <x-slot:title>Inicio</x-slot:title>

    <section class="bg-zinc-900 py-20 font-sans text-white">
        <div class="mx-auto grid max-w-6xl items-center gap-12 px-4 md:grid-cols-2 md:gap-16">
            <div>
                <p class="text-sm uppercase tracking-widest text-zinc-300">Digital para gastronomía</p>
                <h1 class="mt-4 text-4xl font-semibold leading-tight tracking-tight md:text-6xl">Digitalizá tu local gastronómico</h1>
                <p class="mt-6 max-w-2xl text-lg leading-relaxed text-zinc-200">
                    Menús QR, sitios web y reservas para restaurantes, bares y cafeterías.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a class="rounded bg-white px-4 py-2 font-medium text-zinc-900 hover:bg-zinc-200" href="{{ route('services.index') }}">Ver servicios</a>
                    <a class="rounded border border-white px-4 py-2 font-medium text-white hover:border-zinc-300 hover:text-zinc-300" href="{{ route('services.index') }}">Ver demo</a>
                </div>
            </div>
            <div class="w-full max-w-sm rounded border border-zinc-200 bg-white p-6 text-zinc-900 md:justify-self-end" aria-hidden="true">
                <p class="text-sm font-medium text-zinc-500">RestoCode</p>
                <p class="mt-6 text-xl font-semibold">Carta de temporada</p>
                <div class="mt-6 border-t border-zinc-200">
                    <div class="border-b border-zinc-200 py-4">
                        <p class="text-sm text-zinc-500">Entradas</p>
                        <p class="mt-1 font-medium">Plato de estación</p>
                    </div>
                    <div class="flex items-baseline justify-between gap-4 py-4">
                        <div>
                            <p class="text-sm text-zinc-500">Plato principal</p>
                            <p class="mt-1 font-medium">Risotto</p>
                        </div>
                        <p class="text-sm text-zinc-500">$12.500</p>
                    </div>
                </div>
                <p class="border-t border-zinc-200 pt-4 text-sm font-medium">Menú digital</p>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-4 py-12">
        <h2 class="text-3xl font-semibold">Nuestros servicios</h2>

        <div class="mt-8 grid gap-6 md:grid-cols-3">
            @foreach ($services as $service)
                @if ($service->is_active)
                    <article class="rounded border border-zinc-200 p-6">
                        <h3 class="text-xl font-semibold">{{ $service->title }}</h3>
                        <p class="mt-2 text-zinc-600">{{ $service->short_description }}</p>
                        <p class="mt-4 text-lg font-medium">${{ $service->price }}</p>
                        <p class="text-sm text-zinc-500">Entrega en {{ $service->delivery_days }} días</p>
                        <a class="mt-4 inline-block underline" href="{{ route('services.show', ['id' => $service->id]) }}">Ver detalle</a>
                    </article>
                @endif
            @endforeach
        </div>
    </section>
</x-layouts.main>
