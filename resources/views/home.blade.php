<x-layouts.main>
    <x-slot:title>Inicio</x-slot:title>

    <section class="hero">
        <div class="container">
            <h1>Digitalizá tu local gastronómico</h1>
            <p>
                Menús QR, sitios web y reservas para restaurantes, bares y cafeterías.
            </p>
            <a class="btn btn-light" href="{{ url('/servicios') }}">Ver servicios</a>
            <a class="btn btn-outline-light" href="{{ url('/servicios') }}">Ver demo</a>
        </div>
    </section>
</x-layouts.main>