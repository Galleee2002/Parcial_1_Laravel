<x-layouts.main>
    <x-slot:title>Inicio</x-slot:title>

    <section class="bg-zinc-900 py-20 text-white">
        <div class="mx-auto max-w-6xl px-4">
            <h1 class="text-4xl font-semibold">Digitalizá tu local gastronómico</h1>
            <p class="mt-4 max-w-2xl text-lg text-zinc-200">
                Menús QR, sitios web y reservas para restaurantes, bares y cafeterías.
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a class="rounded bg-white px-4 py-2 font-medium text-zinc-900" href="{{ route('services.index') }}">Ver servicios</a>
                <a class="rounded border border-white px-4 py-2 font-medium text-white" href="{{ route('services.index') }}">Ver demo</a>
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
