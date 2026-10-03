<x-layouts.admin>
    <x-slot:title>Eliminar {{ $post->title }}</x-slot:title>

    <section class="max-w-2xl">
        <h1 class="text-3xl font-semibold">Confirmación necesaria</h1>
        <p class="mt-2 text-zinc-600">Estás por eliminar de manera definitiva la siguiente entrada.</p>

        <article class="mt-6 rounded border border-zinc-200 bg-white p-6">
            <h2 class="text-2xl font-semibold">{{ $post->title }}</h2>

            <dl class="mt-4 flex flex-col gap-3">
                <div>
                    <dt class="text-sm text-zinc-500">Resumen</dt>
                    <dd>{{ $post->summary }}</dd>
                </div>
                <div>
                    <dt class="text-sm text-zinc-500">Fecha de publicación</dt>
                    <dd>
                        <time datetime="{{ $post->published_at }}">{{ $post->published_at }}</time>
                    </dd>
                </div>
            </dl>

            <section class="mt-6">
                <h3 class="text-lg font-semibold">Contenido</h3>
                <p class="mt-2 whitespace-pre-line leading-relaxed">{{ $post->content }}</p>
            </section>
        </article>

        <p class="mt-6 font-medium text-red-700">Esta acción es irreversible. ¿Querés continuar?</p>

        <form class="mt-4 flex items-center gap-4" action="{{ route('admin.posts.destroy', ['id' => $post->id]) }}" method="post">
            @csrf
            <button class="rounded bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-500" type="submit">Eliminar</button>
            <a class="text-sm underline" href="{{ route('admin.posts.index') }}">Cancelar</a>
        </form>
    </section>
</x-layouts.admin>
