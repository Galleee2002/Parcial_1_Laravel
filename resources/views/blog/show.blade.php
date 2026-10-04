<x-layouts.main>
    <x-slot:title>{{ $post->title }}</x-slot:title>

    <div class="grid gap-10 md:grid-cols-3">
        <article class="md:col-span-2">
            <a class="flex items-center gap-1 text-sm hover:text-blue-600" href="{{ route('blog.index') }}">
                <i data-lucide="chevron-left" class="size-4"></i>
                Volver al blog
            </a>

            <p class="mt-6 flex items-center gap-2 text-sm uppercase tracking-widest text-blue-600">
                <i data-lucide="newspaper" class="size-4" aria-hidden="true"></i>
                Blog
            </p>
            <h1 class="mt-3 text-4xl font-semibold leading-tight tracking-tight md:text-5xl">{{ $post->title }}</h1>
            <p class="mt-6 text-xl text-zinc-600">{{ $post->summary }}</p>

            <section class="mt-10 border-t border-zinc-200 pt-10">
                <h2 class="sr-only">Contenido</h2>
                <p class="max-w-prose whitespace-pre-line border-l-4 border-blue-600 pl-4 text-lg leading-8 text-zinc-800 first-letter:float-left first-letter:mr-3 first-letter:text-6xl first-letter:font-semibold first-letter:leading-none first-letter:text-blue-600">{{ $post->content }}</p>
            </section>
        </article>

        <aside class="self-start rounded-md border-2 border-dashed border-zinc-300 p-6">
            <dl>
                <dt class="text-xs uppercase tracking-widest text-zinc-500">Fecha de publicación</dt>
                <dd class="mt-1 text-lg font-medium">
                    <time datetime="{{ $post->published_at }}">{{ $post->published_at }}</time>
                </dd>
            </dl>

            <a class="mt-6 flex items-center justify-center gap-1 rounded bg-blue-600 px-5 py-3 text-sm font-medium text-white hover:bg-blue-500" href="{{ route('blog.index') }}">
                Ver más entradas <i data-lucide="arrow-up-right" class="size-4"></i>
            </a>
        </aside>
    </div>
</x-layouts.main>
