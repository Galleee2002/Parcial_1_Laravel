<x-layouts.main>
    <x-slot:title>{{ $post->title }}</x-slot:title>

    <article class="mx-auto max-w-3xl px-4 py-12">
        <a class="text-sm underline" href="{{ route('blog.index') }}">Volver al blog</a>

        <h1 class="mt-4 text-3xl font-semibold">{{ $post->title }}</h1>
        <p class="mt-2 text-zinc-600">{{ $post->summary }}</p>

        <dl class="mt-6">
            <dt class="text-sm text-zinc-500">Fecha de publicación</dt>
            <dd class="text-lg font-medium">
                <time datetime="{{ $post->published_at }}">{{ $post->published_at }}</time>
            </dd>
        </dl>

        <section class="mt-8">
            <h2 class="sr-only">Contenido</h2>
            <p class="whitespace-pre-line leading-relaxed">{{ $post->content }}</p>
        </section>
    </article>
</x-layouts.main>
