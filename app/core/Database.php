<?php

namespace app\core;

use PDO;
use PDOException;

class Database
{
    private $pdo;

    public function __construct()
    {
        $host = 'localhost';       // ajuste conforme seu ambiente
        $dbname = 'sistema-login';      // nome do seu banco de dados
        $user = 'root';            // usuário do banco
        $pass = '';                // senha do banco

        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erro de conexão: " . $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->pdo;
    }
}
