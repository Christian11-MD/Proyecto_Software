<?php
// 1. Recepcion de datos (ID ingresado por el administrador/medico)
$idUsuario = 999; 

// 2. Procesamiento (Simulacion de la consulta en la base de datos)
$base_datos = array(
    101 => array("nombre" => "Elvis Canazas", "carrera" => "Ing. Sistemas"),
    102 => array("nombre" => "Christian Mayta", "carrera" => "Ing. Sistemas")
);

// 3. Validacion (Verificar si el usuario existe)
if (array_key_exists($idUsuario, $base_datos)) {
    // 3. Generacion de resultado (Exitoso)
    $usuario = $base_datos[$idUsuario];
    echo "Exito: Datos encontrados -> Nombre: " . $usuario["nombre"] . " | Carrera: " . $usuario["carrera"];
} else {
    // 3. Generacion de resultado (Rechazado)
    echo "Error: El usuario con ID " . $idUsuario . " no se encuentra registrado.";
}
?>