<x-layouts.main>
    <x-slot:title>Inicio</x-slot:title>

    <x-slot:hero>
        <section class="w-full bg-zinc-900 text-white">
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

        <div class="mt-6 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($posts as $post)
                <article class="flex h-full flex-col overflow-hidden rounded-xl bg-zinc-900 text-white">
                    <a class="group flex h-full flex-col" href="{{ route('blog.show', ['id' => $post->id]) }}">
                        <img
                            class="aspect-[4/3] w-full object-cover"
                            src="{{ asset('img/' . match ($post->id) {
                                1 => 'card-2.webp',
                                2 => 'card-3.webp',
                                3 => 'card-1.webp',
                                default => 'card-' . $loop->iteration . '.webp',
                            }) }}"
                            alt=""
                        >
                        <div class="flex flex-1 flex-col gap-2 bg-zinc-900 px-5 py-5">
                            <p class="text-sm text-zinc-300">
                                Publicado el <time datetime="{{ $post->published_at }}">{{ $post->published_at }}</time>
                            </p>
                            <h3 class="text-lg font-semibold leading-snug group-hover:underline">{{ $post->title }}</h3>
                            <p class="text-sm leading-relaxed text-zinc-300">{{ $post->summary }}</p>
                        </div>
                    </a>
                </article>
            @endforeach
        </div>
    </section>
</x-layouts.main>
