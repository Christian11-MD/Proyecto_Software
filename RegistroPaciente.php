
<?php

// SISTEMA DE GESTION DE CITAS MEDICAS - UNA PUNO
// MODULO: REGISTRO DE PACIENTES

// 1. RECEPCION DE DATOS

$datos = [
    "nombres" => "",
    "apellidos" => "",
    "codigo" => "",
    "dni" => "",
    "correo" => "",
    "celular" => ""
];

$errores = [];
$registro_exitoso = false;

// Simulacion de registros existentes
$codigos_registrados = [
    "20260001",
    "20260002"
];

$dnis_registrados = [
    "12345678"
];

// 2. PROCESAMIENTO DE LA FUNCIONALIDAD

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Recibir los datos del formulario
    foreach ($datos as $campo => $valor) {
        $datos[$campo] = trim($_POST[$campo] ?? "");
    }

    // 3. VALIDACIONES

    // Validar nombres
    if (
        empty($datos["nombres"]) ||
        !preg_match("/^[\p{L}\s'-]+$/u", $datos["nombres"])
    ) {
        $errores[] = "Ingrese nombres validos.";
    }

    // Validar apellidos
    if (
        empty($datos["apellidos"]) ||
        !preg_match("/^[\p{L}\s'-]+$/u", $datos["apellidos"])
    ) {
        $errores[] = "Ingrese apellidos validos.";
    }

    // Validar codigo universitario
    if (!preg_match("/^[A-Za-z0-9]{6,12}$/", $datos["codigo"])) {
        $errores[] = "El codigo universitario debe tener entre 6 y 12 caracteres alfanumericos.";
    } elseif (in_array($datos["codigo"], $codigos_registrados, true)) {
        $errores[] = "El codigo universitario ya se encuentra registrado.";
    }

    // Validar DNI
    if (!preg_match("/^[0-9]{8}$/", $datos["dni"])) {
        $errores[] = "El DNI debe contener exactamente 8 digitos.";
    } elseif (in_array($datos["dni"], $dnis_registrados, true)) {
        $errores[] = "El DNI ya se encuentra registrado.";
    }

    // Validar correo electronico
    if (!filter_var($datos["correo"], FILTER_VALIDATE_EMAIL)) {
        $errores[] = "Ingrese un correo electronico valido.";
    }

    // Validar celular peruano
    if (!preg_match("/^9[0-9]{8}$/", $datos["celular"])) {
        $errores[] = "El celular debe tener 9 digitos y comenzar con 9.";
    }

    // Resultado del procesamiento
    if (empty($errores)) {
        $registro_exitoso = true;
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registro de Pacientes - UNA Puno</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #eef2f7;
            margin: 0;
            padding: 35px 15px;
        }

        .contenedor {
            max-width: 650px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px #00000018;
        }

        h1 {
            text-align: center;
            color: #174b70;
            font-size: 25px;
        }

        .subtitulo {
            text-align: center;
            color: #666;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-top: 16px;
            font-weight: bold;
            color: #333;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-top: 7px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        input:focus {
            outline: none;
            border-color: #176b87;
        }

        button {
            width: 100%;
            padding: 14px;
            margin-top: 25px;
            background: #176b87;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #104d64;
        }

        .mensaje {
            padding: 15px;
            margin-top: 20px;
            border-radius: 6px;
        }

        .exito {
            background: #d9f5e3;
            color: #176534;
        }

        .error {
            background: #ffe0e0;
            color: #a11b1b;
        }

        .error ul {
            padding-left: 20px;
        }

    </style>

</head>

<body>

<div class="contenedor">

    <h1>Registro de Pacientes</h1>

    <p class="subtitulo">
        Servicio Médico Primario - UNA Puno
    </p>

    <!-- FORMULARIO DE REGISTRO -->

    <form method="POST" action="">

        <label>Nombres:</label>
        <input
            type="text"
            name="nombres"
            value="<?php echo htmlspecialchars($datos['nombres']); ?>"
            placeholder="Ingrese sus nombres"
            required
        >

        <label>Apellidos:</label>
        <input
            type="text"
            name="apellidos"
            value="<?php echo htmlspecialchars($datos['apellidos']); ?>"
            placeholder="Ingrese sus apellidos"
            required
        >

        <label>Codigo universitario:</label>
        <input
            type="text"
            name="codigo"
            value="<?php echo htmlspecialchars($datos['codigo']); ?>"
            placeholder="Ingrese su codigo"
            required
        >

        <label>DNI:</label>
        <input
            type="text"
            name="dni"
            maxlength="8"
            value="<?php echo htmlspecialchars($datos['dni']); ?>"
            placeholder="Ingrese su DNI"
            required
        >

        <label>Correo electronico:</label>
        <input
            type="email"
            name="correo"
            value="<?php echo htmlspecialchars($datos['correo']); ?>"
            placeholder="ejemplo@correo.com"
            required
        >

        <label>Numero de celular:</label>
        <input
            type="tel"
            name="celular"
            maxlength="9"
            value="<?php echo htmlspecialchars($datos['celular']); ?>"
            placeholder="999999999"
            required
        >

        <button type="submit">
            Registrar paciente
        </button>

    </form>

    <!-- PRESENTACION DE RESULTADOS -->

    <?php if (!empty($errores)): ?>

        <div class="mensaje error">

            <strong>No se pudo completar el registro:</strong>

            <ul>
                <?php foreach ($errores as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>

        </div>

    <?php elseif ($registro_exitoso): ?>

        <div class="mensaje exito">

            <strong>¡Validacion exitosa!</strong>

            <p>
                Los datos del paciente son correctos.
                El registro esta listo para guardarse.
            </p>

            <p>
                Nombre:
                <?php echo htmlspecialchars($datos["nombres"] . " " . $datos["apellidos"]); ?>
            </p>

            <p>
                Codigo:
                <?php echo htmlspecialchars($datos["codigo"]); ?>
            </p>

        </div>

    <?php endif; ?>

</div>

</body>
</html>
