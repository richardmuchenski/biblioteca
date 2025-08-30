<?php
// Garante que a sessão foi iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard do Administrador</title>
</head>
<body>
    <h1>Painel de Controle do Administrador</h1>
    <p>Olá, Admin <?php echo htmlspecialchars($_SESSION['user']); ?>.</p>
    <p>Aqui você pode gerenciar usuários, livros e outras configurações do sistema.</p>
    <a href="/logout">Sair</a>
</body>
</html>