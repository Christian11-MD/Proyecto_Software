@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        {{ Auth::user()->role === 'estudiante' ? 'Mis Solicitudes de Citas' : 'Gestión General de Citas Médicas' }}
                    </h4>
                    <a href="{{ route('citas.create') }}" class="btn btn-light btn-sm fw-bold">+ Nueva Cita</a>
                </div>

                <div class="card-body">
                    @if($citas->isEmpty())
                        <div class="alert alert-info mb-0">No hay citas médicas registradas por el momento.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        @if(Auth::user()->role !== 'estudiante')
                                            <th>Paciente</th>
                                        @endif
                                        <th>Especialidad</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Motivo</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($citas as $cita)
                                        <tr>
                                            <td>{{ $cita->id }}</td>
                                            @if(Auth::user()->role !== 'estudiante')
                                                <td>
                                                    <strong>{{ $cita->user->name ?? 'Usuario eliminado' }}</strong><br>
                                                    <small class="text-muted">{{ $cita->user->email ?? '' }}</small>
                                                </td>
                                            @endif
                                            <td>{{ $cita->especialidad }}</td>
                                            <td>{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($cita->hora)->format('H:i') }}</td>
                                            <td>{{ Str::limit($cita->motivo, 45) }}</td>
                                            <td>
                                                @php
                                                    $badge = match($cita->estado) {
                                                        'pendiente'  => 'bg-warning text-dark',
                                                        'confirmada' => 'bg-info text-dark',
                                                        'atendida'   => 'bg-success',
                                                        'cancelada'  => 'bg-danger',
                                                        default      => 'bg-secondary',
                                                    };
                                                @endphp
                                                <span class="badge {{ $badge }}">{{ strtoupper($cita->estado) }}</span>
                                            </td>
                                            <td>
                                                @if(Auth::user()->role === 'estudiante')
                                                    @if($cita->estado === 'pendiente')
                                                        <form action="{{ route('citas.estado', $cita) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="estado" value="cancelada">
                                                            <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Cancelar esta cita?')">Cancelar</button>
                                                        </form>
                                                    @else
                                                        <span class="text-muted small">Sin acciones</span>
                                                    @endif
                                                @else
                                                    <div class="btn-group btn-group-sm">
                                                        @if($cita->estado === 'pendiente')
                                                            <form action="{{ route('citas.estado', $cita) }}" method="POST" class="d-inline">
                                                                @csrf @method('PATCH')
                                                                <input type="hidden" name="estado" value="confirmada">
                                                                <button type="submit" class="btn btn-info">Confirmar</button>
                                                            </form>
                                                        @endif

                                                        @if(in_array($cita->estado, ['pendiente', 'confirmada']))
                                                            <form action="{{ route('citas.estado', $cita) }}" method="POST" class="d-inline ms-1">
                                                                @csrf @method('PATCH')
                                                                <input type="hidden" name="estado" value="atendida">
                                                                <button type="submit" class="btn btn-success">Atender</button>
                                                            </form>

                                                            <form action="{{ route('citas.estado', $cita) }}" method="POST" class="d-inline ms-1">
                                                                @csrf @method('PATCH')
                                                                <input type="hidden" name="estado" value="cancelada">
                                                                <button type="submit" class="btn btn-danger">Cancelar</button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    <div class="mt-3">
                        <a href="{{ route('home') }}" class="btn btn-secondary">Volver al Panel</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
