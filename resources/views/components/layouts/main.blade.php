<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} · RestoCode</title>
    <link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('css/style.css') }}">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}">RestoCode</a>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/servicios') }}">Servicios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/blog') }}">Blog</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    @if (session()->has('feedback.message'))
        <div class="container mt-3">
            <div class="alert alert-success">
                {{ session('feedback.message') }}
            </div>
        </div>
    @endif

    <main>
        {{ $slot }}
    </main>

    <footer class="border-top py-4 mt-5">
        <div class="container">
            <p class="mb-0">RestoCode · soluciones digitales para gastronomía</p>
        </div>
    </footer>
</body>
</html>