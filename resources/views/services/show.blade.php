<x-layouts.main>
    <x-slot:title>{{ $service->title }}</x-slot:title>

    <article class="max-w-3xl">
        <a class="text-sm underline" href="{{ route('services.index') }}">Volver a servicios</a>

        <h1 class="mt-4 text-3xl font-semibold">{{ $service->title }}</h1>
        <p class="mt-2 text-zinc-600">{{ $service->short_description }}</p>

        <dl class="mt-6 flex gap-8">
            <div>
                <dt class="text-sm text-zinc-500">Precio</dt>
                <dd class="text-lg font-medium">${{ $service->price }}</dd>
            </div>
            <div>
                <dt class="text-sm text-zinc-500">Entrega</dt>
                <dd class="text-lg font-medium">{{ $service->delivery_days }} días</dd>
            </div>
        </dl>

        <section class="mt-8">
            <h2 class="text-xl font-semibold">Descripción</h2>
            <p class="mt-2 leading-relaxed">{{ $service->full_description }}</p>
        </section>
    </article>
</x-layouts.main>
