<?php

namespace app\controllers;

use app\models\User;

class LoginController
{
    public function page()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $error = $_SESSION['error'] ?? '';
        unset($_SESSION['error']);

        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function auth()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (!$email || !$password) {
            $_SESSION['error'] = 'Preencha todos os campos.';
            header('Location: /');
            exit;
        }

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user->password)) {
            $_SESSION['error'] = 'E-mail ou senha incorretos.';
            header('Location: /');
            exit;
        }

        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_name'] = $user->name;

        header('Location: /dashboard');
        exit;
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_destroy();
        header('Location: /');
        exit;
    }
}
