<x-layouts.admin>
    <x-slot:title>Usuarios</x-slot:title>

    <section>
        <h1 class="text-3xl font-semibold">Usuarios</h1>

        <table class="mt-8 w-full border-collapse overflow-hidden rounded border border-zinc-200 bg-white text-left text-sm">
            <thead class="bg-zinc-100 text-zinc-700">
                <tr>
                    <th scope="col" class="px-4 py-3 font-semibold">Nombre</th>
                    <th scope="col" class="px-4 py-3 font-semibold">Email</th>
                    <th scope="col" class="px-4 py-3 font-semibold">Rol</th>
                    <th scope="col" class="px-4 py-3 font-semibold">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="border-t border-zinc-200">
                        <td class="px-4 py-3">{{ $user->name }}</td>
                        <td class="px-4 py-3">{{ $user->email }}</td>
                        <td class="px-4 py-3">{{ $user->role }}</td>
                        <td class="px-4 py-3">
                            <a class="inline-flex size-8 items-center justify-center rounded-full text-green-600 transition-colors hover:bg-green-100 hover:text-green-800" href="{{ route('admin.users.show', ['id' => $user->id]) }}" aria-label="Ver {{ $user->name }}">
                                <i data-lucide="eye" class="size-4" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
</x-layouts.admin>
