<?php
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../../../config/config.php';

final class PreventivosController extends Controller
{
    public function index()
    {
        $this->render(__DIR__ . '/views/index.php');
    }
}
