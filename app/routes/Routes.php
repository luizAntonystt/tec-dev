<?php

namespace app\routes;

class Routes
{
    public static function get(): array
    {
        return [
            'GET' => [
                '/' => 'LoginController@page',                      // Página inicial (login)
                '/login' => 'LoginController@page',                // Página de login (GET)
                '/register' => 'RegisterController@index',         // Página de cadastro
                '/dashboard' => 'DashboardController@index',       // Página protegida
                '/logout' => 'AuthController@logout',              // ✅ Logout corrigido
                '/home' => 'HomeController@index',

                // Recuperação de senha
                '/forgot-password' => 'AuthController@forgotPasswordPage',
                '/reset-password' => 'AuthController@resetPasswordPage',
                '/token-expirado' => 'AuthController@expiredTokenPage',
            ],

            'POST' => [
                '/auth' => 'AuthController@login',                 // ✅ Login corrigido
                '/register' => 'RegisterController@store',
                '/forgot-password' => 'AuthController@sendResetLink',
                '/reset-password' => 'AuthController@updatePassword',
            ]
        ];
    }
}
