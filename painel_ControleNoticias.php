<?php
include_once "./config/config.php";
include_once "./classes/database.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="painelControleNoticia.css">
    <title>Controle de Notícias</title>
</head>
<body>
    <header>
        <img id="logo_cabecalho" src="img/logo_icon.png" alt="logo">
        <a id="botao_sair" href="TelaPrincipal.php" class="botao-sair">SAIR</a>
    </header>
    <div class="container">
        
    <a id="botao_cadastrar" href="cadastrarNoticia.php" class="botao-login">Cadastrar Notícia</a>
    <a id="botao_gerenciarNoticia" href="gerenciarNoticias.php" class="botao-login">Gerenciar Notícias</a>
    <a id="botao_gerenciarUsuario" href="gerenciarUsuarios.php" class="botao-login">Gerenciar<br>Usuários</a>
    </div>
</body>
</html>