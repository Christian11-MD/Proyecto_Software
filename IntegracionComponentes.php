<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Integración de Componentes - UNA Puno</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
        .container { background: white; padding: 30px; border-radius: 8px; max-width: 500px; margin: auto; box-shadow: 0px 0px 15px #ccc; }
        h2 { text-align: center; color: #333; }
        input, button { width: 100%; padding: 12px; margin: 10px 0; border-radius: 5px; border: 1px solid #ccc; box-sizing: border-box; }
        button { background-color: #0056b3; color: white; cursor: pointer; font-size: 16px; font-weight: bold; }
        button:hover { background-color: #004494; }
        .resultado { margin-top: 20px; padding: 15px; border-radius: 5px; }
        .exito { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>

<div class="container">
    <h2>Integración: Usuarios y Citas</h2>
    
    <form method="POST">
        <label><b>Ingrese el ID del estudiante:</b></label>
        <input type="number" name="idUsuario" required placeholder="">
        <button type="submit">Consultar Datos y Citas</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $idUsuario = $_POST['idUsuario']; 

        // ==========================================
        // COMPONENTE A: GESTIÓN DE USUARIOS
        // ==========================================
        $base_usuarios = array(
            101 => array("nombre" => "Elvis Canazas", "carrera" => "Ing. Sistemas"),
            102 => array("nombre" => "Christian Mayta", "carrera" => "Ing. Sistemas")
        );

        if (array_key_exists($idUsuario, $base_usuarios)) {
            $usuario = $base_usuarios[$idUsuario];
            
            // ==========================================
            // INTEGRACIÓN: LLAMADA AL COMPONENTE B
            // ==========================================
            $citas_del_usuario = obtenerCitas($idUsuario);

            echo "<div class='resultado exito'>";
            echo "<strong>¡Integración Exitosa!</strong><br><br>";
            echo "<b>Estudiante:</b> " . $usuario["nombre"] . "<br>";
            echo "<b>Carrera:</b> " . $usuario["carrera"] . "<br>";
            echo "<b>Citas registradas:</b> " . $citas_del_usuario;
            echo "</div>";

        } else {
            echo "<div class='resultado error'><strong>Error:</strong> El usuario con ID " . $idUsuario . " no existe. No se pudo realizar la integración.</div>";
        }
    }

    // ==========================================
    // COMPONENTE B: GESTIÓN DE CITAS (Servicio)
    // ==========================================
    function obtenerCitas($id) {
        $base_citas = array(
            101 => "2 citas programadas (10:00 AM y 11:30 AM)",
            102 => "1 cita programada (09:00 AM)"
        );
        
        if (array_key_exists($id, $base_citas)) {
            return $base_citas[$id];
        } else {
            return "0 citas programadas";
        }
    }
    ?>
</div>

</body>
</html>