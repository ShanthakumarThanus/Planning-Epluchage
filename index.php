<?php
require __DIR__ . '/vendor/autoload.php';

use App\Controllers\AuthController;
use App\Controllers\PlanningController;

// Définir une route simple pour rediriger selon les actions
$page = $_GET['page'] ?? 'login';

switch ($page) {
    case 'planning':
        $controller = new PlanningController();
        $controller->index();
        break;

    case 'register':
        $controller = new AuthController();
        $controller->register();
        break;

    case 'login':
    default:
        $controller = new AuthController();
        $controller->login();
        break;
}
