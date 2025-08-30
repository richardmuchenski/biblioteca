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
    <title>Dashboard do Usuário</title>
</head>
<body>
    <h1>Bem-vindo ao seu Dashboard, Usuário!</h1>
    <p>Olá, <?php echo htmlspecialchars($_SESSION['user']); ?>.</p>
    <p>Aqui você pode ver suas informações e atividades.</p>
    <a href="/logout">Sair</a>
</body>
</html>