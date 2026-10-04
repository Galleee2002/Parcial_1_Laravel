<x-layouts.main>
    <x-slot:title>{{ $service->title }}</x-slot:title>

    <div class="grid gap-10 md:grid-cols-3">
        <article class="md:col-span-2">
            <a class="flex items-center gap-1 text-sm hover:text-blue-600" href="{{ route('services.index') }}">
                <i data-lucide="chevron-left" class="size-4"></i>
                Volver a la carta
            </a>

            <p class="mt-6 text-sm uppercase tracking-widest text-blue-600">Servicio</p>
            <h1 class="mt-2 text-3xl font-semibold">{{ $service->title }}</h1>
            <p class="mt-2 text-zinc-600">{{ $service->short_description }}</p>

            <section class="mt-8">
                <h2 class="text-xl font-semibold">Descripción</h2>
                <p class="mt-2 leading-relaxed">{{ $service->full_description }}</p>
            </section>
        </article>

        <aside class="self-start rounded-md border-2 border-dashed border-zinc-300 p-6">
            <dl>
                <div>
                    <dt class="text-sm text-zinc-500">Precio</dt>
                    <dd class="text-lg font-medium">${{ $service->price }}</dd>
                </div>
                <div class="mt-4 border-t border-dashed border-zinc-300 pt-4">
                    <dt class="text-sm text-zinc-500">Entrega</dt>
                    <dd class="text-lg font-medium">{{ $service->delivery_days }} días</dd>
                </div>
            </dl>

            <a class="mt-6 block rounded bg-blue-600 px-5 py-3 text-center text-sm font-medium text-white hover:bg-blue-500" href="{{ route('services.index') }}">Ver más servicios</a>
        </aside>
    </div>
</x-layouts.main>
