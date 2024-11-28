<?php
include_once './config/config.php';

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
?>
