<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    protected $fillable = [
        'user_id',
        'especialidad',
        'fecha',
        'hora',
        'motivo',
        'estado',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
