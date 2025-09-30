<?php
// dto/RegistroDTO.php

class CorrectivoRepuestoDTO
{
    public function __construct(
        public string $codcorrectivo,
        public string $codrepuesto,
        public string $codunidad,
        public ?string $descripcion = '',
        public ?string $descripcionunidad = '',
        public ?string $abreviaturaunidad = '',
        public float $cantidad,
        public string $observacion,
        public ?string $fregistro = null,
        public ?string $usercreate = null,
        public ?string $fupdate = null,
        public ?string $userupdate = null
    ) {}

    public static function fromArray(array $a): self
    {
        return new self(
            codcorrectivo: (string)($a['CodCorrectivo'] ?? ''),
            codrepuesto: (string)$a['CodRepuesto'],
            codunidad: (string)$a['CodUnidad'],
            descripcion: (string)($a['Descripcion'] = ''),
            descripcionunidad: (string)($a['DescripcionUnidad'] = ''),
            abreviaturaunidad: (string)($a['AbreviaturaUnidad'] = ''),
            cantidad: (string)$a['Cantidad'],
            observacion: (string)$a['Observacion'],
            usercreate: (string)($a['UserCreate'] ?? ''),
            fregistro: (string)($a['FechaRegistro'] ?? ''),
            userupdate: (string)($a['UserUpdate'] ?? ''),
            fupdate: (string)($a['FechaUpdate'] ?? '')
        );
    }
}
