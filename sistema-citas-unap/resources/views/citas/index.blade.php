
@extends('layouts.app')

@section('content')
<div class="container">

    <!-- Encabezado -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3>Mis solicitudes de citas</h3>
            <p class="text-muted mb-0">
                Consulta el estado de tus solicitudes médicas.
            </p>
        </div>

        <a href="{{ route('citas.create') }}" class="btn btn-primary">
            Nueva solicitud
        </a>
    </div>

    <!-- Mensaje de éxito -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Cerrar">
            </button>
        </div>
    @endif

    <!-- Tabla de solicitudes -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">Historial de solicitudes</h5>
        </div>

        <div class="card-body">

            @if ($citas->isEmpty())

                <div class="text-center py-5">
                    <h5 class="text-muted">
                        No tienes solicitudes registradas.
                    </h5>

                    <p class="text-muted">
                        Cuando registres una cita, aparecerá en esta sección.
                    </p>

                    <a href="{{ route('citas.create') }}"
                       class="btn btn-primary">
                        Solicitar mi primera cita
                    </a>
                </div>

            @else

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-light">
                            <tr>
                                <th>Código</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Motivo</th>
                                <th>Estado</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($citas as $cita)
                                <tr>
                                    <td>{{ $cita->id }}</td>

                                    <td>
                                        {{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}
                                    </td>

                                    <td>
                                        {{ substr($cita->hora, 0, 5) }}
                                    </td>

                                    <td>
                                        {{ $cita->motivo }}
                                    </td>

                                    <td>
                                        @if ($cita->estado === 'pendiente')
                                            <span class="badge bg-warning text-dark">
                                                Pendiente
                                            </span>
                                        @elseif ($cita->estado === 'aprobada')
                                            <span class="badge bg-success">
                                                Aprobada
                                            </span>
                                        @elseif ($cita->estado === 'rechazada')
                                            <span class="badge bg-danger">
                                                Rechazada
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                {{ ucfirst($cita->estado) }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

            @endif

        </div>
    </div>

    <!-- Regresar -->
    <div class="mt-3">
        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
            Volver al inicio
        </a>
    </div>

</div>
@endsection
