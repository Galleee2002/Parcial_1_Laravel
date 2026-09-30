<x-layouts.main>
    <x-slot:title>Blog</x-slot:title>

    <section class="mx-auto max-w-6xl px-4 py-12">
        <h1 class="text-3xl font-semibold">Blog</h1>
        <p class="mt-2 text-zinc-600">Novedades sobre digitalización gastronómica.</p>

        <div class="mt-8 grid gap-6 md:grid-cols-3">
            @foreach ($posts as $post)
                <article class="rounded border border-zinc-200 p-6">
                    <h2 class="text-xl font-semibold">{{ $post->title }}</h2>
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
