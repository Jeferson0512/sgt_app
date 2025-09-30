<?php
require_once __DIR__ . '/../../config/config.php';

class Database {
  private static $pdo = null;

  public static function conn() {
    if (self::$pdo === null) {
      $dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHARSET;
      $opt = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      ];
      try {
        self::$pdo = new PDO($dsn, DB_USER, DB_PASS, $opt);
      } catch (PDOException $e) {
        // Muestra un error claro (en producción podrías loguearlo)
        die('Error de conexión DB: ' . $e->getMessage());
      }
    }
    return self::$pdo;
  }
}
