<?php

class Router {
  public static function dispatch($url) {
    $url = trim($url, '/');
    if ($url === '') { $url = 'dashboard'; } // default

    $parts = explode('/', $url);
    $module = strtolower($parts[0] ?? 'dashboard');
    $action = strtolower($parts[1] ?? 'index');

    $controllerClass = ucfirst($module) . 'Controller';
    $controllerFile  = __DIR__ . '/../modules/' . $module . '/' . $controllerClass . '.php';

    if (!file_exists($controllerFile)) {
      http_response_code(404);
      echo "<h1>404</h1><p>Controlador no encontrado: $module</p>";
      return;
    }
    require_once $controllerFile;
    if (!class_exists($controllerClass) || !method_exists($controllerClass, $action)) {
      http_response_code(404);
      echo "<h1>404</h1><p>Acción no encontrada: $module/$action</p>";
      return;
    }

    $ctrl = new $controllerClass();
    $ctrl->$action();
  }
}