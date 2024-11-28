<?php
include_once './config/config.php';
include_once './classes/usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuarios = new Usuario($db);
    $nome = $_POST['nome'];
    $sexo = $_POST['sexo'];
    $fone = $_POST['fone'];
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL); // Sanitize email
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Hashing senha
    $usuarios->criar($nome, $sexo, $fone, $email, $senha);
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./registrarUsuario.css">
    <title>Cadastrar Usuário</title>
</head>
<body>
    <form method="POST" action="">
    <h1>Cadastro de Usuário</h1>

        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>
        <br><br>

        <label for="fone">Telefone:</label>
        <input type="text" id="fone" name="fone" required>
        <br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br><br>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>

        <label>Sexo:</label><br>
        <label for="masculino">
            <input type="radio" id="masculino" name="sexo" value="M" required> Masculino
        </label> 
        <label for="feminino">
            <input type="radio" id="feminino" name="sexo" value="F" required> Feminino
        </label>
        <br><br>

        <input type="submit" value="ADICIONAR">
        <input type="button" value="VOLTAR" onclick="history.back()">
    </form>
</body>
</html>
