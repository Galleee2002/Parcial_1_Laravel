<x-layouts.main>
    <x-slot:title>Ingresar al panel</x-slot:title>

    <section class="mx-auto max-w-md">
        <h1 class="text-3xl font-semibold">Ingresar al panel</h1>

        @if ($errors->any())
            <div class="mt-6 rounded border border-red-200 bg-red-50 px-4 py-3 text-red-800">
                El formulario tiene errores. Revisá los campos marcados.
            </div>
        @endif

        <form class="mt-6 flex flex-col gap-5" action="{{ route('auth.login.process') }}" method="post" novalidate>
            @csrf

            <div>
                <label class="block text-sm font-medium" for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    @class([
                        'mt-1 w-full rounded border bg-white px-3 py-2',
                        'border-zinc-300' => ! $errors->has('email'),
                        'border-red-500 text-red-700' => $errors->has('email'),
                    ])
                    @error('email') aria-invalid="true" aria-errormessage="error-email" @enderror
                >
                @error('email')
                    <p class="mt-1 text-sm text-red-600" id="error-email">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium" for="password">Contraseña</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    @class([
                        'mt-1 w-full rounded border bg-white px-3 py-2',
                        'border-zinc-300' => ! $errors->has('password'),
                        'border-red-500 text-red-700' => $errors->has('password'),
                    ])
                    @error('password') aria-invalid="true" aria-errormessage="error-password" @enderror
                >
                @error('password')
                    <p class="mt-1 text-sm text-red-600" id="error-password">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button class="rounded bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-500" type="submit">Ingresar</button>
            </div>
        </form>
    </section>
</x-layouts.main>
