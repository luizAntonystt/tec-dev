<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];

unset($_SESSION['errors'], $_SESSION['old']);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Cadastro de Usuário</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: #fff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 15px;
            color: #555;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-top: 5px;
            font-size: 14px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            background-color: #007bff;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        ul {
            padding-left: 20px;
            color: red;
            margin-bottom: 20px;
        }

        ul li {
            font-size: 14px;
        }

        .login-link {
            text-align: center;
            margin-top: 15px;
        }

        .login-link a {
            color: #007bff;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Cadastro de Usuário</h1>

        <?php if (!empty($errors)): ?>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <form method="post" action="/register" onsubmit="return validatePasswords()">
            <label>Nome:
                <input type="text" name="name" value="<?= htmlspecialchars($old['name'] ?? '') ?>" required />
            </label>

            <label>Email:
                <input type="email" name="email" value="<?= htmlspecialchars($old['email'] ?? '') ?>" required />
            </label>

            <label>Senha:
                <input type="password" id="password" name="password" required />
            </label>

            <label>Confirmar Senha:
                <input type="password" id="confirm_password" name="password_confirm" required />
            </label>

            <div class="error-message" id="password-error">As senhas não coincidem.</div>

            <button type="submit">Cadastrar</button>
        </form>

        <div class="login-link">
            <a href="/login">Já tem uma conta? Entrar</a>
        </div>
    </div>

    <script>
        function validatePasswords() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const errorDiv = document.getElementById('password-error');

            if (password !== confirmPassword) {
                errorDiv.style.display = 'block';
                return false; // Impede envio do formulário
            }

            errorDiv.style.display = 'none';
            return true; // Permite envio
        }
    </script>
</body>
</html>
