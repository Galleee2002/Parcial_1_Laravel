<x-layouts.main>
    <x-slot:title>Servicios</x-slot:title>

    <h1 class="text-3xl font-semibold">Nuestros servicios</h1>

    <div class="mt-8 grid gap-6 md:grid-cols-3">
        @foreach ($services as $service)
            <article class="rounded border border-zinc-200 p-6">
                <h2 class="text-xl font-semibold">{{ $service->title }}</h2>
                <p class="mt-2 text-zinc-600">{{ $service->short_description }}</p>
                <p class="mt-4 text-lg font-medium">${{ $service->price }}</p>
                <p class="text-sm text-zinc-500">Entrega en {{ $service->delivery_days }} días</p>
                <a class="mt-4 inline-block underline" href="{{ route('services.show', ['id' => $service->id]) }}">Ver detalle</a>
            </article>
        @endforeach
    </div>
</x-layouts.main>
