<?php

// COMPONENTE DE GESTION DE CITAS
require_once "ServicioPaciente.php";

$resultado = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $identificador = $_POST["identificador"] ?? "";

    // Solicitud al servicio de pacientes.
    $resultado = consultarPaciente(
        $identificador,
        $pacientes
    );
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validar paciente para cita</title>

    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #dbeafe, #eff6ff);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .contenedor {
            width: 100%;
            max-width: 500px;
            background: #ffffff;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .titulo {
            text-align: center;
            margin-bottom: 10px;
            color: #1e3a8a;
            font-size: 30px;
        }

        .subtitulo {
            text-align: center;
            margin-bottom: 25px;
            color: #475569;
            font-size: 15px;
        }

        .grupo-formulario {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #334155;
        }

        input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            font-size: 15px;
            outline: none;
            transition: 0.3s;
        }

        input[type="text"]:focus {
            border-color: #2563eb;
            box-shadow: 0 0 6px rgba(37, 99, 235, 0.3);
        }

        .boton {
            width: 100%;
            background: #2563eb;
            color: white;
            border: none;
            padding: 13px;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        .boton:hover {
            background: #1d4ed8;
        }

        .resultado {
            margin-top: 25px;
            padding: 18px;
            border-radius: 12px;
        }

        .exito {
            background: #dcfce7;
            border: 1px solid #22c55e;
            color: #166534;
        }

        .error {
            background: #fee2e2;
            border: 1px solid #ef4444;
            color: #991b1b;
        }

        .resultado h3 {
            margin-top: 0;
            margin-bottom: 12px;
        }

        .dato {
            margin: 8px 0;
            font-size: 15px;
        }

        .dato strong {
            color: #0f172a;
        }
    </style>
</head>
<body>

    <div class="contenedor">
        <h1 class="titulo">Validación de Paciente</h1>
        <p class="subtitulo">
            Ingrese el DNI o código universitario para consultar si el paciente está registrado.
        </p>

        <form method="POST">
            <div class="grupo-formulario">
                <label for="identificador">DNI o código universitario</label>
                <input
                    type="text"
                    id="identificador"
                    name="identificador"
                    placeholder="Ejemplo: 72485147 o 224578"
                    required
                >
            </div>

            <button type="submit" class="boton">
                Consultar paciente
            </button>
        </form>

        <?php if ($resultado !== null): ?>

            <?php if ($resultado["exito"]): ?>
                <div class="resultado exito">
                    <h3>Paciente encontrado</h3>

                    <p class="dato">
                        <strong>Nombre:</strong>
                        <?php echo htmlspecialchars(
                            $resultado["paciente"]["nombres"] . " " .
                            $resultado["paciente"]["apellidos"]
                        ); ?>
                    </p>

                    <p class="dato">
                        <strong>Código:</strong>
                        <?php echo htmlspecialchars(
                            $resultado["paciente"]["codigo"]
                        ); ?>
                    </p>

                    <p class="dato">
                        <strong>DNI:</strong>
                        <?php echo htmlspecialchars(
                            $resultado["paciente"]["dni"]
                        ); ?>
                    </p>

                    <p class="dato">
                        El paciente puede continuar con el proceso de solicitud de cita.
                    </p>
                </div>
            <?php else: ?>
                <div class="resultado error">
                    <h3>Paciente no encontrado</h3>
                    <p class="dato">
                        <?php echo htmlspecialchars($resultado["mensaje"]); ?>
                    </p>
                </div>
            <?php endif; ?>

        <?php endif; ?>
    </div>

</body>
</html>