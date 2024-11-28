<?php
session_start();
include_once './config/config.php';
include_once './classes/Noticia.php';

date_default_timezone_set('America/Sao_Paulo'); // Ajustar fuso horário

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}


// Instanciar a classe Noticia
$noticia = new Noticia($db);

// Processar exclusão de notícia
if (isset($_GET['deletar'])) {
    try {
        $id = $_GET['deletar'];
        $noticia->deletar($id);
        header('Location: TelaPrincipal.php');
        exit();
    } catch (Exception $e) {
        echo '<p style="color: red;">Erro ao excluir notícia: ' . $e->getMessage() . '</p>';
    }
}

// Obter todas as notícias
$dados = $noticia->ler();

// Função para saudação
function saudacao() {
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
    <title>Gerenciar Notícias</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1><?php echo saudacao(); ?>, bem-vindo(a)!</h1>
    <h1>Gerenciar Notícias</h1>
    <a href="cadastrarNoticia.php">Cadastrar Nova Notícia</a>
    <a href="logout.php">Logout</a>
    <br><br>

    <table>
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
                <td><?php echo htmlspecialchars($row['titulo']); ?></td>
                <td><?php echo date('d/m/Y', strtotime($row['data'])); ?></td>
                <td><?php echo htmlspecialchars($row['autor']); ?></td>
                <td><?php echo htmlspecialchars($row['noticia']); ?></td>
                <td>
                    <?php if (!empty($row['imagem'])): ?>
                        <img src="<?php echo htmlspecialchars($row['imagem']); ?>" alt="Imagem" width="100">
                    <?php else: ?>
                        Sem imagem
                    <?php endif; ?>
                </td>
                <td>
                    <a href="editarNoticia.php?id=<?php echo $row['id']; ?>">Editar</a>
                    <a href="TelaPrincipal.php?deletar=<?php echo $row['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir esta notícia?');">Excluir</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
