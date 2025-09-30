<?php
require_once __DIR__ . '/../core/Database.php';

class SelectsModel
{
    private $pdo;
    public function __construct()
    {
        $this->pdo = Database::conn();
    }

    public function fnSelectArea()
    {
        $sql = "SELECT codigo, nombre FROM area ORDER BY codigo ASC";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    public function fnSelectCargo()
    {
        $sql = "SELECT codigo, nombre FROM cargo ORDER BY codigo ASC";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    public function fnSelectSentido()
    {
        $sql = "SELECT codigo, nombre FROM sentido ORDER BY codigo ASC";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    public function fnSelectTurno()
    {
        $sql = "SELECT codigo, nombre FROM turno ORDER BY codigo ASC";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    public function fnSelectSistema()
    {
        $sql = "SELECT codigo, nombre FROM sistemas ORDER BY codigo ASC";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    public function fnSelectTipoEquipo()
    {
        $sql = "SELECT codigo, nombre FROM tipo_equipos ORDER BY codigo ASC";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    public function fnSelectEquipo()
    {
        $sql = "SELECT codigo, nombre FROM equipos ORDER BY codigo ASC";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    public function fnSelectPersonal()
    {
        $sql = "SELECT codigo, CONCAT(nombres, ' ', apepat, ' ', apemat) AS nombre 
                FROM personal ORDER BY codigo ASC";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    public function fnSelectRepuesto()
    {
        $sql = "SELECT codigo, nombre from repuestos ORDER BY codigo ASC";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    public function fnSelectUnidadMedida()
    {
        $sql = "SELECT codigo, nombre from unidad_medida ORDER BY codigo ASC";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    public function fnSelectRepuestoAndUnidad($codCorrectivo, $codRepuesto)
    {
        $sql = "SELECT cr.codrepuestos AS CodRepuesto, r.nombre 
                AS r_Nombre, cr.codunidad AS CodUnidad, um.nombre
                AS um_Nombre
                FROM correctivo_material cr
                INNER JOIN repuestos AS r
                ON cr.codrepuestos = r.codigo
                INNER JOIN unidad_medida AS um
                ON cr.codunidad = um.codigo
                WHERE   cr.codcorrectivo = ? AND
                        cr.codrepuestos = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$codCorrectivo, $codRepuesto]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function fnSelectRepuestoByCorrectivo($codigoCorrectivo)
    {
        $sql = "SELECT r.codigo, r.nombre
                FROM repuestos AS r
                WHERE r.codigo NOT IN (
                SELECT codrepuestos
                FROM correctivo_material
                WHERE codcorrectivo = ?
                )
                ORDER BY codigo";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$codigoCorrectivo]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function fnSelectUnidadMedidaByCodRepuesto($codRepuesto)
    {
        $sql = "SELECT um.codigo, um.nombre
                FROM unidad_medida AS um
                INNER JOIN repuestos AS r
                ON um.codigo = r.codumedida
                WHERE r.codigo = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$codRepuesto]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function fnSelectTipoEquipoxSistema($idSistema)
    {
        $sql = "CALL sp_filtrar_TipoEquipo_por_Sistema(:Sistema)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":Sistema", $idSistema);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function fnSelectEquipoxTipoEquipo($idTipoEquipo)
    {
        $sql = "CALL sp_filtrar_equipo_por_tipoEquipo(:TipoEquipo)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":TipoEquipo", $idTipoEquipo);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        // return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    public function fnSelectEstadoEquipo()
    {
        $sql = "SELECT codigo, nombre FROM estado_equipo ORDER BY codigo ASC";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}
