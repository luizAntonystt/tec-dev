<?php
namespace app\support;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email
{
    private $to;
    private $subject;
    private $body;

    private $mailHost = 'smtp.gmail.com';
    private $mailPort = 587;
    private $mailUsername = 'luizdev95@gmail.com';         // Seu e-mail Gmail
    private $mailPassword = '';       // Sua senha de app do Gmail
    private $mailEncryption = 'tls';                        // TLS é padrão para porta 587
    private $mailFromAddress = 'luizdev95@gmail.com';      // Mesmo e-mail remetente
    private $mailFromName = 'Sistema Login';                // Nome do remetente

    public function to($to)
    {
        $this->to = $to;
        return $this;
    }

    public function subject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    public function message($message)
    {
        $this->body = $message;
        return $this;
    }

    public function send()
    {
        if (!$this->mailFromAddress || !$this->mailFromName) {
            throw new \Exception("❌ MAIL_FROM_ADDRESS ou MAIL_FROM_NAME não definidos na classe Email.");
        }

        $mail = new PHPMailer(true);

        try {
            // Ativa o debug para ajudar a diagnosticar problemas SMTP
            $mail->SMTPDebug = 2;           // Você pode usar 0 para desativar debug depois
            $mail->Debugoutput = 'html';    // Saída legível no navegador

            $mail->isSMTP();
            $mail->Host       = $this->mailHost;
            $mail->SMTPAuth   = true;
            $mail->Username   = $this->mailUsername;
            $mail->Password   = $this->mailPassword;

            // Use constante do PHPMailer para maior segurança e clareza
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = $this->mailPort;

            $mail->setFrom($this->mailFromAddress, $this->mailFromName);
            $mail->addAddress($this->to);

            $mail->isHTML(true);
            $mail->Subject = $this->subject;
            $mail->Body    = $this->body;

            $mail->send();
            return true;
        } catch (Exception $e) {
            throw new \Exception("Erro ao enviar e-mail: {$mail->ErrorInfo}");
        }
    }
}
