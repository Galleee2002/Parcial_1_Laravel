<x-layouts.main>
    <x-slot:title>Inicio</x-slot:title>

    <x-slot:hero>
        <section class="relative isolate w-full overflow-hidden bg-zinc-900 text-white">
            <img
                src="{{ asset('img/hero.webp') }}"
                alt="Comensal consultando el menú digital en un restaurante, con un código QR en la mesa"
                class="absolute inset-0 -z-10 h-full w-full object-cover object-right"
                width="2752"
                height="1536"
                fetchpriority="high"
            >
            <div class="absolute inset-0 -z-10 bg-linear-to-r from-zinc-950/85 via-zinc-950/50 to-transparent"></div>

            <div class="mx-auto max-w-6xl px-4 py-24 md:py-40">
                <h1 class="max-w-xl text-4xl font-semibold md:text-5xl">Digitalizá tu local gastronómico</h1>
                <p class="mt-4 max-w-md text-zinc-200">Menús QR, sitios web y reservas para restaurantes, bares y cafeterías.</p>
                <a class="mt-8 inline-block rounded bg-blue-600 px-5 py-3 text-sm font-medium hover:bg-blue-500" href="{{ route('services.index') }}">Ver servicios</a>
            </div>
        </section>
    </x-slot:hero>

    <section>
        <h2 class="text-2xl font-semibold">Nuestros servicios</h2>

        <div class="mt-6 border-t border-zinc-200">
            @foreach ($services as $service)
                @if ($service->is_active)
                    <article class="group flex flex-col gap-4 border-b border-zinc-200 p-6 hover:rounded-xl hover:bg-zinc-900 hover:text-white md:flex-row md:items-center md:justify-between">
                        <h3 class="text-2xl font-semibold md:w-1/3">
                            <span class="mr-3 text-lg font-normal text-blue-600">0{{ $loop->iteration }}</span>
                            {{ $service->title }}
                        </h3>
                        <p class="text-sm text-zinc-600 group-hover:text-zinc-300 md:w-1/3">{{ $service->short_description }}</p>
                        <a class="flex size-12 items-center justify-center rounded-full border border-zinc-900 group-hover:border-white group-hover:bg-white group-hover:text-zinc-900" href="{{ route('services.show', ['id' => $service->id]) }}" aria-label="Ver detalle de {{ $service->title }}">
                            <i data-lucide="arrow-up-right" class="size-5"></i>
                        </a>
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
                <article class="aspect-square overflow-hidden rounded-xl bg-zinc-900 bg-cover bg-center text-white" style="background-image: url('{{ asset('img/card-' . $loop->iteration . '.webp') }}')">
                    <a class="group relative flex h-full flex-col justify-end p-6" href="{{ route('blog.show', ['id' => $post->id]) }}">
                        <div class="absolute inset-0 bg-linear-to-t from-zinc-950/90 via-zinc-950/40 to-transparent"></div>

                        <div class="relative">
                            <p class="text-sm text-zinc-300">
                                Publicado el <time datetime="{{ $post->published_at }}">{{ $post->published_at }}</time>
                            </p>
                            <h3 class="mt-1 text-xl font-semibold group-hover:underline">{{ $post->title }}</h3>
                            <p class="mt-2 text-sm text-zinc-300">{{ $post->summary }}</p>
                        </div>
                    </a>
                </article>
            @endforeach
        </div>
    </section>
</x-layouts.main>
