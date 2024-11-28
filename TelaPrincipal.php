<?php
include_once './config/config.php'; // Conexão com o banco de dados
include_once './classes/Noticia.php'; // Classe Notícia

// Criar uma instância da classe Noticia
$database = new Database();
$db = $database->getConnection();
$noticia = new Noticia($db);

// Usando o método select() para recuperar as últimas notícias
$query = "SELECT * FROM noticias ORDER BY data DESC LIMIT 5"; // Buscar as 5 notícias mais recentes
$stmt = $db->prepare($query);
$stmt->execute();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./TelaPrincipal.css">
    <title>PORTAL DE NOTÍCIAS</title>
</head>

<body>
    <header>
        <img id="logo_cabecalho" src="img/logo_icon.png" alt="logo">
        <a id="botao_login" href="login.php" class="botao-login">Login</a>
    </header>

    <div class="container">
        <?php
        // Verifica se há notícias
        if ($stmt->rowCount() > 0) {
            // Percorre as notícias e exibe
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<div class='noticia'>
                        <h2>" . htmlspecialchars($row['titulo']) . "</h2>
                        <p class='data-autor'>Publicado em " . date("d/m/Y", strtotime($row['data'])) . " por " . htmlspecialchars($row['autor']) . "</p>
                        <img src='" . htmlspecialchars($row['imagem']) . "' alt='Imagem da Notícia'>
                        <p>" . htmlspecialchars($row['noticia']) . "</p>
                    </div>";
            }
        } else {
            echo "<p>Não há notícias cadastradas no momento.</p>";
        }
        ?>
    </div>

    <footer>
        <p>&copy; 2024 Portal de Notícias</p>
    </footer>
</body>

</html>