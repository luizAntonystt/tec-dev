<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);

$token = $_GET['token'] ?? '';
if (!$token) {
    echo "Token inválido.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Redefinir Senha</title>
    <style>
        /* (mesmo CSS do exemplo anterior) */
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f2f4f8;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h2 {
            margin-bottom: 25px;
            color: #333;
            font-weight: 600;
        }

        label {
            display: block;
            text-align: left;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
            font-size: 14px;
        }

        input[type="password"] {
            width: 100%;
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 16px;
            margin-bottom: 20px;
            transition: border-color 0.3s ease;
        }

        input[type="password"]:focus {
            border-color: #007bff;
            outline: none;
        }

        button {
            width: 100%;
            background-color: #007bff;
            color: white;
            padding: 14px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        .alert {
            padding: 12px 15px;
            margin-bottom: 20px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            color: #842029;
            background-color: #f8d7da;
            border: 1px solid #f5c2c7;
            text-align: left;
        }

        .error-message {
            color: red;
            font-size: 14px;
            margin-bottom: 20px;
            display: none;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Redefinir Senha</h2>

        <?php if ($error): ?>
            <div class="alert"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form id="resetForm" action="/reset-password" method="POST" onsubmit="return validatePasswords()">

            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

            <label for="password">Nova senha:</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm">Confirmar senha:</label>
            <input type="password" id="confirm" name="confirm" required>

            <div class="error-message" id="password-error">As senhas não coincidem.</div>

            <button type="submit">Atualizar senha</button>
        </form>
    </div>

    <script>
        function validatePasswords() {
            const password = document.getElementById('password').value.trim();
            const confirm = document.getElementById('confirm').value.trim();
            const errorDiv = document.getElementById('password-error');

            if (password !== confirm) {
                errorDiv.style.display = 'block';
                return false; // bloqueia o envio
            }

            errorDiv.style.display = 'none';
            return true; // permite envio
        }
    </script>
</body>
</html>
