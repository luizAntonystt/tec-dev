<?php

namespace app\controllers;

use app\core\Connection; // Sua classe de conexão PDO
use PDO;

class RegisterController
{
    public function index()
    {
        // Exibe a página de registro
        require_once __DIR__ . '/../views/user/register.php';
    }

    public function store()
    {
        // Evita aviso caso a sessão já esteja iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $password_confirm = $_POST['password_confirm'] ?? '';

        $errors = [];

        // Validações básicas
        if (!$name) {
            $errors[] = "O nome é obrigatório.";
        }

        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "E-mail inválido.";
        }

        if (!$password) {
            $errors[] = "A senha é obrigatória.";
        }

        if ($password !== $password_confirm) {
            $errors[] = "As senhas não coincidem.";
        }

        if ($errors) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = ['name' => $name, 'email' => $email];
            header('Location: /register');
            exit;
        }

        // Corrija aqui: usando o método correto para obter o PDO
        $pdo = Connection::connect(); // <<< Use o método correto definido na sua Connection.php

        // Verifica se o e-mail já existe
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $_SESSION['errors'] = ["E-mail já cadastrado."];
            $_SESSION['old'] = ['name' => $name, 'email' => $email];
            header('Location: /register');
            exit;
        }

        // Insere usuário com senha hash
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$name, $email, $hash]);

        $_SESSION['success'] = "Cadastro realizado com sucesso. Faça login!";
        header('Location: /login');
        exit;
    }
}
