<?php
/**

 */

// 1. INGRESO O RECEPCIÓN DE DATOS

// Simulamos los datos que el estudiante envía desde el formulario web
$fecha_solicitada = "2026-10-30";
$hora_solicitada = "09:00";

// 2. PROCESAMIENTO DE LA FUNCIONALIDAD

// Simulamos la consulta a la Base de Datos (MySQL) con los horarios ocupados
$horarios_ocupados = array(
    "2026-10-30 09:00",
    "2026-10-30 10:30",
    "2026-10-30 15:00"
);

// Juntamos la fecha y la hora en el formato de la BD
$cita_a_validar = $fecha_solicitada . " " . $hora_solicitada;

// 3. AL MENOS UNA VALIDACIÓN

// Validamos si el horario solicitado ya se encuentra en la lista de ocupados
if (in_array($cita_a_validar, $horarios_ocupados)) {
    $respuesta = "ERROR: El horario del " . $fecha_solicitada . " a las " . $hora_solicitada . " ya está ocupado. Por favor, elija otro.";
} else {
    $respuesta = "ÉXITO: La cita para el " . $fecha_solicitada . " a las " . $hora_solicitada . " ha sido registrada correctamente.";
}

// 4. PRESENTACIÓN DEL RESULTADO

// Mostramos el resultado en pantalla
echo "<h2>Sistema de Gestión de Citas - UNA Puno</h2>";
echo "<p><strong>Resultado de la operación:</strong></p>";
echo "<p>" . $respuesta . "</p>";

?>