<?php

namespace app\models;

use app\core\Connection;
use PDO;

class PasswordReset
{
    public static function generateToken(string $email): ?string
    {
        // Verifica se o usuário existe
        $user = User::findByEmail($email);
        if (!$user) return null;

        $token = bin2hex(random_bytes(32));
        $expires = time() + 3600; // 1 hora

        $pdo = Connection::connect();

        // Remove tokens antigos para o mesmo user_id
        $stmtDelete = $pdo->prepare("DELETE FROM password_resets WHERE user_id = ?");
        $stmtDelete->execute([$user->id]);

        // Insere novo token
        $stmtInsert = $pdo->prepare("
            INSERT INTO password_resets (email, user_id, token, expires_at, created_at)
            VALUES (?, ?, ?, ?, NOW())
        ");
        $stmtInsert->execute([$email, $user->id, $token, $expires]);

        return $token;
    }

    public static function isValidToken(string $token): bool
    {
        $pdo = Connection::connect();

        $stmt = $pdo->prepare("SELECT expires_at FROM password_resets WHERE token = ? LIMIT 1");
        $stmt->execute([$token]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row && (int)$row['expires_at'] >= time();
    }

    public static function getEmailByToken(string $token): ?string
    {
        $pdo = Connection::connect();

        $stmt = $pdo->prepare("SELECT email FROM password_resets WHERE token = ? LIMIT 1");
        $stmt->execute([$token]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['email'] ?? null;
    }

    public static function invalidateToken(string $token): void
    {
        $pdo = Connection::connect();

        $stmt = $pdo->prepare("DELETE FROM password_resets WHERE token = ?");
        $stmt->execute([$token]);
    }
}
