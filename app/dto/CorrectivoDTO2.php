<?php
// dto/RegistroDTO.php

class RegistroDTO2
{
    private string $codigo;
    private string $fecha;
    private string $codturno;
    private string $codsentido;
    private string $codsistema;
    private string $codtequipo;
    private string $codequipo;
    private string $codestadoe;
    private string $codpersonal;
    private ?string $observaciones;  // Puede ser null
    private string $estado;
    private ?string $fregistro;      // Puede ser null (datetime, guardamos como string)
    private ?string $usercreate;     // Puede ser null
    private ?string $fupdate;        // Puede ser null (datetime)
    private ?string $userupdate;     // Puede ser null

    public function __construct(
        string $codigo,
        string $fecha,
        string $codturno,
        string $codsentido,
        string $codsistema,
        string $codtequipo,
        string $codequipo,
        string $codestadoe,
        string $codpersonal,
        ?string $observaciones = null,
        string $estado,
        ?string $fregistro = null,
        ?string $usercreate = null,
        ?string $fupdate = null,
        ?string $userupdate = null
    ) {
        $this->codigo = $codigo;
        $this->fecha = $fecha;
        $this->codturno = $codturno;
        $this->codsentido = $codsentido;
        $this->codsistema = $codsistema;
        $this->codtequipo = $codtequipo;
        $this->codequipo = $codequipo;
        $this->codestadoe = $codestadoe;
        $this->codpersonal = $codpersonal;
        $this->observaciones = $observaciones;
        $this->estado = $estado;
        $this->fregistro = $fregistro;
        $this->usercreate = $usercreate;
        $this->fupdate = $fupdate;
        $this->userupdate = $userupdate;
    }

    // Getters y Setters

    public function getCodigo(): string
    {
        return $this->codigo;
    }
    public function setCodigo(string $codigo): void
    {
        $this->codigo = $codigo;
    }

    public function getFecha(): string
    {
        return $this->fecha;
    }
    public function setFecha(string $fecha): void
    {
        $this->fecha = $fecha;
    }

    public function getCodturno(): string
    {
        return $this->codturno;
    }
    public function setCodturno(string $codturno): void
    {
        $this->codturno = $codturno;
    }

    public function getCodsentido(): string
    {
        return $this->codsentido;
    }
    public function setCodsentido(string $codsentido): void
    {
        $this->codsentido = $codsentido;
    }

    public function getCodsistema(): string
    {
        return $this->codsistema;
    }
    public function setCodsistema(string $codsistema): void
    {
        $this->codsistema = $codsistema;
    }

    public function getCodtequipo(): string
    {
        return $this->codtequipo;
    }
    public function setCodtequipo(string $codtequipo): void
    {
        $this->codtequipo = $codtequipo;
    }

    public function getCodequipo(): string
    {
        return $this->codequipo;
    }
    public function setCodequipo(string $codequipo): void
    {
        $this->codequipo = $codequipo;
    }

    public function getCodestadoe(): string
    {
        return $this->codestadoe;
    }
    public function setCodestadoe(string $codestadoe): void
    {
        $this->codestadoe = $codestadoe;
    }

    public function getCodpersonal(): string
    {
        return $this->codpersonal;
    }
    public function setCodpersonal(string $codpersonal): void
    {
        $this->codpersonal = $codpersonal;
    }

    public function getObservaciones(): ?string
    {
        return $this->observaciones;
    }
    public function setObservaciones(?string $observaciones): void
    {
        $this->observaciones = $observaciones;
    }

    public function getEstado(): string
    {
        return $this->estado;
    }
    public function setEstado(string $estado): void
    {
        $this->estado = $estado;
    }

    public function getFregistro(): ?string
    {
        return $this->fregistro;
    }
    public function setFregistro(?string $fregistro): void
    {
        $this->fregistro = $fregistro;
    }

    public function getUsercreate(): ?string
    {
        return $this->usercreate;
    }
    public function setUsercreate(?string $usercreate): void
    {
        $this->usercreate = $usercreate;
    }

    public function getFupdate(): ?string
    {
        return $this->fupdate;
    }
    public function setFupdate(?string $fupdate): void
    {
        $this->fupdate = $fupdate;
    }

    public function getUserupdate(): ?string
    {
        return $this->userupdate;
    }
    public function setUserupdate(?string $userupdate): void
    {
        $this->userupdate = $userupdate;
    }
}
