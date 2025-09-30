<?php
// dto/RegistroDTO.php

class CorrectivoDTO
{
    public function __construct(
        public ?string $codigo = null,
        public string $fecha,
        public string $codturno,
        public string $codsentido,
        public string $codsistema,
        public string $codtequipo,
        public string $codequipo,
        public string $codestadoe,
        public string $codpersonal,
        public ?string $observaciones = null,
        public string $estado,
        public ?string $fregistro = null,
        public ?string $usercreate = null,
        public ?string $fupdate = null,
        public ?string $userupdate = null
    ) {}

    public static function fromArray(array $a): self
    {
        return new self(
            codigo: (string)($a['Codigo'] ?? ''),
            fecha: (string)$a['FechaMantto'],
            codturno: (string)$a['CodTurno'],
            codsentido: (string)$a['CodSentido'],
            codsistema: (string)$a['CodSistema'],
            codtequipo: (string)$a['CodTipoEquipo'],
            codequipo: (string)$a['CodEquipo'],
            codpersonal: (string)$a['CodPersonal'],
            codestadoe: (string)$a['CodEstadoEquipo'],
            observaciones: (string)($a['Observaciones'] ?? ''),
            estado: (string)$a['Estado'],
            usercreate: (string)($a['UserCreate'] ?? ''),
            fregistro: (string)($a['FechaRegistro'] ?? ''),
            userupdate: (string)($a['UserUpdate'] ?? ''),
            fupdate: (string)($a['FechaUpdate'] ?? '')
        );
    }
}
