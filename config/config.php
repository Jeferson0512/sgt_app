<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Usa exactamente el nombre de carpeta que creaste:
define('BASE_PATH', '/sgt_app/');
define('BASE_URL', 'http://localhost' . BASE_PATH);

// DB (aún no usamos, pero ya lo dejamos preparado)
define('DB_HOST', 'localhost');
// define('DB_NAME', 'sgt_db'); // Base de datos 
define('DB_NAME', 'sgt'); //Base de datos de PROVIAS
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');
