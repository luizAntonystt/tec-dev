<?php


// Captura e limpa a mensagem de erro da sessão, se houver
$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <title>Login</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f0f0; }
        .login-container {
            width: 320px; margin: 80px auto; padding: 20px;
            background: #fff; border-radius: 5px; box-shadow: 0 0 10px #ccc;
        }
        .error {
            color: #b00020; background: #fdd; padding: 10px; margin-bottom: 15px; border-radius: 3px;
        }
        label, input {
            display: block; width: 100%; margin-bottom: 10px;
        }
        input[type="text"], input[type="password"] {
            padding: 8px; border: 1px solid #ccc; border-radius: 3px;
        }
        input[type="submit"] {
            background: #28a745; color: white; border: none;
            padding: 10px; border-radius: 3px; cursor: pointer;
        }
        input[type="submit"]:hover {
            background: #218838;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Login</h2>

    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="/auth" method="post">
        <label for="username">Usuário:</label>
        <input type="text" id="username" name="username" required autofocus />

        <label for="password">Senha:</label>
        <input type="password" id="password" name="password" required />

        <input type="submit" value="Entrar" />
    </form>
</div>

</body>
</html>
