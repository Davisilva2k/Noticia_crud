<?php
session_start();
include_once './config.php';
include_once './classes/noticias.php';
try {
    $usuario = new Usuario($db);
    $usuario = $usuario->listarTodos();
} catch (Exception $e) {
    die('erro' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <h1> Adicionar Novas Notícias</h1>
        <form action="salvarNoticias.php" method="post">
            enctype = "multipart/form-Data">
            <input type="text" name="autor">
            select name = "autor" required>
            <?php foreach ($usuario as $usuario): ?>
                <option value="<?php echo $usuario["id"]; ?>">
                    <?php echo htmlspecialchars($usuario["nome"]); ?> </option>
            <?php endforeach ?>
        </form>
    </div>
</body>

</html>