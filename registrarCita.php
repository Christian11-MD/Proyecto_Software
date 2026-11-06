<?php

class Horario {
    public static function verificarDisponibilidad($idHorario, $fecha) {
        // Simulamos que el horario 5 está libre y cualquier otro (como el 8) está ocupado
        if ($idHorario == 5) return true;
        return false;
    }
}

class CitaMedica {
    public $idEstudiante;
    public $idHorario;
    public $fecha;
    public $estado;

    public function guardar() {
        // Simula el guardado en base de datos
        return true; 
    }
}

// 2. TU COMPONENTE IMPLEMENTADO (GestorCitas)
class GestorCitas {
    public function registrarCita($idEstudiante, $idHorario, $fecha) {
        // Validación inicial
        if (empty($idEstudiante) || empty($idHorario)) {
            return "Error: Datos incompletos.";
        }

        // Validación de disponibilidad
        $horarioDisponible = Horario::verificarDisponibilidad($idHorario, $fecha);
        
        if (!$horarioDisponible) {
            return "Rechazado: El horario seleccionado ya no está disponible.";
        }

        // Registro de la cita
        $nuevaCita = new CitaMedica();
        $nuevaCita->idEstudiante = $idEstudiante;
        $nuevaCita->idHorario = $idHorario;
        $nuevaCita->fecha = $fecha;
        $nuevaCita->estado = 'Confirmada';
        $nuevaCita->guardar();

        return "Éxito: Cita registrada correctamente.";
    }
}

$gestor = new GestorCitas();

echo "--- PRUEBA 1: DATOS CORRECTOS ---\n";
$resultado1 = $gestor->registrarCita(228153, 5, "2026-11-15");
echo "Resultado: " . $resultado1 . "\n\n";

echo "--- PRUEBA 2: DATOS RECHAZADOS ---\n";        
$resultado2 = $gestor->registrarCita(228153, 8, "2026-11-15");
echo "Resultado: " . $resultado2 . "\n";

?>