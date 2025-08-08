<?php

namespace app\core;

use app\core\RoutersFilter;

class Router
{
    public static function run()
    {
        try {
            $routerRegistered = new RoutersFilter();
            $route = $routerRegistered->get();

            $controllerName = 'app\\controllers\\' . $route['controller'];
            $methodName = $route['method'];

            if (!class_exists($controllerName)) {
                throw new \Exception("Controller {$controllerName} não encontrado.");
            }

            $controller = new $controllerName();

            if (!method_exists($controller, $methodName)) {
                throw new \Exception("Método {$methodName} não encontrado no controller {$controllerName}.");
            }

            call_user_func([$controller, $methodName]);

        } catch (\Throwable $th) {
            http_response_code(500);
            echo "Erro no roteamento: " . $th->getMessage();
        }
    }
}
