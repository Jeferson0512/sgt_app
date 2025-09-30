<?php
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../dto/CorrectivoRepuestoDTO.php';
require_once __DIR__ . '/../dto/CorrectivoActividadDTO.php';

class CorrectivoModel
{
    private static $pdo;

    public function __construct()
    {
        self::$pdo = Database::conn();
    }
    public function generarNuevoCodigo(): string
    {
        $sql = "SELECT MAX(codigo) AS ultimo_codigo FROM correctivos";
        $stmt = self::$pdo->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $ultimoCodigo = $row['ultimo_codigo'] ?? null;

        if ($ultimoCodigo) {
            $numero = (int)substr($ultimoCodigo, 6);
            $nuevoNumero = $numero + 1;
        } else {
            $nuevoNumero = 1;
        }

        return 'CODCOR' . str_pad($nuevoNumero, 3, '0', STR_PAD_LEFT);
    }
    public function mListCorrectivo(): array
    {
        // $sql = "CALL sp_listarMantenimientoCorrectivo()";
        // return self::$pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        $stmt = self::$pdo->prepare("CALL sp_listarMantenimientoCorrectivo()");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
        // IMPORTANTE: liberar el cursor después de CALL
        $stmt->closeCursor();
        return $rows;
    }
    public function mFindCorrectivoByCodigo(string $codigo)
    {
        $stmt = self::$pdo->prepare("CALL sp_obtenerCorrectivo(?)");
        $stmt->execute([$codigo]);
        $rows = $stmt->fetch(PDO::FETCH_ASSOC) ?? [];
        return  $rows;
        // $result = $st->fetch(PDO::FETCH_ASSOC);
        // return $result ?: null;
    }
    public function mCreateCorrectivo(array $datos): string
    {
        // try {
        $sql = self::$pdo->prepare('CALL sp_registrarManttoCorrectivo(:FechaMantto, :CodTurno, :CodSentido, :CodSistema, :CodTipoEquipo, :CodEquipo, :CodPersonal, :CodEstadoEquipo, :CodObservaciones, :Estado, :Usuario)');
        $sql->bindParam(":FechaMantto", $datos['FechaMantto']);
        $sql->bindParam(":CodTurno", $datos['CodTurno']);
        $sql->bindParam(":CodSentido", $datos['CodSentido']);
        $sql->bindParam(":CodSistema", $datos['CodSistema']);
        $sql->bindParam(":CodTipoEquipo", $datos['CodTipoEquipo']);
        $sql->bindParam(":CodEquipo", $datos['CodEquipo']);
        $sql->bindParam(":CodPersonal", $datos['CodPersonal']);
        $sql->bindParam(":CodEstadoEquipo", $datos['CodEstadoEquipo']);
        $sql->bindParam(":CodObservaciones", $datos['Observaciones']);
        $sql->bindParam(":Estado", $datos['Estado']);
        $sql->bindParam(":Usuario", $datos['UserCreate']);
        $sql->execute();

        // Si el SP hace "SELECT nuevo_codigo AS codigo" como primer resultset:
        $codigo = $sql->fetchColumn();
        $sql->closeCursor(); // importante tras CALL
        return (string)$codigo;

        //Si devuelve con OUT varios parametros osolo uno tmb es asi
        // $call->closeCursor(); // ¡clave!

        // $codigo = $this->pdo->query('SELECT @out_codigo')->fetchColumn();
        // return (string)$codigo;
    }
    public function mListCorrectivoActividades(string $codigo): array
    {
        $sql = "CALL sp_listarCorrectivoActividad(:CodCorrectivo)";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":CodCorrectivo", $codigo);
        $stmt->execute();
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }
    public function mListCorrectivoRepuestos(string $codigo): array
    {
        $sql = "CALL sp_listarCorrectivoRepuesto(:CodCorrectivo)";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":CodCorrectivo", $codigo);
        $stmt->execute();
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }
    public function mListCorrectivoArchivos($data): array
    {
        $sql = "CALL sp_listarCorrectivoArchivos(:CodCorrectivo, :Tipo)";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":CodCorrectivo", $data['CodCorrectivo']);
        $stmt->bindParam(":Tipo",           $data['Tipo']);
        $stmt->execute();
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }
    public function mCountAllCorrectivoActividades(string $codCorrectivo): int
    {
        $sql = "
            SELECT COUNT(*) AS total_actividades
            FROM correctivo_actividad
            WHERE   codcorrectivo = :CodCorrectivo AND
                    estado = '1'
            ";
        $st = self::$pdo->prepare($sql);
        $st->execute([':CodCorrectivo' => $codCorrectivo]);
        $row = $st->fetch(PDO::FETCH_ASSOC) ?: ['total_actividades' => 0];
        $totalActividades = (int)($row['total_actividades'] ?? 0);
        return $totalActividades;
    }
    public function mCountAllCorrectivoRepuestos(string $codCorrectivo): int
    {
        $sql = "
            SELECT COUNT(*) AS total_repuestos
            FROM correctivo_material
            WHERE codcorrectivo = :CodCorrectivo
            ";
        $st = self::$pdo->prepare($sql);
        $st->execute([':CodCorrectivo' => $codCorrectivo]);
        $row = $st->fetch(PDO::FETCH_ASSOC) ?: ['total_repuestos' => 0];
        $totalRepuestos = (int)($row['total_repuestos'] ?? 0);
        return $totalRepuestos;
    }
    public function mCountAllCorrectivoArchivos(string $codCorrectivo): array
    {
        $sql = "
            SELECT
                SUM(CASE WHEN tipo='DOC' AND estado=1 THEN 1 ELSE 0 END) AS docs,
                SUM(CASE WHEN tipo='IMG' AND estado=1 THEN 1 ELSE 0 END) AS imgs
            FROM correctivo_archivo
            WHERE codcorrectivo = :CodCorrectivo
            ";
        $st = self::$pdo->prepare($sql);
        $st->execute([':CodCorrectivo' => $codCorrectivo]);
        $row = $st->fetch(PDO::FETCH_ASSOC) ?: ['docs' => 0, 'imgs' => 0];
        $docs = (int)($row['docs'] ?? 0);
        $imgs = (int)($row['imgs'] ?? 0);
        return ['docs' => $docs, 'imgs' => $imgs, 'total' => $docs + $imgs];
    }
    public function fnRegistrarCorrectivoArchivo($datos)
    {
        try {
            $sql = self::$pdo->prepare('CALL sp_agregarCorrectivoArchivo(
                :CodCorrectivo, :Tipo, :Extension, :Size, :Estado, :Usuario, :RutaBase,
                @Codigo_Salida, @Nombre_salida, @Nombre_sin_salida, @Ruta_salida)');
            $sql->bindParam(":CodCorrectivo",   $datos['CodCorrectivo']);
            $sql->bindParam(":Tipo",            $datos['Tipo']);
            $sql->bindParam(":Extension",       $datos['Extension']);
            $sql->bindParam(":Size",            $datos['Size']);
            $sql->bindParam(":Estado",          $datos['Estado']);
            $sql->bindParam(":Usuario",         $datos['Usuario']);
            $sql->bindParam(":RutaBase",        $datos['RutaBase']);
            // $sql->bindParam(":", $datos['']);
            // $sql->bindParam(":CodObservaciones", $datos['CodObservaciones']);
            // $sql->bindParam(":Estado", $datos['Estado']);
            // $sql->bindParam(":Usuario", $datos['Usuario']);
            $sql->execute();
            //Obtener el resultado que esta devolviendo
            $sql->closeCursor();
            $data = self::$pdo->query("SELECT @Codigo_Salida AS codArchivo, @Nombre_salida AS nombre, @Nombre_sin_salida AS nombreCompleto, @Ruta_salida AS ruta")->fetch();

            // $codigo = self::$pdo->query("SELECT @Codigo_Salida AS codArchivo")->fetch();

            // return (string)$codigo["codArchivo"];
            return $data;
            // return [
            //     'success' => true,
            //     'codigo'  => $data['codigo'],
            //     'nombre'  => $data['nombre'],
            //     'ruta'    => $data['ruta']
            // ];
        } catch (PDOException $e) {
            throw new Exception("M: " . $e->getMessage(), 0, $e);
            // return [
            //     'data' => "",
            //     'success' => false,
            //     'msg' => 'Error al registrar mantenimiento: ' . $e->getMessage()
            // ];
        }
    }
    public function mRegistrarCorrectivoActividad(CorrectivoActividadDTO $datos): array
    {
        try {
            $stmt = self::$pdo->prepare('CALL sp_agregarCorrectivoActividad(
                :CodCorrectivo, :CodPersonal, :FechaInicio, :HoraInicio, :HoraFin, :Descripcion, :Estado, :UserCreate, @codigo_salida)');
            //Se usa de esta manera cuando esta vinculado a un DTO
            $stmt->bindParam(":CodCorrectivo",  $datos->codcorrectivo);
            $stmt->bindParam(":CodPersonal",    $datos->codpersonal);
            $stmt->bindParam(":FechaInicio",    $datos->fecha_inicio);
            $stmt->bindParam(":HoraInicio",     $datos->hora_inicio);
            $stmt->bindParam(":HoraFin",        $datos->hora_fin);
            $stmt->bindParam(":Descripcion",    $datos->descripcion);
            $stmt->bindParam(":Estado",         $datos->estado);
            $stmt->bindParam(":UserCreate",     $datos->usercreate);
            $stmt->execute();
            //Obtener el select que esta devolviendo
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();

            return
                [
                    'success' => true,
                    'data'  => $data

                ];
        } catch (PDOException $e) {
            throw new Exception("M: " . $e->getMessage(), 0, $e);
        }
    }
    public function mRegistrarCorrectivoRepuesto(CorrectivoRepuestoDTO $datos): array
    {
        try {
            $stmt = self::$pdo->prepare('CALL sp_agregarCorrectivoRepuesto(
                :CodCorrectivo, :CodRepuesto, :CodUnidad, :Descripcion, :DescripcionUnidad, :AbreviaturaUnidad, :Cantidad,
                :Observacion)');
            //Solo se usa de esta manera si es un array
            // $stmt->bindParam(":CodCorrectivo",       $datos['CodCorrectivo']);
            // $stmt->bindParam(":CodRepuesto",         $datos['CodRepuesto']);
            // $stmt->bindParam(":CodUnidad",           $datos['CodUnidad']);
            // $stmt->bindParam(":Descripcion",         $datos['Descripcion']);
            // $stmt->bindParam(":DescripcionUnidad",   $datos['DescripcionUnidad']);
            // $stmt->bindParam(":AbreviaturaUnidad",   $datos['AbreviaturaUnidad']);
            // $stmt->bindParam(":Cantidad",            $datos['Cantidad']);
            // $stmt->bindParam(":Observacion",         $datos['Observacion']);
            //Se usa de esta manera cuando esta vinculado a un DTO
            $stmt->bindParam(":CodCorrectivo",       $datos->codcorrectivo);
            $stmt->bindParam(":CodRepuesto",         $datos->codrepuesto);
            $stmt->bindParam(":CodUnidad",           $datos->codunidad);
            $stmt->bindParam(":Descripcion",         $datos->descripcion);
            $stmt->bindParam(":DescripcionUnidad",   $datos->descripcionunidad);
            $stmt->bindParam(":AbreviaturaUnidad",   $datos->abreviaturaunidad);
            $stmt->bindParam(":Cantidad",            $datos->cantidad);
            $stmt->bindParam(":Observacion",         $datos->observacion);
            $stmt->execute();
            //Obtener el select que esta devolviendo
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();

            return
                [
                    'success' => true,
                    'data'  => $data

                ];
        } catch (PDOException $e) {
            throw new Exception("M: " . $e->getMessage(), 0, $e);
        }
    }
    public function mDeleteCorrectivoActividad(string $codigo, string $user)
    {
        try {
            $sql = 'CALL sp_eliminarCorrectivoActividad(:Codigo, :UserUpdate)';
            $stmt = self::$pdo->prepare($sql);
            $stmt->bindParam(':Codigo', $codigo);
            $stmt->bindParam(':UserUpdate', $user);
            $ok = $stmt->execute();

            return $ok;
        } catch (PDOException $e) {
            throw new \RuntimeException('M:' . $e->getMessage(), 0, $e);
        }
    }
    public function mDeleteCorrectivoRepuesto($datos)
    {
        try {
            $sql = 'DELETE FROM correctivo_material 
                    WHERE   codcorrectivo  = :CodCorrectivo AND 
                            codrepuestos = :CodRepuesto';
            $stmt = self::$pdo->prepare($sql);
            $stmt->bindParam(':CodCorrectivo', $datos['CodCorrectivo']);
            $stmt->bindParam(':CodRepuesto', $datos['CodRepuesto']);
            $stmt->execute();

            return $stmt->rowCount();
        } catch (PDOException $e) {
            throw new \RuntimeException('Error al eliminar el Repuesto', 0, $e);
        }
    }
    public function fnEliminarCorrectivoArchivo($datos)
    {
        try {
            $sql = 'CALL sp_eliminarCorrectivoArchivo(:CodCorrectivo, :CodArchivo, :Usuario)';
            $stmt = self::$pdo->prepare($sql);
            $stmt->bindParam(':CodCorrectivo', $datos['CodCorrectivo']);
            $stmt->bindParam(':CodArchivo', $datos['CodArchivo']);
            $stmt->bindParam(':Usuario', $datos['Usuario']);
            $stmt->execute();
            $resultado = $stmt->fetchColumn();
            $stmt->closeCursor();

            return $resultado;
        } catch (PDOException $e) {
            throw new \RuntimeException('Error al listar archivos', 0, $e);
        }
    }
}
