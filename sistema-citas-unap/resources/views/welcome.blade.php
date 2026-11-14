<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Servicio Médico Primario - UNA Puno</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">Servicio Médico Primario - UNA Puno</a>
            <div class="d-flex gap-2">
                @auth
                    <a href="{{ url('/home') }}" class="btn btn-light btn-sm fw-semibold">Ir al Panel</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Iniciar Sesión</a>
                    <a href="{{ route('register') }}" class="btn btn-light btn-sm fw-semibold text-primary">Registrarse</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <div class="card border-0 shadow-sm p-5">
                    <h1 class="display-6 fw-bold text-primary mb-3">Gestión de Citas Médicas</h1>
                    <p class="lead text-secondary mb-4">
                        Plataforma web para la solicitud, programación y seguimiento de atenciones médicas en el Servicio Médico Primario de la Universidad Nacional del Altiplano.
                    </p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-4">Ingresar al Sistema</a>
                        <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-lg px-4">Crear Cuenta</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
