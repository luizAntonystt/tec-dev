<?php

namespace app\core;

use PDO;
use PDOException;

class Connection
{
    public static function connect()
    {
        try {
            $host = 'localhost';
            $db   = 'sistema_login';
            $user = 'root';
            $pass = '';
            $charset = 'utf8mb4';

            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
                PDO::ATTR_PERSISTENT         => false, // <- aqui garante que cada requisição usa uma conexão nova
            ];

            return new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            die('Erro de conexão: ' . $e->getMessage());
        }
    }
}
