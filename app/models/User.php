<?php

namespace app\models;

use app\core\Connection;

class User
{
    public $id;
    public $name;
    public $email;
    public $password;

    public static function findByEmail(string $email): ?self
    {
        $db = Connection::connect();  // Usa o método connect() para pegar a conexão PDO
        $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);

        // Especifica o modo FETCH_ASSOC para retornar array associativo
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        $user = new self();
        $user->id = $data['id'];
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = $data['password'];

        return $user;
    }

    public function updatePassword(string $newPassword): void
    {
        $db = Connection::connect();

        $hash = password_hash($newPassword, PASSWORD_DEFAULT);

        $stmt = $db->prepare("UPDATE users SET password = :password WHERE id = :id");
        $stmt->execute([
            'password' => $hash,
            'id' => $this->id
        ]);
    }
}
