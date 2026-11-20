
<?php

// Datos simulados para demostrar la comunicacion.
// Deben reemplazarse por una consulta a MySQL.
$pacientes = [
    [
        "nombres" => "Denilson",
        "apellidos" => "Cuentas Cahuana",
        "codigo" => "224578",
        "dni" => "72485147",
        "correo" => "denilson@gmail.com",
        "celular" => "978121786"
    ]
];

// Busca un paciente por DNI o codigo universitario.
function buscarPaciente($identificador, $pacientes)
{
    $identificador = trim($identificador);

    foreach ($pacientes as $paciente) {
        if (
            $paciente["dni"] === $identificador ||
            $paciente["codigo"] === $identificador
        ) {
            return $paciente;
        }
    }

    return null;
}

// Servicio solicitado por el componente de citas.
function consultarPaciente($identificador, $pacientes)
{
    if (empty(trim($identificador))) {
        return [
            "exito" => false,
            "mensaje" => "Debe ingresar DNI o codigo."
        ];
    }

    $paciente = buscarPaciente($identificador, $pacientes);

    if ($paciente === null) {
        return [
            "exito" => false,
            "mensaje" => "No se encontro un paciente registrado."
        ];
    }

    return [
        "exito" => true,
        "mensaje" => "Paciente encontrado.",
        "paciente" => $paciente
    ];
}

?>
