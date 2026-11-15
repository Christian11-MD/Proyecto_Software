
@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="mb-0">Panel del estudiante</h4>
                </div>

                <div class="card-body">

                    <h5>¡Bienvenido, {{ Auth::user()->name }}!</h5>

                    <p>
                        Desde este panel puedes gestionar tus solicitudes
                        de atención médica en el Servicio Médico Primario
                        de la Universidad Nacional del Altiplano.
                    </p>

                    <hr>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5>Solicitar cita médica</h5>

                                    <p>
                                        Registra una nueva solicitud de
                                        atención médica.
                                    </p>

                                    <a href="{{ route('citas.create') }}"
                                       class="btn btn-primary">
                                        Solicitar cita
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5>Mis solicitudes</h5>

                                    <p>
                                        Consulta las solicitudes de citas
                                        que has registrado.
                                    </p>

                                    <a href="{{ route('citas.index') }}"
                                       class="btn btn-success">
                                        Ver solicitudes
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>
@endsection
