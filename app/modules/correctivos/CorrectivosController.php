<?php
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../dto/CorrectivoDTO.php';
require_once __DIR__ . '/../../servicio/CorrectivoService.php';
require_once __DIR__ . '/../../models/CorrectivoModel.php';
require_once __DIR__ . '/../../models/SelectsModel.php';

class CorrectivosController extends Controller
{
  // Vista principal (tabla + modal)
  public function index()
  {
    // Crea una instancia del modelo (ajusta según cómo lo llames en tu app)
    $service = new CorrectivoService();
    // Ejecuta el método del modelo
    $res = $service->sListCorrectivo();
    $lista = $res->success ? ($res->data ?? []) : [];
    $this->render(__DIR__ . '/views/index.php', [
      'user' => $_SESSION['user'] ?? null,
      'lista' => $lista
    ]);
  }
  public function nuevo()
  {
    $mSelect    = new SelectsModel();
    $sSistema = $mSelect->fnSelectSistema();
    // $sTipoEquipo = $mSelect->fnSelectTipoEquipoxSistema($correctivo['codsistema']);
    // $sEquipo = $mSelect->fnSelectEquipoxTipoEquipo($correctivo['codtequipo']);
    $sPersonal = $mSelect->fnSelectPersonal();
    $sEstadoEquipo = $mSelect->fnSelectEstadoEquipo();
    $sTurno = $mSelect->fnSelectTurno();
    $sSentido = $mSelect->fnSelectSentido();

    $this->render(__DIR__ . '/views/create.php', ['sSistema' => $sSistema, 'sPersonal' => $sPersonal, 'sEstadoEquipo' => $sEstadoEquipo, 'sTurno' => $sTurno, 'sSentido' => $sSentido]);
    // $this->render(__DIR__ . '/views/create.php', ['mode'=>'create', 'row'=>null]);
  }

  // Acción: muestra el formulario de edición
  public function edit()
  {
    $user = $_SESSION['user']['usuario'] ?? null;
    $codigo   = $_GET['codigo'];
    // Instancia el modelo
    $mCorrectivo    = new CorrectivoModel();
    $mSelect    = new SelectsModel();
    $correctivo = $mCorrectivo->mFindCorrectivoByCodigo($codigo);
    $sSistema = $mSelect->fnSelectSistema();
    $sPersonal = $mSelect->fnSelectPersonal();
    $sEstadoEquipo = $mSelect->fnSelectEstadoEquipo();
    $sTurno = $mSelect->fnSelectTurno();
    $sSentido = $mSelect->fnSelectSentido();
    $sRepuesto = $mSelect->fnSelectRepuestoByCorrectivo($codigo);
    // $sRepuesto = $mSelect->fnSelectRepuesto();
    $sUnidadMedida = $mSelect->fnSelectUnidadMedida();
    $sTipoEquipo = $mSelect->fnSelectTipoEquipoxSistema($correctivo['codsistema']);
    $sEquipo = $mSelect->fnSelectEquipoxTipoEquipo($correctivo['codtequipo']);

    // Si no existe, responde 404 y corta
    // if(!$correctivo){ http_response_code(404); echo 'Área no encontrada'; return; }

    // Renderiza la vista de edición con el registro encontrado
    $this->render(__DIR__ . '/views/edit.php', compact('user', 'codigo', 'correctivo', 'sSistema', 'sTipoEquipo', 'sEquipo', 'sPersonal', 'sEstadoEquipo', 'sTurno', 'sSentido', 'sRepuesto', 'sUnidadMedida'));
  }
  /**
   * registrarCorrectivo
   *
   * @return void
   */
  public function cRegistrarCorrectivo()
  {
    header('Content-Type: application/json; charset=utf-8');

    $datos = $this->validateRequestPOST();

    // Agregar datos fijos si faltan
    $datos['Estado'] = $datos['Estado'] ?? "P";
    $datos['UserCreate'] = $datos['UserCreate'] ?? ($_SESSION['user']['usuario'] ?? 'sistema');

    try {
      $dto = CorrectivoDTO::fromArray($datos);

      $service = new CorrectivoService();
      $res = $service->sCreateCorrectivo($dto);

      http_response_code($res->success ? 201 : 422);
      echo json_encode([
        'success' => $res->success,
        'msg'     => $res->mensaje,
        'data'    => $res->datos
      ]);
    } catch (Throwable $e) {
      http_response_code(500);
      echo json_encode([
        'success' => false,
        'msg' => 'Error interno: ' . $e->getMessage()
      ]);
      // exit;
    }
  }

  public function cRegistrarCorrectivoArchivo()
  {
    header('Content-Type: application/json');
    try {

      if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(["success" => false, "message" => "Método no permitido"]);
        return;
        exit;
      }
      if (!isset($_FILES['file'])) {
        echo json_encode(["success" => false, "message" => "No se recibió archivo"]);
        exit;
      }

      $file = $_FILES['file']; // Validar error

      if ($file['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(["success" => false, "message" => "Error al subir archivo"]);
        exit;
      }

      // Validar tamaño, extensión, etc. si quieres
      $allowedExts = ['pdf', 'doc', 'docx', 'jpg', 'png'];  // ejemplo
      $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

      if (!in_array($ext, $allowedExts)) {
        echo json_encode(["success" => false, "message" => "Tipo de archivo no permitido"]);
        exit;
      }

      // Datos para la base de datos
      $data = [
        'CodCorrectivo' => $_POST['CodCorrectivo'],
        'Tipo'          => $_POST['Tipo'],
        'Extension'     => $ext,
        'Size'          => $file['size'],
        'RutaBase'          => $_POST['RutaBase'],
        'Estado'          => 1,
        'Usuario'          => $_SESSION['user']['usuario'] ?? 'sistema'
      ];

      $resultado  = (new CorrectivoModel())->fnRegistrarCorrectivoArchivo($data);

      if (!$resultado || !isset($resultado['codArchivo']) || !isset($resultado['nombre'])) {
        echo json_encode(["success" => false, "message" => "Error en respuesta del procedimiento almacenado"]);
        exit;
      }

      // Mover archivo físico
      $uploadDir = __DIR__ . '/../../../uploads/';
      if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
      }

      $targetPath = $uploadDir . $resultado['nombre'];

      if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        echo json_encode(["success" => false, "message" => "Error al guardar archivo físico"]);
        exit;
      }

      // header('Content-Type: application/json; charset=utf-8');
      // OK final
      // header('Content-Type: application/json');
      echo json_encode([
        "success" => true,
        "message" => "Archivo registrado correctamente",
        "codigo"  => $resultado['codArchivo'],
        "nombre"  => $resultado['nombre'],
        "ruta"    => $resultado['ruta']
      ]);
      exit;
    } catch (Throwable $e) {
      http_response_code(500);
      echo json_encode([
        'success' => false,
        'message' => 'Error interno: ' . $e->getMessage()
      ]);
      exit;
    }
  }
  public function cRegistrarCorrectivoActividad()
  {
    header('Content-Type: application/json; charset=utf-8');
    $datos = $this->validateRequestPOST();

    try {
      $data = [
        'CodCorrectivo' => $datos['CodCorrectivo'],
        'CodPersonal'   => $datos['CodPersonal'],
        'FechaInicio'   => $datos['FechaInicio'],
        'HoraInicio'    => $datos['HoraInicio'],
        'HoraFin'       => $datos['HoraFin'],
        'Descripcion'   => $datos['Descripcion'],
        'Estado'        => '1',
        'UserCreate'    => $_SESSION['user']['usuario'] ?? 'sistema'
      ];
      $dto = CorrectivoActividadDTO::fromArray($data);

      $resultado  = (new CorrectivoModel())->mRegistrarCorrectivoActividad($dto);

      echo json_encode([
        "success" => $resultado['success'],
        "message" => "Repuesto registrado correctamente",
        "data" => $resultado['data']
      ]);
    } catch (Throwable $e) {
      $mensaje = $e->getMessage();

      // Detecta si el error es del Modelo o del Controlador
      if (str_starts_with($mensaje, "M:")) {
        $errorInterno = "⚠️ Error interno en Modelo: " . substr($mensaje, 3);
      } elseif (str_starts_with($mensaje, "C:")) {
        $errorInterno = "⚠️ Error en Controlador: " . substr($mensaje, 3);
      } else {
        $errorInterno = "⚠️ Error desconocido: " . $mensaje;
      }
      http_response_code(500);
      echo json_encode([
        'success' => false,
        'message' => $errorInterno
      ]);
    }
  }
  public function cRegistrarCorrectivoRepuesto()
  {
    header('Content-Type: application/json; charset=utf-8');
    //Valida POST y Transforma datos en ARRAY
    $datos = $this->validateRequestPOST();

    try {
      // Datos para la base de datos
      $data = [
        'CodCorrectivo' => $datos['CodCorrectivo'],
        'CodRepuesto'          => $datos['CodRepuesto'],
        'CodUnidad'          => $datos['CodUnidad'],
        // 'Descripcion'          => $datos['Descripcion'],
        // 'DescripcionUnidad'          => $datos['DescripcionUnidad'],
        // 'AbreviaturaUnidad'          => $datos['AbreviaturaUnidad'],
        'Cantidad'          => $datos['Cantidad'],
        'Observacion'          => $datos['Observacion'],
        'Usuario'          => $_SESSION['user']['usuario'] ?? 'rvizarreta'
      ];
      $dto = CorrectivoRepuestoDTO::fromArray($data);

      $resultado  = (new CorrectivoModel())->mRegistrarCorrectivoRepuesto($dto);

      echo json_encode([
        "success" => $resultado['success'],
        "message" => "Repuesto registrado correctamente",
        "data" => $resultado['data']
      ]);
    } catch (Throwable $e) {
      $mensaje = $e->getMessage();

      // Detecta si el error es del Modelo o del Controlador
      if (str_starts_with($mensaje, "M:")) {
        $errorInterno = "⚠️ Error interno en Modelo: " . substr($mensaje, 3);
      } elseif (str_starts_with($mensaje, "C:")) {
        $errorInterno = "⚠️ Error en Controlador: " . substr($mensaje, 3);
      } else {
        $errorInterno = "⚠️ Error desconocido: " . $mensaje;
      }
      http_response_code(500);
      echo json_encode([
        'success' => false,
        'message' => $errorInterno
      ]);
    }
  }
  public function cDeleteCorrectivoActividad()
  {
    header('Content-Type: application/json; charset=utf-8');
    $datos = $this->validateRequestPOST();

    try {
      $codigo = $datos['Codigo'];
      $user = $_SESSION['user']['usuario'] ?? 'rvizarreta';

      if (empty($datos['Codigo'])) {
        echo json_encode(["success" => false, "mensaje" => "El código se encuentra vacío"]);
        return;
      }

      $filasEliminadas  = (new CorrectivoModel())->mDeleteCorrectivoActividad($codigo, $user);


      if ($filasEliminadas > 0) {
        echo json_encode([
          "success" => true,
          "mensaje" => "Actividad eliminada correctamente",
          "filasEliminadas" => $filasEliminadas
        ]);
      } else {
        echo json_encode([
          "success" => false,
          "mensaje" => "No se encontró el registro a eliminar"
        ]);
      }
    } catch (Throwable $e) {
      $mensaje = $e->getMessage();

      // Detecta si el error es del Modelo o del Controlador
      if (str_starts_with($mensaje, "M:")) {
        $errorInterno = "⚠️ Error interno en Modelo: " . substr($mensaje, 3);
      } elseif (str_starts_with($mensaje, "C:")) {
        $errorInterno = "⚠️ Error en Controlador: " . substr($mensaje, 3);
      } else {
        $errorInterno = "⚠️ Error desconocido: " . $mensaje;
      }
      http_response_code(500);
      echo json_encode([
        'success' => false,
        'mensaje' => $errorInterno
      ]);
    }
  }
  public function cDeleteCorrectivoRepuesto()
  {
    header('Content-Type: application/json');
    $datos = $this->validateRequestPOST();
    try {

      if (empty($datos['CodCorrectivo'])) {
        echo json_encode(["success" => false, "mensaje" => "El código correctivo se encuentra vacío"]);
        return;
      }
      if (empty($datos['CodRepuesto'])) {
        echo json_encode(["success" => false, "mensaje" => "El código repuesto se encuentra vacío"]);
        return;
      }

      // Datos para la base de datos
      $data = [
        'CodCorrectivo' => $datos['CodCorrectivo'],
        'CodRepuesto'          => $datos['CodRepuesto']
      ];

      // Eliminar en BD
      $filasEliminadas = (new CorrectivoModel())->mDeleteCorrectivoRepuesto($data);

      if ($filasEliminadas > 0) {
        echo json_encode([
          "success" => true,
          "mensaje" => "Repuesto eliminado correctamente",
          "filasEliminadas" => $filasEliminadas
        ]);
      } else {
        echo json_encode([
          "success" => false,
          "mensaje" => "No se encontró el registro a eliminar"
        ]);
      }
      return;
    } catch (Throwable $e) {
      http_response_code(500);
      echo json_encode([
        'success' => false,
        'mensaje' => 'Error interno: ' . $e->getMessage()
      ]);
      return;
    }
  }
  public function eliminarArchivo()
  {
    header('Content-Type: application/json');
    try {


      $body = json_decode(file_get_contents("php://input"), true);

      if (!isset($body['CodArchivo'])) {
        echo json_encode(["success" => false, "message" => "Código requerido"]);
        return;
      }

      // // Ruta base absoluta a /uploads
      // $uploadsDir = realpath(__DIR__ . '/../../../uploads');

      // if (!$uploadsDir) {
      //   echo json_encode(["success" => false, "message" => "Carpeta de uploads no encontrada"]);
      //   return;
      // }
      // // Eliminar físicamente
      // // $ruta = __DIR__ . '/../../../uploads/' . $body['Ruta'];
      // $ruta = realpath(__DIR__ . '/../../../uploads/' . $body['Ruta']);
      // if (file_exists($ruta)) {
      //   // echo json_encode(["success" => true, "message" => "EROR DB" . $ruta . " + HOLAA TRUE"]);
      //   unlink($ruta);
      //   // return;
      // } else {
      //   echo json_encode(["success" => false, "message" => "EROR DB" . $ruta . " + HOLAA"]);
      //   return;
      // };

      // Datos para la base de datos
      $data = [
        'CodCorrectivo' => $body['CodCorrectivo'],
        'CodArchivo'          => $body['CodArchivo'],
        'Usuario'          => $_SESSION['user']['usuario'] ?? 'sistema'
      ];

      // Eliminar en BD
      $ok = (new CorrectivoModel())->fnEliminarCorrectivoArchivo($data);

      echo json_encode(["success" => true, "message" => $ok]);
    } catch (Throwable $e) {
      http_response_code(500);
      echo json_encode([
        'success' => false,
        'msg' => 'Error interno: ' . $e->getMessage()
      ]);
      exit;
    }
  }
  // JSON: lista de CORRECTIVOS
  public function list()
  {
    header('Content-Type: application/json; charset=utf-8');
    try {
      $m = new CorrectivoModel();
      $rows = $m->mListCorrectivo();
      echo json_encode(['ok' => true, 'msg' => 'OK', 'data' => $rows]);
    } catch (Throwable $e) {
      echo json_encode(['ok' => false, 'msg' => $e->getMessage(), 'data' => null]);
    }
    exit;
  }
  // JSON: Lista de Imagenes del Correctivo
  public function cListCorrectivoActividad()
  {
    header('Content-Type: application/json');
    $data = $this->validateRequestPOST();

    try {

      if (!isset($data['CodCorrectivo'])) {
        echo json_encode(["success" => false, "message" => "Código de correctivo faltante", "data" => []]);
        exit;
      }

      $actividades = (new CorrectivoModel())->mListCorrectivoActividades($data['CodCorrectivo']);

      echo json_encode([
        'success' => true,
        'mensaje' => 'Ok',
        'data'    => $actividades
      ]);
    } catch (\Throwable $e) {
      $mensaje = $e->getMessage();

      // Detecta si el error es del Modelo o del Controlador
      if (str_starts_with($mensaje, "M:")) {
        $errorInterno = "⚠️ Error interno en Modelo: " . substr($mensaje, 3);
      } elseif (str_starts_with($mensaje, "C:")) {
        $errorInterno = "⚠️ Error en Controlador: " . substr($mensaje, 3);
      } else {
        $errorInterno = "⚠️ Error desconocido: " . $mensaje;
      }
      http_response_code(500);
      echo json_encode([
        'success' => false,
        'message' => $errorInterno
      ]);
    }
  }
  // JSON: Lista de Repuestos del Correctivo
  public function cListCorrectivoRepuestos()
  {
    header('Content-Type: application/json');
    $data = $this->validateRequestPOST();

    try {

      if (!isset($data['CodCorrectivo'])) {
        echo json_encode(["success" => false, "message" => "Código de correctivo faltante", "data" => []]);
        exit;
      }

      $repuestos = (new CorrectivoModel())->mListCorrectivoRepuestos($data['CodCorrectivo']);

      echo json_encode([
        'success' => true,
        'mensaje' => 'Ok',
        'data'    => $repuestos
      ]);

      // echo json_encode(['success' => true, 'message' => 'OKSS', 'data' => $archivos]);
    } catch (\Throwable $e) {
      $mensaje = $e->getMessage();

      // Detecta si el error es del Modelo o del Controlador
      if (str_starts_with($mensaje, "M:")) {
        $errorInterno = "⚠️ Error interno en Modelo: " . substr($mensaje, 3);
      } elseif (str_starts_with($mensaje, "C:")) {
        $errorInterno = "⚠️ Error en Controlador: " . substr($mensaje, 3);
      } else {
        $errorInterno = "⚠️ Error desconocido: " . $mensaje;
      }
      http_response_code(500);
      echo json_encode([
        'success' => false,
        'message' => $errorInterno
      ]);
    }
  }
  // JSON: Lista de Imagenes del Correctivo
  public function cListarCorrectivoArchivos()
  {
    // header('Content-Type: application/json; charset=utf-8');
    header('Content-Type: application/json');
    try {
      if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(["success" => false, "message" => "Método no permitido"]);
        exit;
      }

      $data = json_decode(file_get_contents("php://input"), true);

      if (!isset($data['CodCorrectivo'])) {
        echo json_encode(["success" => false, "message" => "Código de correctivo faltante"]);
        exit;
      }

      $archivos = (new CorrectivoModel())->mListCorrectivoArchivos($data);
      echo json_encode(['success' => true, 'message' => 'OKSS', 'data' => $archivos]);
      exit;
    } catch (PDOException $e) {
      // Error de base de datos
      // Loguear, notificar, mostrar mensaje claro al usuario
      return [
        'success' => false,
        'type' => 'database_error',
        'message' => 'Error al acceder a la base de datos: ' . $e->getMessage()
      ];
      exit;
    } catch (\RuntimeException $e) {
      // Error lógico o de negocio que venga del modelo o servicio
      return [
        'success' => false,
        'type' => 'business_error',
        'message' => $e->getMessage()
      ];
      exit;
    } catch (\Throwable $e) {
      // Otros errores inesperados, incluyendo errores del controlador
      return [
        'success' => false,
        'type' => 'system_error',
        'message' => 'Error inesperado: ' . $e->getMessage()
      ];
      exit;
    }
  }
  public function cCountAllCorrectivoActividades()
  {
    $req = json_decode(file_get_contents('php://input'), true) ?? [];
    $cod = $req['CodCorrectivo'] ?? '';
    if ($cod === '') return json_encode(['success' => false, 'message' => 'Falta CodCorrectivo'], 400);

    $data = (new CorrectivoModel())->mCountAllCorrectivoActividades($cod);

    echo json_encode(['success' => true, 'data' => $data]);
  }
  public function cCountAllCorrectivoRepuestos()
  {
    $req = json_decode(file_get_contents('php://input'), true) ?? [];
    $cod = $req['CodCorrectivo'] ?? '';
    if ($cod === '') return json_encode(['success' => false, 'message' => 'Falta CodCorrectivo'], 400);

    $data = (new CorrectivoModel())->mCountAllCorrectivoRepuestos($cod);

    echo json_encode(['success' => true, 'data' => $data]);
  }
  public function cCountAllCorrectivoArchivos()
  {
    $req = json_decode(file_get_contents('php://input'), true) ?? [];
    $cod = $req['CodCorrectivo'] ?? '';
    if ($cod === '') return json_encode(['success' => false, 'message' => 'Falta CodCorrectivo'], 400);

    $data = (new CorrectivoModel())->mCountAllCorrectivoArchivos($cod);
    // $data = $model->contarPorTipo($cod);

    echo json_encode(['success' => true, 'data' => $data]);
  }
  //JSON: Lista de Tipo de Equipos x Sistema
  public function getTipoEquipoPorSistema()
  {
    header('Content-Type: application/json; charset=utf-8');

    if (!isset($_POST['idSistema'])) {
      http_response_code(400);
      echo json_encode(['error' => 'Falta el parámetro idSistema']);
      return;
    }
    $idSistema = $_POST['idSistema'];

    $mSelect = new SelectsModel();
    $tipos = $mSelect->fnSelectTipoEquipoxSistema($idSistema);

    echo json_encode($tipos); // Devuelve los resultados como JSON
  }
  //JSON: Lista de Equipos x TipoEquipo
  public function getEquipoPorTipoEquipo()
  {
    header('Content-Type: application/json; charset=utf-8');

    if (!isset($_POST['idTipoEquipo'])) {
      http_response_code(400);
      echo json_encode(['error' => 'Falta el parámetro idTipoEquipo']);
      return;
    }
    $idTipoEquipo = $_POST['idTipoEquipo'];

    $mSelect = new SelectsModel();
    $tipos = $mSelect->fnSelectEquipoxTipoEquipo($idTipoEquipo);

    echo json_encode($tipos); // Devuelve los resultados como JSON
  }
  public function getRepuestoAndUnidad()
  {
    $codCorrectivo = $_GET['CodCorrectivo'];
    $codRepuesto = $_GET['CodRepuesto'];
    $mSelect = new SelectsModel();
    $data = $mSelect->fnSelectRepuestoAndunidad($codCorrectivo, $codRepuesto);
    header('Content-Type: application/json');
    echo json_encode($data);
  }
  public function getRepuestosDisponibles()
  {
    $codigoCorrectivo = $_GET['codigoCorrectivo'];
    $mSelect = new SelectsModel();
    $data = $mSelect->fnSelectRepuestoByCorrectivo($codigoCorrectivo);
    header('Content-Type: application/json');
    echo json_encode($data);
  }
  public function getUnidadMedidaByCodRepuesto()
  {
    $codRepuesto = $_GET['codRepuesto'];
    $mSelect = new SelectsModel();
    $data = $mSelect->fnSelectUnidadMedidaByCodRepuesto($codRepuesto);
    header('Content-Type: application/json');
    echo json_encode($data);
  }
}
