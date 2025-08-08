<?php

require_once __DIR__ . '/../vendor/autoload.php';

use app\support\Connection;

try {
    $db = Connection::getDb();
    echo "✅ Conectado com sucesso ao banco de dados!";
} catch (Exception $e) {
    echo "❌ Erro: " . $e->getMessage();
}
