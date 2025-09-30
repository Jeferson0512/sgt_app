<?php

// declare(strict_types=1);

final class CorrectivoArchivoDTO
{
    public readonly string $codigo;
    public readonly string $codCorrectivo;
    public readonly string $nombre;
    public readonly string $nombreGuardado;
    public readonly string $ruta;
    public readonly string $extension;
    public readonly string $tipo;
    public readonly string $size;
    public readonly string $estado;
    public readonly \DateTimeImmutable $fRegistro;
    public readonly string $userCreate;
    public readonly string $fUpdate;
    public readonly string $userUpdate;
    public function __construct(
        string $codigo,
        string $codCorrectivo,
        string $nombre,
        string $nombreGuardado,
        string $ruta,
        string $extension,
        string $tipo,
        string $size,
        string $estado,
        \DateTimeImmutable $fRegistro,
        string $userCreate,
        string $fUpdate,
        string $userUpdate
    ) {
        $this->$codigo = $codigo;
        $this->$codCorrectivo = $codCorrectivo;
        $this->$nombre = $nombre;
        $this->$nombreGuardado = $nombreGuardado;
        $this->$ruta = $ruta;
        $this->$extension = $extension;
        $this->$tipo = $tipo;
        $this->$size = $size;
        $this->$estado = $estado;
        $this->$fRegistro = $fRegistro;
        $this->$userCreate = $userCreate;
        $this->$fUpdate = $fUpdate;
        $this->$userUpdate = $userUpdate;
    }
}
