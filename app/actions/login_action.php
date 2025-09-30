<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../models/UserModel.php';

// JSON helper
header('Content-Type: application/json; charset=utf-8');
function out($ok, $msg = '', $data = null)
{
  echo json_encode(['ok' => $ok, 'msg' => $msg, 'data' => $data]);
  exit;
}

// Solo POST
if (strtoupper($_SERVER['REQUEST_METHOD']) !== 'POST') {
  out(false, 'Método no permitido');
}
//De SGT
$email = trim($_POST['email'] ?? '');
$pass  = trim($_POST['password'] ?? '');

if ($email === '' || $pass === '') {
  out(false, 'Completa email y contraseña');
}

try {
  $model = new UserModel();
  $user  = $model->verifyCredentials($email, $pass);

  if (!$user) {
    out(false, 'Credenciales inválidas o usuario inactivo');
  }

  // Crear sesión segura
  $_SESSION['user'] = [
    'codigo'    => $user['codigo'],
    'usuario'    => $user['usuario'],
    'nombres_completo'  => $user['nombres_completo'],
    'nombres'  => $user['nombres'],
    'apellidos' => $user['apellidos'],
    'tipo'  => $user['tipo']
  ];

  out(true, 'Login correcto', ['redirect' => BASE_URL . 'dashboard']);
} catch (Throwable $e) {
  out(false, 'Error interno: ' . $e->getMessage());
}
