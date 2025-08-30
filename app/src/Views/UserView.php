<?php
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login e Registro</title>
</head>
<body>

    <h1>Login</h1>
    <form method="POST" action="/login">
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" required>
        <br>
        <label for="password">Senha:</label>
        <input type="password" id="password" name="senha" required>
        <br>
        <button type="submit">Entrar</button>
    </form>

    <hr>

    <h1>Registrar</h1>
    <form method="POST" action="/register">
        <label for="reg_nome">Nome:</label>
        <input type="text" id="reg_nome" name="nome" required>
        <br>
        <label for="reg_email">Email:</label>
        <input type="email" id="reg_email" name="email" required>
        <br>
        <label for="reg_senha">Senha:</label>
        <input type="password" id="reg_senha" name="senha" required>
        <br>
        <label for="reg_telefone">Telefone:</label>
        <input type="text" id="reg_telefone" name="telefone" required>
        <br>
        <label for="reg_cpf">CPF:</label>
        <input type="text" id="reg_cpf" name="cpf" required>
        <br>
        <button type="submit">Registrar</button>
    </form>

</body>
</html>