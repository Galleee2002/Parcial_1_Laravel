<x-layouts.main>
    <x-slot:title>Blog</x-slot:title>

    <h1 class="text-3xl font-semibold">Blog</h1>
    <p class="mt-2 text-zinc-600">Novedades sobre digitalización gastronómica.</p>

    <div class="mt-8 grid gap-6 md:grid-cols-3">
        @foreach ($posts as $post)
            <article class="rounded-md border border-zinc-200 bg-zinc-900 p-6 text-white">
                <h2 class="text-xl font-semibold">{{ $post->title }}</h2>
                <p class="mt-1 text-sm text-white">
                    Publicado el <time datetime="{{ $post->published_at }}">{{ $post->published_at }}</time>
                </p>
                <p class="mt-2 text-white">{{ $post->summary }}</p>
                <a class="mt-4 inline-block underline" href="{{ route('blog.show', ['id' => $post->id]) }}">Leer entrada</a>
            </article>
        @endforeach
    </div>
</x-layouts.main>
