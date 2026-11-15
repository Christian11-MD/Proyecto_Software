<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    public function index()
    {
        $citas = Cita::where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->get();

        return view('citas.index', compact('citas'));
    }

    public function create()
    {
        return view('citas.create');
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'fecha' => [
                'required',
                'date',
                'after_or_equal:today'
            ],
            'hora' => [
                'required',
                'date_format:H:i'
            ],
            'motivo' => [
                'required',
                'string',
                'min:5',
                'max:1000'
            ],
        ], [
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'La fecha ingresada no es válida.',
            'fecha.after_or_equal' => 'La fecha no puede ser anterior a hoy.',
            'hora.required' => 'La hora es obligatoria.',
            'hora.date_format' => 'El formato de la hora no es válido.',
            'motivo.required' => 'El motivo es obligatorio.',
            'motivo.min' => 'El motivo debe tener al menos 5 caracteres.',
            'motivo.max' => 'El motivo no debe superar los 1000 caracteres.',
        ]);

        Cita::create([
            'user_id' => $request->user()->id,
            'fecha' => $datos['fecha'],
            'hora' => $datos['hora'],
            'motivo' => $datos['motivo'],
            'estado' => 'pendiente',
        ]);

        return redirect()
            ->route('citas.index')
            ->with('success', 'La solicitud de cita fue registrada correctamente.');
    }
}
