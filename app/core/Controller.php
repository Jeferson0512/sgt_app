<?php
class Controller
{
  protected function viewText($text)
  {
    echo $text;
  }

  // Renderiza un archivo de vista y le pasa variables
  protected function render(string $viewFile, array $data = [])
  {
    if (!is_file($viewFile)) {
      echo "<p style='color:#b00'>Vista no encontrada: {$viewFile}</p>";
      return;
    }
    extract($data, EXTR_SKIP);
    include $viewFile;
  }

  function validateRequestPOST(): ?array
  {
    // Verificar que el método sea POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      http_response_code(405);  // Método no permitido
      echo json_encode(['success' => false, 'msg' => 'Método no permitido']);
      return null;
    }

    // Obtener los datos JSON del cuerpo de la solicitud
    $input = file_get_contents('php://input');
    $datos = json_decode($input ?? '', true);

    // Validación básica: verificar que los datos sean un array válido
    if (!$datos || !is_array($datos)) {
      http_response_code(400);  // Solicitud incorrecta
      echo json_encode(['success' => false, 'msg' => 'Datos JSON inválidos']);
      return null;
    }

    // Retornar los datos decodificados si todo está bien
    return $datos;
  }


  function validateRequest(string $expectedMethod = 'POST'): ?array
  {
    // Verificar el método HTTP
    if ($_SERVER['REQUEST_METHOD'] !== $expectedMethod) {
      http_response_code(405);  // Método no permitido
      echo json_encode(['success' => false, 'msg' => 'Método no permitido']);
      return null;
    }

    // Leer y decodificar los datos JSON
    $input = file_get_contents('php://input');
    $datos = json_decode($input ?? '', true);

    // Validación básica
    if (!$datos || !is_array($datos)) {
      http_response_code(400);  // Solicitud incorrecta
      echo json_encode(['success' => false, 'msg' => 'Datos JSON inválidos']);
      return null;
    }

    return $datos;
  }
}

// require_once __DIR__ . '/Response.php';


// class Controller {
//     protected function viewText($text){ echo $text; }
//     protected function jsonOk($msg = 'OK', $data = null){ Response::json(true, $msg, $data); }
//     protected function jsonErr($msg = 'Error', $data = null){ Response::json(false, $msg, $data); }
// }