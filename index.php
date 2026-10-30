<?php
declare(strict_types=1);

class HorarioAtencion
{
    public function __construct(
        private string $medico,
        private string $fecha,
        private string $hora,
        private bool $ocupado = false
    ) {}

    public function getMedico(): string { return $this->medico; }
    public function getFecha(): string { return $this->fecha; }
    public function getHora(): string { return $this->hora; }

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
        return $this->fecha === $fecha && $this->hora === $hora;
    }
}

class Cita
{
    private string $estado = 'pendiente';

    public function __construct(
        private string $codigoEstudiante,
        private HorarioAtencion $horario
    ) {}

    public function registrar(): void
    {
        $this->horario->ocupar();
    }

    public function resumen(): string
    {
        return sprintf(
            "Cita registrada: estudiante %s | %s %s | %s | estado: %s",
            $this->codigoEstudiante,
            $this->horario->getFecha(),
            $this->horario->getHora(),
            $this->horario->getMedico(),
            $this->estado
        );
    }
}

class SolicitudCita
{
    /** @param HorarioAtencion[] $horarios */
    public function __construct(private array $horarios) {}

    public function solicitar(string $codigo, string $fecha, string $hora): Cita
    {
        $this->validarCodigo($codigo);
        $this->validarFechaHora($fecha, $hora);

        $horario = $this->buscarHorario($fecha, $hora);
        if ($horario === null) {
            throw new InvalidArgumentException("No existe un horario de atención en esa fecha y hora.");
        }
        if (!$horario->estaDisponible()) {
            throw new InvalidArgumentException("El horario seleccionado ya está ocupado.");
        }

        $cita = new Cita($codigo, $horario);
        $cita->registrar();
        return $cita;
    }

    private function validarCodigo(string $codigo): void
    {
        if ($codigo === '' || !ctype_digit($codigo)) {
            throw new InvalidArgumentException("El código del estudiante es obligatorio y debe contener solo dígitos.");
        }
    }

    private function validarFechaHora(string $fecha, string $hora): void
    {
        $f = explode('-', $fecha);
        if (count($f) !== 3 || !ctype_digit(implode('', $f)) || !checkdate((int)$f[1], (int)$f[2], (int)$f[0])) {
            throw new InvalidArgumentException("La fecha no es válida. Use el formato AAAA-MM-DD.");
        }
        if (!preg_match('/^([01]\d|2[0-3]):[0-5]\d$/', $hora)) {
            throw new InvalidArgumentException("La hora no es válida. Use el formato HH:MM.");
        }
    }

    private function buscarHorario(string $fecha, string $hora): ?HorarioAtencion
    {
        foreach ($this->horarios as $h) {
            if ($h->coincide($fecha, $hora)) {
                return $h;
            }
        }
        return null;
    }
}

// ---- Programa principal: php solicitar_cita.php <codigo> <fecha> <hora> ----
$horarios = [
    new HorarioAtencion("Médico general", "2026-11-02", "08:00"),
    new HorarioAtencion("Médico general", "2026-11-02", "09:00", true), // ya ocupado
    new HorarioAtencion("Médico general", "2026-11-02", "10:00"),
];

$codigo = $argv[1] ?? '';
$fecha  = $argv[2] ?? '';
$hora   = $argv[3] ?? '';

try {
    $servicio = new SolicitudCita($horarios);
    $cita = $servicio->solicitar($codigo, $fecha, $hora);
    echo $cita->resumen() . PHP_EOL;
} catch (InvalidArgumentException $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}
