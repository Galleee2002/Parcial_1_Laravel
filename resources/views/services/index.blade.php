<x-layouts.main>
    <x-slot:title>Servicios</x-slot:title>

    <header class="flex flex-col items-center text-center">
        <i data-lucide="utensils-crossed" class="size-8 text-blue-600" aria-hidden="true"></i>
        <p class="mt-4 text-sm uppercase tracking-widest text-blue-600">La carta</p>
        <h1 class="mt-2 text-3xl font-semibold">Nuestros servicios</h1>
        <p class="mt-2 max-w-md text-zinc-600">Elegí lo que tu local necesita para dar el salto digital.</p>
    </header>

    <div class="mx-auto mt-12 max-w-3xl border-y-2 border-zinc-900">
        @foreach ($services as $service)
            <article class="group border-b border-zinc-200 py-6 last:border-b-0">
                <div class="flex items-baseline gap-4">
                    <h2 class="text-xl font-semibold group-hover:text-blue-600">{{ $service->title }}</h2>
                    <span class="flex-1 border-b-2 border-dotted border-zinc-300"></span>
                    <p class="text-xl font-semibold">${{ $service->price }}</p>
                </div>
                <p class="mt-2 max-w-xl text-zinc-600">{{ $service->short_description }}</p>
                <div class="mt-3 flex items-center justify-between text-sm">
                    <p class="text-zinc-500">Entrega en {{ $service->delivery_days }} días</p>
                    <a class="flex items-center gap-1 font-medium text-blue-600 hover:underline" href="{{ route('services.show', ['id' => $service->id]) }}">
                        Ver detalle <i data-lucide="arrow-up-right" class="size-4"></i>
                    </a>
                </div>
            </article>
        @endforeach
    </div>
</x-layouts.main>
