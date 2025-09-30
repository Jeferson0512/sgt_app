<?php
require_once __DIR__ . '/../../core/Controller.php';

class DashboardController extends Controller {
//   public function index() {
//     $this->viewText("<h1>Dashboard</h1><p>Bienvenido, estás en el panel.</p>");
//   }
    public function index() {
        $this->render(__DIR__ . '/views/index.php', [
            'user' => $_SESSION['user'] ?? null
        ]);
    }
}