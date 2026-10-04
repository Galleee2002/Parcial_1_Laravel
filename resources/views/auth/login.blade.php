<x-layouts.main>
    <x-slot:title>Ingresar al panel</x-slot:title>

    <section class="mx-auto max-w-md py-8">
        <div class="rounded-xl border border-zinc-200 bg-white p-8 shadow-sm">
            <div class="mx-auto flex size-14 items-center justify-center rounded-xl bg-zinc-900 text-white">
                <i data-lucide="utensils-crossed" class="size-7" aria-hidden="true"></i>
            </div>

            <h1 class="mt-6 text-center text-2xl font-semibold">¡Bienvenido/a de nuevo!</h1>
            <p class="mt-2 text-center text-sm text-zinc-600">Por favor, ingresá tus credenciales.</p>

            @if ($errors->any())
                <div class="mt-6 rounded border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
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
                        placeholder="tu@email.com"
                        @class([
                            'mt-1 w-full rounded-lg border bg-zinc-100 px-4 py-3 placeholder:text-zinc-400',
                            'border-transparent' => ! $errors->has('email'),
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
                        placeholder="Ingresá tu contraseña"
                        @class([
                            'mt-1 w-full rounded-lg border bg-zinc-100 px-4 py-3 placeholder:text-zinc-400',
                            'border-transparent' => ! $errors->has('password'),
                            'border-red-500 text-red-700' => $errors->has('password'),
                        ])
                        @error('password') aria-invalid="true" aria-errormessage="error-password" @enderror
                    >
                    @error('password')
                        <p class="mt-1 text-sm text-red-600" id="error-password">{{ $message }}</p>
                    @enderror
                </div>

                <button class="w-full rounded-lg bg-blue-600 px-4 py-3 text-sm font-medium text-white hover:bg-blue-500" type="submit">Ingresar</button>
            </form>
        </div>
    </section>
</x-layouts.main>
