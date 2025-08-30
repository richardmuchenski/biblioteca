<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Garante que apenas administradores acessem esta página
requireRole('admin'); 
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard do Administrador</title>
    <style>
        body { font-family: sans-serif; }
        .container { width: 80%; margin: auto; }
        nav ul { list-style-type: none; padding: 0; }
        nav ul li { display: inline; margin-right: 20px; }
        nav a { text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Painel de Controle do Administrador</h1>
        <p>Olá, Admin <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Admin'); ?>.</p>
        
        <nav>
            <ul>
                <li><a href="/loans">Gerenciar Empréstimos</a></li>
                <li><a href="/books">Gerenciar Livros</a></li>
                <li><a href="/users">Gerenciar Usuários</a></li>
                <li><a href="/reports">Gerar Relatórios</a></li>
                <li><a href="/logout">Sair</a></li>
            </ul>
        </nav>

        <hr>

        <h2>Ações Rápidas</h2>
        <p>Aqui você pode gerenciar todas as áreas do sistema.</p>
        </div>
</body>
</html>