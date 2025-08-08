<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // Garante que o usuário está logado
        Auth::check();

        // Renderiza a view 'views/index/home.php'
        $this->view('index/home.php');
    }
}
