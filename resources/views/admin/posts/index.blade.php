<x-layouts.admin>
    <x-slot:title>Entradas</x-slot:title>

    <section>
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-semibold">Entradas del blog</h1>
            <a class="rounded bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-500" href="{{ route('admin.posts.create') }}">Publicar una nueva entrada</a>
        </div>

        <table class="mt-8 w-full border-collapse overflow-hidden rounded border border-zinc-200 bg-white text-left text-sm">
            <thead class="bg-zinc-100 text-zinc-700">
                <tr>
                    <th scope="col" class="px-4 py-3 font-semibold">Título</th>
                    <th scope="col" class="px-4 py-3 font-semibold">Fecha de publicación</th>
                    <th scope="col" class="px-4 py-3 font-semibold">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                    <tr class="border-t border-zinc-200">
                        <td class="px-4 py-3">{{ $post->title }}</td>
                        <td class="px-4 py-3">
                            <time datetime="{{ $post->published_at }}">{{ $post->published_at }}</time>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <a class="inline-flex size-8 items-center justify-center rounded-full text-green-600 transition-colors hover:bg-green-100 hover:text-green-800" href="{{ route('blog.show', ['id' => $post->id]) }}" aria-label="Ver {{ $post->title }}">
                                    <i data-lucide="eye" class="size-4" aria-hidden="true"></i>
                                </a>
                                <a class="inline-flex size-8 items-center justify-center rounded-full text-blue-600 transition-colors hover:bg-blue-100 hover:text-blue-800" href="{{ route('admin.posts.edit', ['id' => $post->id]) }}" aria-label="Editar {{ $post->title }}">
                                    <i data-lucide="pencil" class="size-4" aria-hidden="true"></i>
                                </a>
                                <a class="inline-flex size-8 items-center justify-center rounded-full text-red-600 transition-colors hover:bg-red-100 hover:text-red-800" href="{{ route('admin.posts.delete', ['id' => $post->id]) }}" aria-label="Eliminar {{ $post->title }}">
                                    <i data-lucide="trash-2" class="size-4" aria-hidden="true"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
</x-layouts.admin>
