<?php

// COMPONENTE B: NOTIFICACIONES

interface INotificacion {
    public function enviarConfirmacion($correoEstudiante, $detalleCita);
}

class ServicioNotificacion implements INotificacion {
    public function enviarConfirmacion($correoEstudiante, $detalleCita) {
        if (empty($correoEstudiante) || !filter_var($correoEstudiante, FILTER_VALIDATE_EMAIL)) {
            return [
                'enviado' => false,
                'mensaje' => 'Error en Notificaciones: Correo electrónico inválido.'
            ];
        }
        return [
            'enviado' => true,
            'mensaje' => "Notificación enviada a {$correoEstudiante} ({$detalleCita})"
        ];
    }
}
class Horario {
    public static function verificarDisponibilidad($idHorario, $fecha) {
        return $idHorario === 5;
    }
}

class CitaMedica {
    private $idEstudiante;
    private $idHorario;
    private $fecha;
    private $estado;

    public function __construct($idEstudiante, $idHorario, $fecha) {
        $this->idEstudiante = $idEstudiante;
        $this->idHorario    = $idHorario;
        $this->fecha        = $fecha;
        $this->estado       = 'Pendiente';
    }

    public function confirmar() {
        $this->estado = 'Confirmada';
    }

    public function getIdEstudiante() { return $this->idEstudiante; }
    public function getIdHorario()    { return $this->idHorario; }
    public function getFecha()        { return $this->fecha; }
    public function getEstado()       { return $this->estado; }

    public function guardar() {
        return true;
    }
}

// COMPONENTE A: GESTIÓN DE CITAS

class GestorCitas {
    private $notificador;

    public function __construct(INotificacion $notificador) {
        $this->notificador = $notificador;
    }

    public function registrarCita($idEstudiante, $correoEstudiante, $idHorario, $fecha) {
        // 1. Validación de datos de entrada
        if (empty($idEstudiante) || empty($idHorario) || empty($fecha)) {
            return "Error: Datos de la cita incompletos.";
        }

        // 2. Verificación de disponibilidad del horario
        if (!Horario::verificarDisponibilidad($idHorario, $fecha)) {
            return "Rechazado: El horario #{$idHorario} en la fecha {$fecha} no está disponible. No se invocó al componente Notificaciones.";
        }

        // 3. Registro de la cita médica
        $nuevaCita = new CitaMedica($idEstudiante, $idHorario, $fecha);
        $nuevaCita->confirmar();
        $nuevaCita->guardar();

        // 4. INTEGRACIÓN: COMPONENTE A -> SERVICIO -> COMPONENTE B -> RESPUESTA
        $detalle = "Cita confirmada para el {$fecha} en el turno #{$idHorario}";
        $respuestaNotificacion = $this->notificador->enviarConfirmacion($correoEstudiante, $detalle);

        return "Éxito: Cita registrada en BD | Respuesta Componente B: " . $respuestaNotificacion['mensaje'];
    }
}

$servicioNotificacion = new ServicioNotificacion();
$gestorCitas = new GestorCitas($servicioNotificacion);
// Inicialización e integración de ambos componentes
$componenteNotificaciones = new ServicioNotificacion();
$componenteCitas = new GestorCitas($componenteNotificaciones);

echo "=== PRUEBA DE INTEGRACIÓN 1: FUNCIONAMIENTO ESPERADO ===\n";
$res1 = $componenteCitas->registrarCita(228153, "estudiante@unap.edu.pe", 5, "2026-11-15");
echo $res1 . "\n\n";

echo "=== PRUEBA DE INTEGRACIÓN 2: SITUACIÓN DE RECHAZO O ERROR ===\n";
$res2 = $componenteCitas->registrarCita(228153, "estudiante@unap.edu.pe", 8, "2026-11-15");
echo $res2 . "\n";