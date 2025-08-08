<?php

use app\core\RoutersFilter;
use Dotenv\Dotenv;

// ✅ Carrega o autoload do Composer
require_once __DIR__ . '/../vendor/autoload.php';

// ✅ Carrega variáveis do .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// ✅ Inclui configurações e constantes adicionais (se houver)
require_once __DIR__ . '/../app/config/config.php';

// ✅ Inicia sessão, se necessário
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ✅ Roteamento
$router = new RoutersFilter();
$route = $router->get();

$controllerName = 'app\\controllers\\' . $route['controller'];
$method = $route['method'];

if (class_exists($controllerName)) {
    $controller = new $controllerName();

    if (method_exists($controller, $method)) {
        $controller->$method();
    } else {
        echo "Método {$method} não encontrado.";
    }
} else {
    echo "Controller {$controllerName} não encontrado.";
}
