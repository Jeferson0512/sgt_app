<?php
require_once __DIR__ . '/../core/Database.php';

class UserModel {
  private $pdo;

  public function __construct() {
    $this->pdo = Database::conn();
  }

  public function findByEmail(string $usuario) {
    // $sql = "SELECT id, name, email, password_hash, role, status FROM users WHERE email = ? LIMIT 1"; //DB SGT_DB
    $sql = "SELECT codigo, CONCAT(nombres, ' ', apellidos) AS nombres_completo, nombres, apellidos, usuario, clave, tipo, estado FROM usuarios WHERE usuario = ? LIMIT 1"; // DB SGT
    $st  = $this->pdo->prepare($sql);
    $st->execute([$usuario]);
    return $st->fetch(); // array o false
  }

  public function create(string $name, string $email, string $password, string $role='admin') {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    // $sql  = "INSERT INTO users (name, email, password_hash, role, status) VALUES (?, ?, ?, ?, 1)"; // DB SGT_DB
    $sql = "INSERT INTO usuarios (name, usuario, clave, tipo, estado) VALUES (?, ?, ?, ?, 1)"; // DB SGT
    $st   = $this->pdo->prepare($sql);
    $st->execute([$name, $email, $hash, $role]);
    return (int)$this->pdo->lastInsertId();
  }


  public function createSGT(string $codigo, string $usuario, string $nombres, string $apellidos, string $clave, string $estado, string $tipo, string $fregistro, string $usercreate) {
    $hash = password_hash($clave, PASSWORD_DEFAULT);
    // $sql  = "INSERT INTO users (name, email, password_hash, role, status) VALUES (?, ?, ?, ?, 1)"; // DB SGT_DB
    $sql = "INSERT INTO usuarios(codigo, usuario, nombres, apellidos, clave, estado, tipo, fregistro, usercreate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"; // DB SGT
    $st   = $this->pdo->prepare($sql);
    $st->execute([$codigo, $usuario, $nombres, $apellidos, $hash, $estado, $tipo, $fregistro, $usercreate]);
    return $codigo;
  }
  public function verifyCredentials(string $email, string $password) {
    $row = $this->findByEmail($email);
    if (!$row || (int)$row['estado'] !== 1) return false;
    if (!password_verify($password, $row['clave'])) return false;
    // Devolver datos sin el hash
    unset($row['clave']);
    return $row;
  }

  // public function verifyCredentials(string $email, string $password) {
  //   $row = $this->findByEmail($email);
  //   if (!$row || (int)$row['status'] !== 1) return false;
  //   if (!password_verify($password, $row['password_hash'])) return false;
  //   // Devolver datos sin el hash
  //   unset($row['password_hash']);
  //   return $row;
  // }
}
