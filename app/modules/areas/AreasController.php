<?php
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../models/AreaModel.php';

class AreasController extends Controller
{

  // Vista principal (tabla + modal)
  public function index()
  {
    // Crea una instancia del modelo (ajusta según cómo lo llames en tu app)
    $areaModel = new AreaModel();
    // Ejecuta el método del modelo
    $lista = $areaModel->AreaList();
    $this->render(__DIR__ . '/views/index.php', [
      'user' => $_SESSION['user'] ?? null,
      'lista' => $lista
    ]);
  }

  // JSON: lista
  public function list()
  {
    header('Content-Type: application/json; charset=utf-8');
    try {
      $m = new AreaModel();
      $rows = $m->AreaList();
      echo json_encode(['ok' => true, 'msg' => 'OK', 'data' => $rows]);
    } catch (Throwable $e) {
      echo json_encode(['ok' => false, 'msg' => $e->getMessage(), 'data' => null]);
    }
    exit;
  }
  // JSON: crear
  public function store()
  {
    header('Content-Type: application/json; charset=utf-8');
    if (strtoupper($_SERVER['REQUEST_METHOD']) !== 'POST') {
      echo json_encode(['ok' => false, 'msg' => 'Método no permitido', 'data' => null]);
      exit;
    }
    $datos = [
      "Codigo" => $_POST['codigo'],
      "Nombre" => $_POST['nombre'],
      "Abreviatura" => $_POST['abreviatura'],
      "Estado" => '1',
      "Fecha" => date("Y-m-d H:i:s"),
      "Usuario" => "rvizarreta"
    ];
    // if($nombre===''){ echo json_encode(['ok'=>false,'msg'=>'Nombre requerido','data'=>null]); exit; }

    try {
      $m = new AreaModel();
      $id = $m->AreaCreate($datos);
      echo json_encode(['ok' => true, 'msg' => 'Creado', 'data' => ['nombre' => $id]]);
    } catch (Throwable $e) {
      echo json_encode(['ok' => false, 'msg' => $e->getMessage(), 'data' => null]);
    }
    exit;
  }

  // JSON: actualizar
  // public function Areaupdate()
  // {
  //   header('Content-Type: application/json; charset=utf-8');
  //   if (strtoupper($_SERVER['REQUEST_METHOD']) !== 'POST') {
  //     echo json_encode(['ok' => false, 'msg' => 'Método no permitido', 'data' => null]);
  //     exit;
  //   }
  //   $datos = [
  //     "Codigo" => $_POST['codigo'],
  //     "Nombre" => $_POST['nombre'],
  //     "Abreviatura" => $_POST['abreviatura'],
  //     "Estado" => '1',
  //     "Fecha" => date("Y-m-d H:i:s"),
  //     "Usuario" => "rvizarreta"
  //   ];
  //   if ($id <= 0 || $nombre === '') {
  //     echo json_encode(['ok' => false, 'msg' => 'Datos inválidos', 'data' => null]);
  //     exit;
  //   }

  //   try {
  //     $m = new AreaModel();
  //     $ok = $m->AreaUpdate($id, $nombre, $estado);
  //     echo json_encode(['ok' => $ok, 'msg' => $ok ? 'Actualizado' : 'Sin cambios', 'data' => null]);
  //   } catch (Throwable $e) {
  //     echo json_encode(['ok' => false, 'msg' => $e->getMessage(), 'data' => null]);
  //   }
  //   exit;
  // }

  // JSON: eliminar
  public function AreaDelete()
  {
    header('Content-Type: application/json; charset=utf-8');
    if (strtoupper($_SERVER['REQUEST_METHOD']) !== 'POST') {
      echo json_encode(['ok' => false, 'msg' => 'Método no permitido', 'data' => null]);
      exit;
    }
    $codigo = $_POST['codigo'];
    // if($codigo<=0){ echo json_encode(['ok'=>false,'msg'=>'Codigo inválido','data'=>null]); exit; }

    try {
      $m = new AreaModel();
      $ok = $m->AreaDelete($codigo);
      echo json_encode(['ok' => $ok, 'msg' => $ok ? 'Eliminado' : 'No se pudo eliminar', 'data' => null]);
    } catch (Throwable $e) {
      echo json_encode(['ok' => false, 'msg' => $e->getMessage(), 'data' => null]);
    }
    exit;
  }
}
