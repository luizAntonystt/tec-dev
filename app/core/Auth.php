<?php
namespace app\core;

class Auth
{
    public static function check()
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
    }
}
