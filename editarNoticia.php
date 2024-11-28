<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}

include_once './config/config.php';
include_once './classes/Noticia.php';

$noticia = new Noticia($db);
// Verificar se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $data = $_POST['data'];
    $autor= $_POST['autor']; 
    $noticia_texto = $_POST['noticia'];
    $imagem= $_FILES['imagem'];
    $noticia->atualizar($id,$titulo,$data,$autor,$noticia,$imagem);
    header('Location: portal.php');
    exit();
    // Verifica se há uma imagem
    $imagem = null;
    if (!empty($_FILES['imagem']['name'])) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = basename($_FILES['imagem']['name']);
        $filePath = $uploadDir . uniqid() . '_' . $fileName;

        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $filePath)) {
            $imagem = $filePath;
        } else {
            echo '<p style="color: red;">Erro ao fazer upload da imagem.</p>';
        }
    }

    // Atualizar a notícia no banco de dados
    $noticia->atualizar($id, $titulo, $data, $autor_id, $noticia, $imagem);
    header('Location: gerenciarNoticias.php'); // Redireciona para a página de gerenciamento de notícias
    exit();
}

// Verificar se o ID da notícia foi passado via GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $row = $noticia->lerPorId($id);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Notícia</title>
</head>
<body>
    <h1>Editar Notícia</h1>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

        <label for="titulo">Título:</label>
        <input type="text" name="titulo" value="<?php echo $row['titulo']; ?>" required>
        <br><br>

        <label for="data">Data:</label>
        <input type="date" name="data" value="<?php echo $row['data']; ?>" required>
        <br><br>

        <label for="autor_id">Autor:</label>
        <input type="text" name="autor_id" value="<?php echo $row['autor']; ?>" readonly>
        <br><br>

        <label for="noticia">Notícia:</label>
        <textarea name="noticia" required><?php echo $row['noticia']; ?></textarea>
        <br><br>

        <label for="imagem">Imagem:</label>
        <input type="file" name="imagem">
        <br><br>

        <input type="submit" value="Atualizar Notícia">
    </form>
</body>
</html>
