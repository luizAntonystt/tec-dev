<?php

namespace app\controllers;

require_once __DIR__ . '/../models/middlewares.php';

class DashboardController
{
    public function index()
    {
        authMiddleware(); // Protege a rota

        $userName = $_SESSION['user_name'] ?? 'Usuário';

        require_once __DIR__ . '/../views/index/dashboard.php';
    }
}
