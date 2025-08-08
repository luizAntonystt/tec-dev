<?php
// app/config/config.php

require_once __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv;

// Carrega o .env da raiz do projeto, com verificação de existência
$envPath = __DIR__ . '/../../';
if (file_exists($envPath . '.env')) {
    $dotenv = Dotenv::createImmutable($envPath);
    $dotenv->load();
}

// Define constantes a partir das variáveis do .env ou usa valores padrão
define('DB_HOST',    $_ENV['DB_HOST']    ?? 'localhost');
define('DB_NAME',    $_ENV['DB_NAME']    ?? 'nome_do_banco');
define('DB_USER',    $_ENV['DB_USER']    ?? 'usuario');
define('DB_PASS',    $_ENV['DB_PASS']    ?? 'senha');
define('DB_CHARSET', $_ENV['DB_CHARSET'] ?? 'utf8mb4');

// Define a BASE_URL usando APP_URL do .env (corrigido)
define('BASE_URL', $_ENV['APP_URL'] ?? 'http://localhost:1000');

// Ativa ou desativa modo debug
define('DEBUG', true);
