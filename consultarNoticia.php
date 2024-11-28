<?php
session_start();
include_once './config/config.php';
include_once './classes/Noticia.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}


$usuario = new Noticia($db);

// Processar exclusão de notícia
if (isset($_GET['deletar'])) {
    $id = $_GET['deletar'];
    $usuario->deletar($id);
    header('Location: portal.php');
    exit();
}

// Obter dados do usuário logado
$dados_usuario = $usuario->lerPorId($_SESSION['usuario_id']);
$nome_usuario =  $_SESSION['usuario_nome'];

// Obter dados das notícias
$dados = $usuario->ler();

// Função para determinar a saudação
function saudacao() {
    $hora = date('H');
    if ($hora >= 6 && $hora < 12) {
        return "Bom dia";
    } elseif ($hora >= 12 && $hora < 18) {
        return "Boa tarde";
    } else {
        return "Boa noite";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Portal</title>
    <link rel="stylesheet" href="./ConsultarNoticia.css">
</head>
<body>
    <h1><?php echo saudacao() . ", " . $nome_usuario; ?>!</h1>
    <a href="cadastrarNoticia.php">Adicionar Notícia</a>
    <a href="logout.php">Logout</a>
    <br>
    
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Data</th>
            <th>Autor</th>
            <th>Notícia</th>
            <th>Imagem</th>
            <th>Ações</th>
        </tr>
        <?php while ($row = $dados->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['titulo']; ?></td>
                <td><?php echo $row['data']; ?></td>
                <td><?php echo $row['autor']; ?></td>
                <td><?php echo $row['noticia']; ?></td>
                <td>
                    <!-- Exibir a imagem utilizando a tag <img> -->
                    <img src="<?php echo $row['imagem']; ?>" alt="Imagem da notícia" width="100">
                </td>
                <td>
                    <!-- Links de edição e exclusão -->
                    <a href="editarNoticia.php?id=<?php echo $row['id']; ?>">Editar</a>
                    <a href="consultarNoticia.php?deletar=<?php echo $row['id']; ?>">Deletar</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
