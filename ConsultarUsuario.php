<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consultar Usuario - UNA Puno</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
        .container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0px 0px 10px #ccc; max-width: 400px; margin: auto; }
        input, button { width: 100%; padding: 10px; margin: 10px 0; border-radius: 5px; border: 1px solid #ccc; box-sizing: border-box; }
        button { background-color: #0056b3; color: white; cursor: pointer; }
        button:hover { background-color: #004494; }
        .resultado { margin-top: 20px; padding: 10px; border-radius: 5px; }
        .exito { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>

<div class="container">
    <h2 style="text-align: center;">Consultar Usuario</h2>
    
    <!-- Formulario HTML -->
    <form method="POST">
        <label>Ingrese el ID del usuario:</label>
        <input type="number" name="idUsuario" required placeholder="Ej: 102 o 999">
        <button type="submit">Buscar Usuario</button>
    </form>

    <?php
    // El código PHP solo se ejecuta si el usuario presionó el botón "Buscar"
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        // 1. Recepcion de datos
        $idUsuario = $_POST['idUsuario']; 

        // 2. Procesamiento (Simulacion de base de datos)
        $base_datos = array(
            101 => array("nombre" => "Elvis Canazas", "carrera" => "Ing. Sistemas"),
            102 => array("nombre" => "Christian Mayta", "carrera" => "Ing. Sistemas")
        );

        // 3. Validacion
        if (array_key_exists($idUsuario, $base_datos)) {
            // Generacion de resultado (Exitoso)
            $usuario = $base_datos[$idUsuario];
            echo "<div class='resultado exito'><strong>Éxito:</strong> Datos encontrados <br> <b>Nombre:</b> " . $usuario["nombre"] . "<br><b>Carrera:</b> " . $usuario["carrera"] . "</div>";
        } else {
            // Generacion de resultado (Rechazado)
            echo "<div class='resultado error'><strong>Error:</strong> El usuario con ID " . $idUsuario . " no se encuentra registrado.</div>";
        }
    }
    ?>
</div>

</body>
</html>