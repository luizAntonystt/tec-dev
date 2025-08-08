<?php

namespace app\controllers;

use app\models\User;

class RegisterController
{
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['password_confirm'] ?? '';

            // Validação dos dados
            if (empty($name)) {
                $errors[] = 'O nome é obrigatório.';
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'E-mail inválido.';
            }

            if (strlen($password) < 6) {
                $errors[] = 'A senha deve ter no mínimo 6 caracteres.';
            }

            if ($password !== $confirmPassword) {
                $errors[] = 'As senhas não coincidem.';
            }

            $userModel = new User();
            if ($userModel->findByEmail($email)) {
                $errors[] = 'Este e-mail já está cadastrado.';
            }

            // Se não houver erros, cria o usuário
            if (empty($errors)) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $userModel->create([
                    'name' => $name,
                    'email' => $email,
                    'password' => $hashedPassword
                ]);

                header('Location: /');
                exit;
            }
        }

        require_once __DIR__ . '/../views/user/register.php';
    }
}
