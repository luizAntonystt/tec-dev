<?php

namespace app\core;

use app\routes\Routes;

class RoutersFilter
{
    public function get(): array
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); // tira query string
        $routes = Routes::get();

        // Verifica se rota está registrada
        if (!isset($routes[$method][$uri])) {
            // Rota não encontrada, pode lançar exceção ou retornar padrão
            return [
                'controller' => 'LoginController',
                'method' => 'page' // rota padrão
            ];
        }

        // Exemplo: 'LoginController@page'
        $controllerAction = $routes[$method][$uri];
        [$controller, $action] = explode('@', $controllerAction);

        return [
            'controller' => $controller,
            'method' => $action
        ];
    }
}
