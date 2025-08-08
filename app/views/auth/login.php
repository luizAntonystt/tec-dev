<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f0f0;
        }

        .login-container {
            width: 320px;
            margin: 80px auto;
            padding: 20px;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px #ccc;
        }

        .error {
            color: #b00020;
            background: #fdd;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 3px;
        }

        label, input {
            display: block;
            width: 100%;
            margin-bottom: 10px;
        }

        input[type="email"],
        input[type="password"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        input[type="submit"] {
            background: #28a745;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 3px;
            cursor: pointer;
            margin-top: 10px;
        }

        input[type="submit"]:hover {
            background: #218838;
        }

        .links {
            margin-top: 15px;
            text-align: center;
        }

        .links a {
            color: #007bff;
            text-decoration: none;
            display: block;
            margin: 5px 0;
        }

        .links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="login-container">
    <center><h2>Login</h2></center> 

    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if (isset($_GET['expired']) && $_GET['expired'] == 1): ?>
        <div class="error">Sessão expirada. Faça login novamente.</div>
    <?php endif; ?>

    <form action="/auth" method="post">
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required autofocus />

        <label for="password">Senha:</label>
        <input type="password" id="password" name="password" required />

        <input type="submit" value="Entrar" />
    </form>

    <div class="links">
        <a href="/forgot-password">Esqueceu sua senha?</a>
        <a href="/register">Cadastrar-se</a>
    </div>
</div>



</body>
</html>
