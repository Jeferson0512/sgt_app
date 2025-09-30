<?php
require_once __DIR__ . '/../core/Database.php';

class AreaModel
{
    private $pdo;
    public function __construct()
    {
        $this->pdo = Database::conn();
    }

    public function AreaList()
    {
        $sql = "SELECT codigo, nombre, abreviatura, estado, fregistro, usercreate FROM area ORDER BY codigo DESC";
        return $this->pdo->query($sql)->fetchAll();
    }

    public function AreaFindCodigo(int $codigo)
    {
        $st = $this->pdo->prepare("SELECT codigo, nombre, abreviatura, estado, fregistro, usercreate FROM area WHERE codigo=? LIMIT 1");
        $st->execute([$codigo]);
        return $st->fetch();
    }

    public function AreaCreate($datos)
    {
        // $st = $this->pdo->prepare("CALL sp_agregarAreaMaestra(?, ?, ?, ?)");
        $sql = $this->pdo->prepare("CALL sp_agregarAreaMaestra(:Nombre, :Abreviatura, :Estado, :Usuario)");
        $sql->bindParam(":Nombre", $datos['Nombre']);
        $sql->bindParam(":Abreviatura", $datos['Abreviatura']);
        $sql->bindParam(":Estado", $datos['Estado']);
        $sql->bindParam(":Usuario", $datos['Usuario']);
        // $st->execute([$datos['Nombre'], $datos['Abreviatura'], $datos['Estado'], $datos['Usuario']]);
        $sql->execute();
        // return (int)$this->pdo->lastInsertId();
        return $datos["Nombre"];
    }

    public function AreaUpdate(int $id, string $nombre, int $estado)
    {
        $st = $this->pdo->prepare("UPDATE areas SET nombre=?, estado=? WHERE codigo=?");
        return $st->execute([$nombre, $estado, $id]);
    }

    public function AreaDelete($codigo)
    {
        $st = $this->pdo->prepare("DELETE FROM area WHERE codigo=?");
        return $st->execute([$codigo]);
    }
}
