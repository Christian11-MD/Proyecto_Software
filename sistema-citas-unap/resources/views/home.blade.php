@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            @if(Auth::user()->role === 'estudiante' || !Auth::user()->role)
                {{-- PANEL DEL ESTUDIANTE --}}
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Panel del Estudiante</h4>
                    </div>
                    <div class="card-body">
                        <h5>¡Bienvenido, {{ Auth::user()->name }}!</h5>
                        <p>
                            Desde este panel puedes gestionar tus solicitudes de atención médica en el Servicio Médico Primario de la Universidad Nacional del Altiplano.
                        </p>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5>Solicitar cita médica</h5>
                                        <p>Registra una nueva solicitud de atención médica.</p>
                                        <a href="{{ route('citas.create') }}" class="btn btn-primary">Solicitar cita</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5>Mis solicitudes</h5>
                                        <p>Consulta las solicitudes de citas que has registrado.</p>
                                        <a href="{{ route('citas.index') }}" class="btn btn-success">Ver solicitudes</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @elseif(Auth::user()->role === 'medico')
                {{-- PANEL DEL MÉDICO --}}
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">Panel del Personal Médico</h4>
                    </div>
                    <div class="card-body">
                        <h5>Bienvenido(a), Dr(a). {{ Auth::user()->name }}</h5>
                        <p>Gestiona tu agenda diaria de pacientes y el estado de las consultas programadas.</p>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5>Citas Programadas</h5>
                                        <p>Revisa la lista de pacientes agendados y registra atención.</p>
                                        <a href="{{ route('citas.index') }}" class="btn btn-success">Ver Agenda de Citas</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @elseif(Auth::user()->role === 'administrativo')
                {{-- PANEL DEL PERSONAL ADMINISTRATIVO --}}
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-dark">
                        <h4 class="mb-0">Panel Administrativo</h4>
                    </div>
                    <div class="card-body">
                        <h5>Bienvenido(a), {{ Auth::user()->name }}</h5>
                        <p>Administra la recepción, validación y programación de citas del Servicio Médico Primario.</p>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5>Gestión General de Citas</h5>
                                        <p>Visualiza, confirma o reprograma las solicitudes de citas.</p>
                                        <a href="{{ route('citas.index') }}" class="btn btn-primary">Gestionar Citas</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5>Registrar Cita Presencial</h5>
                                        <p>Agenda una cita directamente para un estudiante en ventanilla.</p>
                                        <a href="{{ route('citas.create') }}" class="btn btn-outline-primary">Nueva Cita</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @elseif(Auth::user()->role === 'admin')
                {{-- PANEL DEL ADMINISTRADOR DEL SISTEMA --}}
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <h4 class="mb-0">Panel de Administración del Sistema</h4>
                    </div>
                    <div class="card-body">
                        <h5>Bienvenido(a), {{ Auth::user()->name }}</h5>
                        <p>Control global de usuarios, roles y supervisión del Servicio Médico Primario UNA Puno.</p>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5>Supervisión de Citas</h5>
                                        <p>Consulta todas las citas registradas en el sistema.</p>
                                        <a href="{{ route('citas.index') }}" class="btn btn-dark">Ver Todas las Citas</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
