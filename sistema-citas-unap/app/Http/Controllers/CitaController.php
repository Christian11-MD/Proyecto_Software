<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    public function index()
    {
        $usuario = auth()->user();

        if ($usuario->role === 'estudiante' || !$usuario->role) {
            $citas = Cita::where('user_id', $usuario->id)
                ->orderByDesc('fecha')
                ->orderByDesc('hora')
                ->get();
        } else {
            $citas = Cita::with('user')
                ->orderBy('fecha')
                ->orderBy('hora')
                ->get();
        }

        return view('citas.index', compact('citas'));
    }

    public function create()
    {
        return view('citas.create');
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'especialidad' => ['required', 'string', 'in:Medicina General,Odontología,Psicología,Obstetricia'],
            'fecha'        => ['required', 'date', 'after_or_equal:today'],
            'hora'         => ['required', 'date_format:H:i'],
            'motivo'       => ['required', 'string', 'min:5', 'max:1000'],
        ], [
            'especialidad.required' => 'Selecciona una especialidad médica.',
            'fecha.required'        => 'La fecha es obligatoria.',
            'fecha.after_or_equal'  => 'La fecha no puede ser anterior a hoy.',
            'hora.required'         => 'La hora es obligatoria.',
            'hora.date_format'      => 'El formato de la hora no es válido.',
            'motivo.required'       => 'El motivo es obligatorio.',
            'motivo.min'            => 'El motivo debe tener al menos 5 caracteres.',
        ]);

        // Validación anti-cruce de horario en la misma fecha, hora y especialidad
        $horarioOcupado = Cita::where('especialidad', $datos['especialidad'])
            ->where('fecha', $datos['fecha'])
            ->where('hora', $datos['hora'])
            ->where('estado', '!=', 'cancelada')
            ->exists();

        if ($horarioOcupado) {
            return back()
                ->withErrors(['hora' => 'Ese horario ya está reservado en ' . $datos['especialidad'] . '. Por favor elige otra hora.'])
                ->withInput();
        }

        Cita::create([
            'user_id'      => $request->user()->id,
            'especialidad' => $datos['especialidad'],
            'fecha'        => $datos['fecha'],
            'hora'         => $datos['hora'],
            'motivo'       => $datos['motivo'],
            'estado'       => 'pendiente',
        ]);

        return redirect()
            ->route('citas.index')
            ->with('success', 'La solicitud de cita fue registrada correctamente.');
    }

    public function cambiarEstado(Request $request, Cita $cita)
    {
        $request->validate([
            'estado' => ['required', 'in:pendiente,confirmada,atendida,cancelada'],
        ]);

        $usuario = auth()->user();

        // Un estudiante solo puede cancelar sus propias citas pendientes
        if ($usuario->role === 'estudiante') {
            if ($cita->user_id !== $usuario->id || $request->estado !== 'cancelada') {
                abort(403, 'No tienes permisos para realizar esta acción.');
            }
        }

        $cita->update(['estado' => $request->estado]);

        return back()->with('success', 'Estado de la cita actualizado a ' . strtoupper($request->estado) . '.');
    }
}
