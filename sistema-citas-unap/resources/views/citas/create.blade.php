
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Solicitar cita médica</h4>
                </div>

                <div class="card-body">

                    <p class="text-muted">
                        Completa el siguiente formulario para registrar
                        tu solicitud de atención médica.
                    </p>

                    <form action="{{ route('citas.store') }}" method="POST">
                        @csrf

                        <!-- Fecha -->
                        <div class="mb-3">
                            <label for="fecha" class="form-label">
                                Fecha de atención
                            </label>

                            <input
                                type="date"
                                class="form-control @error('fecha') is-invalid @enderror"
                                id="fecha"
                                name="fecha"
                                min="{{ date('Y-m-d') }}"
                                value="{{ old('fecha') }}"
                                required
                            >

                            @error('fecha')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Hora -->
                        <div class="mb-3">
                            <label for="hora" class="form-label">
                                Hora de atención
                            </label>

                            <input
                                type="time"
                                class="form-control @error('hora') is-invalid @enderror"
                                id="hora"
                                name="hora"
                                value="{{ old('hora') }}"
                                required
                            >

                            @error('hora')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Motivo -->
                        <div class="mb-3">
                            <label for="motivo" class="form-label">
                                Motivo de la consulta
                            </label>

                            <textarea
                                class="form-control @error('motivo') is-invalid @enderror"
                                id="motivo"
                                name="motivo"
                                rows="4"
                                placeholder="Describe brevemente el motivo de tu consulta..."
                                required
                            >{{ old('motivo') }}</textarea>

                            @error('motivo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Botones -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('home') }}"
                               class="btn btn-secondary">
                                Cancelar
                            </a>

                            <button type="submit" class="btn btn-primary">
                                Enviar solicitud
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
