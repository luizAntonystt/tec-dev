<?php
namespace app\middleware;

use app\core\Auth;

class AuthMiddleware
{
    // Protege rotas privadas
    public static function authOnly()
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';

        $publicRoutes = [
            '/login',
            '/register',
            '/', // Caso você use register como página inicial
        ];

        if (!in_array($uri, $publicRoutes)) {
            Auth::check(); // Protege rota
        }
    }

    // Evita que usuários logados acessem login ou cadastro
    public static function guestOnly()
    {
        session_start();
        if (isset($_SESSION['user_id'])) {
            header("Location: /dashboard");
            exit;
        }
    }
}
