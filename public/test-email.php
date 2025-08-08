<?php
require_once __DIR__ . '/../vendor/autoload.php';  // ajuste o caminho conforme seu projeto

use app\support\Email;

try {
    $email = new Email();
    $email->to('luizdev95@gmail.com')       // coloque um e-mail válido para teste
          ->subject('Teste de envio de e-mail')
          ->message('<p>Este é um teste de envio de e-mail via PHPMailer com configurações internas.</p>')
          ->send();

    echo "E-mail enviado com sucesso!";
} catch (Exception $e) {
    echo "Erro ao enviar e-mail: " . $e->getMessage();
}
