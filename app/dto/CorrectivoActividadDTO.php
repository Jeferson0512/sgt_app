<?php
// dto/RegistroDTO.php

final class CorrectivoActividadDTO
{
    public ?string $codigo;
    public string $codcorrectivo;
    public string $codpersonal;
    public string $fecha_inicio;
    public ?string $fecha_fin;
    public string $hora_inicio;
    public string $hora_fin;
    public ?string $descripcion;
    public string $estado;
    public ?string $usercreate;
    public ?string $fregistro;
    public ?string $fupdate;
    public ?string $userupdate;

    public function __construct(
        ?string $codigo = null,
        string $codcorrectivo,
        string $codpersonal,
        string $fecha_inicio,
        ?string $fecha_fin = null,
        string $hora_inicio,
        string $hora_fin,
        ?string $descripcion = null,
        string $estado,
        ?string $usercreate = 'rvizarreta',
        ?string $fregistro = null,
        ?string $userupdate = null,
        ?string $fupdate = null
    ) {
        $this->codigo = $codigo;
        $this->codcorrectivo = $codcorrectivo;
        $this->codpersonal = $codpersonal;
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_fin = $fecha_fin;
        $this->hora_inicio = $hora_inicio;
        $this->hora_fin = $hora_fin;
        $this->descripcion = $descripcion;
        $this->estado = $estado;
        $this->usercreate = $usercreate;
        $this->fregistro = $fregistro;
        $this->userupdate = $userupdate;
        $this->fupdate = $fupdate;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            codigo: (string)($data['codigo'] ?? ''),
            codcorrectivo: (string)($data['CodCorrectivo'] ?? ''),
            codpersonal: (string)($data['CodPersonal'] ?? ''),
            fecha_inicio: (string)($data['FechaInicio'] ?? null),
            fecha_fin: (string)($data['FechaFin'] ?? null),
            hora_inicio: (string)($data['HoraInicio'] ?? null),
            hora_fin: (string)($data['HoraFin'] ?? null),
            descripcion: (string)($data['Descripcion'] ?? null),
            estado: (string)($data['Estado'] ?? null),
            usercreate: (string)($data['UserCreate'] ?? 'rvizarreta'),
            fregistro: (string)($data['FechaRegistro'] ?? null),
            userupdate: (string)($data['UserUpdate'] ?? 'rvizarreta'),
            fupdate: (string)($data['FechaUpdate'] ?? null)
        );
    }
    public function toArray(): array
    {
        return [
            'codigo'        => $this->codigo,
            'codcorrectivo' => $this->codcorrectivo,
            'codpersonal'   => $this->codpersonal,
            'fecha_inicio'  => $this->fecha_inicio,
            'fecha_fin'     => $this->fecha_fin,
            'hora_inicio'   => $this->hora_inicio,
            'hora_fin'      => $this->hora_fin,
            'descripcion'   => $this->descripcion,
            'estado'        => $this->estado,
            'usercreate'    => $this->usercreate,
            'fregistro'     => $this->fregistro,
            'userupdate'    => $this->userupdate,
            'fupdate'       => $this->fupdate,
        ];
    }
}
