<?php

namespace App\Controllers;

use App\Models\PlanningModel;

class PlanningController {
    public function index() {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $planningModel = new PlanningModel();
        $year = date('Y');
        if (isset($_POST['year'])) {
            $year = intval($_POST['year']);
        }

        $weeks = $planningModel->getWeeks($year);
        $savedData = $planningModel->getSavedData();
        $userCount = $planningModel->getUserStatistics();

        include __DIR__ . '/../Views/planning/index.php';
    }
}
