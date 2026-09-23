<x-layouts.main>
    <x-slot:title>Inicio</x-slot:title>

    <section class="bg-zinc-900 py-20 text-white">
        <div class="mx-auto max-w-6xl px-4">
            <h1 class="text-4xl font-semibold">Digitalizá tu local gastronómico</h1>
            <p class="mt-4 max-w-2xl text-lg text-zinc-200">
                Menús QR, sitios web y reservas para restaurantes, bares y cafeterías.
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a class="rounded bg-white px-4 py-2 font-medium text-zinc-900" href="{{ url('/servicios') }}">Ver servicios</a>
                <a class="rounded border border-white px-4 py-2 font-medium text-white" href="{{ url('/servicios') }}">Ver demo</a>
            </div>
        </div>
    </section>
</x-layouts.main>
