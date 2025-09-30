<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/models/UserModel.php';

try {
  $model = new UserModel();

  $codigo = 'CODPER010'; // Ultimo codigo de Provias
  // $codigo = 'CODPER012'; //Ultimo codigo de mi PC
  $usuario = 'prueba';
  $nombres  = 'Admin';
  $apellidos = 'apellido';
  $clave  = '123456'; // puedes cambiarlo luego
  $estado = '1';
  $tipo = 'admin';
  $fregistro = '2025-09-10 16:07:03';
  $usercreate = 'rvizarreta';

  $exists = $model->findByEmail($usuario);
  if ($exists) {
    echo "Admin ya existe: {$email}\n";
  } else {
    $id = $model->createSGT($codigo, $usuario, $nombres, $apellidos, $clave, $estado, $tipo, $fregistro, $usercreate);
    echo "Admin creado con ID {$id}, email: {$nombres}\n";
  }
} catch (Throwable $e) {
  echo "Error: " . $e->getMessage();
}
