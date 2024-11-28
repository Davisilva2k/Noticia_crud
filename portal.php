<?php
session_start();
include_once './config/config.php';
include_once './classes/usuario.php';
include_once 'classes/Noticia.php';


// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}
$usuario = new Usuario($db);


// Processar exclusão de usuário
if (isset($_GET['deletar'])) {
    $id = $_GET['deletar'];
    $usuario->deletar($id);
    header('Location: portal.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $titulo = $_POST['titulo'];
        $data = $_POST['data'];
        $autor_id = $_POST['autor'];
        $noticia = $_POST['noticia'];
        $imagem = null;

        // Upload da imagem
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
                throw new Exception('Erro ao fazer upload da imagem.');
            }
        }

        // Inserir notícia no banco
        $stmt = $db->prepare("INSERT INTO noticias (titulo, data, autor_id, noticia, imagem) VALUES (:titulo, :data, :autor, :noticia, :imagem)");
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':data', $data);
        $stmt->bindParam(':autor', $autor_id);
        $stmt->bindParam(':noticia', $noticia);
        $stmt->bindParam(':imagem', $imagem);
        $stmt->execute();

        echo "Notícia cadastrada com sucesso!";
    } catch (Exception $e) {
        die('Erro ao salvar notícia: ' . $e->getMessage());
    }
}
// Obter dados do usuário logado
$dados_usuario = $usuario->lerPorId($_SESSION['usuario_id']);
$nome_usuario = $dados_usuario['nome'];
// Obter dados dos usuários
$dados = $usuario->ler();
// Função para determinar a saudação
function saudacao()
{
    $hora = date('H');
    if ($hora >= 6 && $hora < 12) {
        return "Bom dia";
    } else if ($hora >= 12 && $hora < 18) {
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./portal.css">
    <title>Document</title>
</head>

<body>
    <header id="cabecalho">
        <div><img src="img/logo_icon.png" alt=""></div>
        <div>
            <h2>GERENCIADOR DAS NOTÍCIAS</h2>
        </div>
    </header>

    <main>
        <h3 class="sub-titulo">O QUE DESEJA FAZER ??</h3>
        <div>
            <div id="botaoUmDois">
                <a href="./registrar.php">CADASTRAR<br>USUÁRIO</a>
                <a href="./consultarUsuario.php">CONSULTAR<br>USUÁRIO</a>
            </div>
            <div id="botaoTresQuatro">
                <a href="./cadastrarNoticia.php">CADASTRAR<br>NOTÍCIAS</a>
                <a href="./consultarNoticia.php">CONSULTAR<br>NOTÍCIAS</a>
            </div>
        </div>
    </main>
</body>

</html>