<x-layouts.main>
    <x-slot:title>Inicio</x-slot:title>

    <section class="rounded bg-zinc-900 px-8 py-16 text-white">
        <h1 class="text-4xl font-semibold">Digitalizá tu local gastronómico</h1>
        <p class="mt-4 max-w-xl text-zinc-300">Menús QR, sitios web y reservas para restaurantes, bares y cafeterías.</p>
        <a class="mt-8 inline-block rounded bg-blue-600 px-5 py-3 text-sm font-medium hover:bg-blue-500" href="{{ route('services.index') }}">Ver servicios</a>
    </section>

    <section class="mt-12">
        <h2 class="text-2xl font-semibold">Nuestros servicios</h2>

        <div class="mt-6 grid gap-6 md:grid-cols-3">
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

    <section class="mt-12">
        <div class="flex items-end justify-between">
            <h2 class="text-2xl font-semibold">Novedades</h2>
            <a class="text-sm underline" href="{{ route('blog.index') }}">Ver todas las entradas</a>
        </div>

        <div class="mt-6 grid gap-6 md:grid-cols-3">
            @foreach ($posts as $post)
                <article class="rounded border border-zinc-200 p-6">
                    <h3 class="text-xl font-semibold">{{ $post->title }}</h3>
                    <p class="mt-1 text-sm text-zinc-500">
                        Publicado el <time datetime="{{ $post->published_at }}">{{ $post->published_at }}</time>
                    </p>
                    <p class="mt-2 text-zinc-600">{{ $post->summary }}</p>
                    <a class="mt-4 inline-block underline" href="{{ route('blog.show', ['id' => $post->id]) }}">Leer entrada</a>
                </article>
            @endforeach
        </div>
    </section>
</x-layouts.main>
