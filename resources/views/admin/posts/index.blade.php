<x-layouts.admin>
    <x-slot:title>Entradas</x-slot:title>

    <section>
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-semibold">Entradas del blog</h1>
            <a class="rounded bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-500" href="{{ route('admin.posts.create') }}">Publicar una nueva entrada</a>
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
                            <div class="flex items-center gap-3">
                                <a class="underline" href="{{ route('blog.show', ['id' => $post->id]) }}">Ver</a>
                                <a class="rounded bg-zinc-700 px-3 py-1 text-white hover:bg-zinc-600" href="{{ url('/admin/posts/' . $post->id . '/editar') }}">Editar</a>
                                <a class="rounded bg-red-600 px-3 py-1 text-white hover:bg-red-500" href="{{ url('/admin/posts/' . $post->id . '/eliminar') }}">Eliminar</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
</x-layouts.admin>
