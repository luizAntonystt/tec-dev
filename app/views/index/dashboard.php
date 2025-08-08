<?php
// Iniciar sessão se ainda não estiver ativa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Impede que o navegador armazene cache da página
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Verificação de sessão ativa
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit;
}

// Verificação de token e tempo de sessão
if (!isset($_SESSION['access_token']) || !isset($_SESSION['token_created_at'])) {
    session_destroy();
    header('Location: /login?expired=1');
    exit;
}

// Tempo de expiração (segundos)
$tempoExpiracao = 60;
$agora = time();

// Verifica se o tempo expirou
if (($agora - $_SESSION['token_created_at']) > $tempoExpiracao) {
    session_destroy();
    header('Location: /login?expired=1');
    exit;
}

// Tempo restante para exibir no JavaScript
$tempoRestante = $tempoExpiracao - ($agora - $_SESSION['token_created_at']);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <script>
        let tempoRestante = <?= $tempoRestante ?>;

        const countdown = setInterval(() => {
            tempoRestante--;

            if (tempoRestante <= 0) {
                clearInterval(countdown);
                alert("Sessão expirada. Você será redirecionado para o login.");
                window.location.href = "/login?expired=1";
            }
        }, 1000);
    </script>
    <style>
        :root {
            --primary-color: #2d98da;
            --accent-color: #1e272e;
            --background-color: #f4f6f8;
            --card-color: #ffffff;
            --danger-color: #e74c3c;
            --text-color: #333;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Roboto, sans-serif;
            display: flex;
            height: 100vh;
            background-color: var(--background-color);
            color: var(--text-color);
        }

        .sidebar {
            width: 240px;
            background-color: var(--primary-color);
            color: #fff;
            display: flex;
            flex-direction: column;
            padding: 30px 20px;
        }

        .sidebar h2 { font-size: 22px; margin-bottom: 30px; }
        .sidebar a {
            color: #fff;
            text-decoration: none;
            margin: 12px 0;
            padding: 10px 15px;
            border-radius: 6px;
            transition: background-color 0.2s;
        }

        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        header {
            background-color: #fff;
            padding: 20px 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        header h1 { font-size: 24px; }

        main {
            flex: 1;
            padding: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .dashboard-card {
            background-color: var(--card-color);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            text-align: center;
            max-width: 500px;
            width: 100%;
        }

        .dashboard-card h2 { font-size: 24px; margin-bottom: 10px; }

        .dashboard-card p {
            font-size: 16px;
            color: #666;
            margin-bottom: 30px;
        }

        .logout-button {
            background-color: var(--danger-color);
            color: #fff;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .logout-button:hover {
            background-color: #c0392b;
        }

        footer {
            background-color: #ecf0f1;
            text-align: center;
            padding: 15px;
            font-size: 14px;
            color: #777;
        }

        @media (max-width: 768px) {
            .sidebar { display: none; }
            .main-content { margin-left: 0; }
            main { padding: 20px; }
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>Menu</h2>
        <a href="/dashboard">🏠 Dashboard</a>
        <a href="/profile">👤 Perfil</a>
        <a href="/settings">⚙️ Configurações</a>
        <a href="/logout" class="logout-button" style="margin-top: auto;">🚪 Sair</a>
    </div>

    <div class="main-content">
        <header>
            <h1>Painel do Usuário</h1>
        </header>

        <main>
            <div class="dashboard-card">
                <h2>Olá, <?= htmlspecialchars($_SESSION['user_name']) ?> 👋</h2>
                <p>Seja bem-vindo(a) ao seu painel. Você está logado com sucesso!</p>
            </div>
        </main>

        <footer>
            &copy; <?= date("Y") ?> TecDev. Todos os direitos reservados.
        </footer>
    </div>

</body>
</html>
