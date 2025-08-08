<?php

namespace app\controllers;

use app\models\User;
use app\models\PasswordReset;
use app\support\Email;
use const BASE_URL;

class AuthController
{
    public function forgotPasswordPage()
    {
        require_once __DIR__ . '/../views/auth/forgot-password.php';
    }

    public function sendResetLink()
    {
        $email = $_POST['email'] ?? '';

        if (!$email) {
            $_SESSION['error'] = 'E-mail é obrigatório.';
            header('Location: /forgot-password');
            exit;
        }

        // Verifica se o usuário existe
        $user = User::findByEmail($email);
        if (!$user) {
            $_SESSION['error'] = 'E-mail não encontrado.';
            header('Location: /forgot-password');
            exit;
        }

        // Gera token e expiração
        $token = bin2hex(random_bytes(32));
        $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Gera token e salva no banco
        $token = PasswordReset::generateToken($email);


        // Link para redefinir a senha
        $resetLink = BASE_URL . "/reset-password?token={$token}";

        // Envio do e-mail
        $mail = new Email();
        $sent = $mail->to($email)
            ->subject('Redefinição de senha')
            ->message("
                <p>Olá!</p>
                <p>Recebemos uma solicitação para redefinir sua senha. Clique no link abaixo para prosseguir:</p>
                <p><a href='{$resetLink}'>Redefinir senha</a></p>
                <p>Se você não fez essa solicitação, ignore este e-mail.</p>
                <p>Este link é válido por 1 hora.</p>
            ")
            ->send();

        if ($sent) {
            $_SESSION['success'] = 'Link de redefinição enviado para seu e-mail.';
        } else {
            $_SESSION['error'] = 'Erro ao enviar o e-mail. Verifique as configurações SMTP.';
        }

        header('Location: /forgot-password');
        exit;
    }

    public function resetPasswordPage()
    {
        $token = $_GET['token'] ?? '';

        if (!$token || !PasswordReset::isValidToken($token)) {
            header('Location: /token-expirado');
            exit;
        }

        require_once __DIR__ . '/../views/auth/reset-password.php';
    }

    public function updatePassword()
    {
        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['confirm'] ?? '';

        if (!$token || !PasswordReset::isValidToken($token)) {
            header('Location: /token-expirado');
            exit;
        }

        if (empty($password) || empty($confirm)) {
            $_SESSION['error'] = 'Preencha todos os campos.';
            header("Location: /reset-password?token=$token");
            exit;
        }

        if ($password !== $confirm) {
            $_SESSION['error'] = 'As senhas não coincidem.';
            header("Location: /reset-password?token=$token");
            exit;
        }

        $email = PasswordReset::getEmailByToken($token);
        $user = User::findByEmail($email);

        if (!$user) {
            $_SESSION['error'] = 'Usuário não encontrado.';
            header("Location: /reset-password?token=$token");
            exit;
        }

        $user->updatePassword($password);
        PasswordReset::invalidateToken($token);

        $_SESSION['success'] = 'Senha atualizada com sucesso. Faça login.';
        header('Location: /');
        exit;
    }

    public function expiredTokenPage()
    {
        require_once __DIR__ . '/../views/auth/token-expirado.php';
    }

    public function login()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $_SESSION['error'] = 'Preencha todos os campos.';
            header('Location: /login');
            exit;
        }

        $user = User::findByEmail($email);

        if (!$user || !password_verify($password, $user->password)) {
            $_SESSION['error'] = 'E-mail ou senha inválidos.';
            header('Location: /login');
            exit;
        }

        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_name'] = $user->name;
        $_SESSION['access_token'] = bin2hex(random_bytes(32));
        $_SESSION['token_created_at'] = time();

        header('Location: /dashboard');
        exit;
    }
}
