<?php
declare(strict_types=1);

// INTERFACES Y CLASES DEL PROGRAMA

interface HorarioDisponible
{
    public function getMedico(): string;
    public function getFecha(): string;
    public function getHora(): string;
    public function estaDisponible(): bool;
    public function ocupar(): void;
    public function coincide(string $fecha, string $hora): bool;
}


interface RepositorioHorarios
{
    public function buscar(
        string $fecha,
        string $hora
    ): ?HorarioDisponible;
}



class HorarioAtencion implements HorarioDisponible
{
    public function __construct(
        private string $medico,
        private string $fecha,
        private string $hora,
        private bool $ocupado = false
    ) {
    }

    public function getMedico(): string
    {
        return $this->medico;
    }

    public function getFecha(): string
    {
        return $this->fecha;
    }

    public function getHora(): string
    {
        return $this->hora;
    }

    public function estaDisponible(): bool
    {
        return !$this->ocupado;
    }

    public function ocupar(): void
    {
        $this->ocupado = true;
    }

    public function coincide(string $fecha, string $hora): bool
    {
        return $this->fecha === $fecha
            && $this->hora === $hora;
    }
}


class RepositorioHorariosEnMemoria implements RepositorioHorarios
{
    /** @param HorarioDisponible[] $horarios */
    public function __construct(
        private array $horarios
    ) {
    }

    public function buscar(
        string $fecha,
        string $hora
    ): ?HorarioDisponible {

        foreach ($this->horarios as $horario) {
            if ($horario->coincide($fecha, $hora)) {
                return $horario;
            }
        }

        return null;
    }
}


class Cita
{
    private string $estado = 'pendiente';

    public function __construct(
        private string $codigoEstudiante,
        private HorarioDisponible $horario
    ) {
    }

    public function registrar(): void
    {
        $this->horario->ocupar();
    }

    public function resumen(): string
    {
        return
            "\n========================================\n" .
            "          SOLICITUD DE CITA MEDICA\n" .
            "========================================\n" .
            "Codigo de estudiante : " . $this->codigoEstudiante . "\n" .
            "Fecha de la cita     : " . $this->horario->getFecha() . "\n" .
            "Hora de la cita      : " . $this->horario->getHora() . "\n" .
            "Medico               : " . $this->horario->getMedico() . "\n" .
            "Estado               : " . ucfirst($this->estado) . "\n" .
            "========================================\n" .
            "Solicitud registrada correctamente.\n";
    }
}



class SolicitudCita
{
    public function __construct(
        private RepositorioHorarios $repositorio
    ) {
    }

    public function solicitar(
        string $codigo,
        string $fecha,
        string $hora
    ): Cita {

        $this->validarCodigo($codigo);
        $this->validarFechaHora($fecha, $hora);

        $horario = $this->repositorio->buscar($fecha, $hora);

        if ($horario === null) {
            throw new InvalidArgumentException(
                "No existe un horario de atención en esa fecha y hora."
            );
        }

        if (!$horario->estaDisponible()) {
            throw new InvalidArgumentException(
                "El horario seleccionado ya está ocupado."
            );
        }

        $cita = new Cita($codigo, $horario);
        $cita->registrar();

        return $cita;
    }

    private function validarCodigo(string $codigo): void
    {
        if ($codigo === '' || !ctype_digit($codigo)) {
            throw new InvalidArgumentException(
                "El código del estudiante es obligatorio y debe contener solo dígitos."
            );
        }
    }

    private function validarFechaHora(
        string $fecha,
        string $hora
    ): void {

        // Validación estricta del formato AAAA-MM-DD
        if (
            !preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)
            || !checkdate(
                (int) substr($fecha, 5, 2),
                (int) substr($fecha, 8, 2),
                (int) substr($fecha, 0, 4)
            )
        ) {
            throw new InvalidArgumentException(
                "La fecha no es válida. Use el formato AAAA-MM-DD."
            );
        }

        // Validación del formato de 24 horas HH:MM
        if (!preg_match('/^(?:[01]\d|2[0-3]):[0-5]\d$/', $hora)) {
            throw new InvalidArgumentException(
                "La hora no es válida. Use el formato HH:MM."
            );
        }
    }
}


// Horarios de atención simulados
$horarios = [
    new HorarioAtencion("Médico general", "2026-11-02", "08:00"),
    new HorarioAtencion("Médico general", "2026-11-02", "09:00", true),
    new HorarioAtencion("Médico general", "2026-11-02", "10:00"),
];

// Crear el repositorio de horarios
$repositorio = new RepositorioHorariosEnMemoria($horarios);

// Crear el servicio de solicitudes
$servicio = new SolicitudCita($repositorio);

// Obtener los datos de la terminal
$codigo = $argv[1] ?? '';
$fecha  = $argv[2] ?? '';
$hora   = $argv[3] ?? '';

// Procesar la solicitud
try {

    if ($argc !== 4) {
        throw new InvalidArgumentException(
            "Uso: php solicitar_cita.php <codigo> <fecha> <hora>"
        );
    }

    $cita = $servicio->solicitar($codigo, $fecha, $hora);

    echo $cita->resumen() . PHP_EOL;

} catch (InvalidArgumentException $e) {

    echo "\nError: " . $e->getMessage() . PHP_EOL;

}
