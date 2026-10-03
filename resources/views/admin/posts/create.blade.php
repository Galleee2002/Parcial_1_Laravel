<x-layouts.admin>
    <x-slot:title>Publicar una entrada</x-slot:title>

    <section class="max-w-2xl">
        <h1 class="text-3xl font-semibold">Publicar una nueva entrada</h1>

        @if ($errors->any())
            <div class="mt-6 rounded border border-red-200 bg-red-50 px-4 py-3 text-red-800">
                El formulario tiene errores. Revisá los campos marcados.
            </div>
        @endif

        <form class="mt-6 flex flex-col gap-5" action="{{ route('admin.posts.store') }}" method="post">
            @csrf

            <div>
                <label class="block text-sm font-medium" for="title">Título</label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title') }}"
                    @class([
                        'mt-1 w-full rounded border bg-white px-3 py-2',
                        'border-zinc-300' => ! $errors->has('title'),
                        'border-red-500 text-red-700' => $errors->has('title'),
                    ])
                    @error('title') aria-invalid="true" aria-errormessage="error-title" @enderror
                >
                @error('title')
                    <p class="mt-1 text-sm text-red-600" id="error-title">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium" for="summary">Resumen</label>
                <input
                    type="text"
                    id="summary"
                    name="summary"
                    value="{{ old('summary') }}"
                    @class([
                        'mt-1 w-full rounded border bg-white px-3 py-2',
                        'border-zinc-300' => ! $errors->has('summary'),
                        'border-red-500 text-red-700' => $errors->has('summary'),
                    ])
                    @error('summary') aria-invalid="true" aria-errormessage="error-summary" @enderror
                >
                @error('summary')
                    <p class="mt-1 text-sm text-red-600" id="error-summary">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium" for="content">Contenido</label>
                <textarea
                    id="content"
                    name="content"
                    rows="8"
                    @class([
                        'mt-1 w-full rounded border bg-white px-3 py-2',
                        'border-zinc-300' => ! $errors->has('content'),
                        'border-red-500 text-red-700' => $errors->has('content'),
                    ])
                    @error('content') aria-invalid="true" aria-errormessage="error-content" @enderror
                >{{ old('content') }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-600" id="error-content">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium" for="published_at">Fecha de publicación</label>
                <input
                    type="date"
                    id="published_at"
                    name="published_at"
                    value="{{ old('published_at') }}"
                    @class([
                        'mt-1 rounded border bg-white px-3 py-2',
                        'border-zinc-300' => ! $errors->has('published_at'),
                        'border-red-500 text-red-700' => $errors->has('published_at'),
                    ])
                    @error('published_at') aria-invalid="true" aria-errormessage="error-published_at" @enderror
                >
                @error('published_at')
                    <p class="mt-1 text-sm text-red-600" id="error-published_at">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-4">
                <button class="rounded bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-500" type="submit">Publicar</button>
                <a class="text-sm underline" href="{{ route('admin.posts.index') }}">Cancelar</a>
            </div>
        </form>
    </section>
</x-layouts.admin>
