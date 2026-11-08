<x-layouts.admin>
    <x-slot:title>{{ $user->name }}</x-slot:title>

    <article>
        <a class="flex items-center gap-1 text-sm hover:text-blue-600" href="{{ route('admin.users.index') }}">
            <i data-lucide="chevron-left" class="size-4" aria-hidden="true"></i>
            Volver al listado
        </a>

        <h1 class="mt-6 text-3xl font-semibold">{{ $user->name }}</h1>

        <dl class="mt-6">
            <div>
                <dt class="text-sm text-zinc-500">Nombre</dt>
                <dd class="text-lg font-medium">{{ $user->name }}</dd>
            </div>
            <div class="mt-4 border-t border-zinc-200 pt-4">
                <dt class="text-sm text-zinc-500">Email</dt>
                <dd class="text-lg font-medium">{{ $user->email }}</dd>
            </div>
            <div class="mt-4 border-t border-zinc-200 pt-4">
                <dt class="text-sm text-zinc-500">Rol</dt>
                <dd class="text-lg font-medium">{{ $user->role }}</dd>
            </div>
        </dl>

        <section class="mt-10">
            <h2 class="text-xl font-semibold">Servicios contratados</h2>

            @forelse ($user->services as $service)
                <article class="mt-4 border-t border-zinc-200 pt-4">
                    <h3 class="font-medium">{{ $service->title }}</h3>
                    <p class="mt-1 text-lg font-semibold">${{ $service->price }}</p>
                </article>
            @empty
                <p class="mt-4 text-zinc-600">Sin servicios contratados.</p>
            @endforelse
        </section>
    </article>
</x-layouts.admin>
