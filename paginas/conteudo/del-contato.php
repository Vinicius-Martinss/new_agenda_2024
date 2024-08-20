<?php 
include ('../../config/conexao.php');

if (isset($_GET['idDel'])){
    $id = $_GET['idDel'];

    // Recupera o nome da imagem do repositório
    $select = "SELECT foto_contatos FROM tb_contatos WHERE id_contatos = :id";

    try {
        $result = $conect->prepare($select);
        $result->bindValue(':id', $id, PDO::PARAM_INT);
        $result->execute();

        $contar = $result->rowCount();
        if ($contar > 0) {
            $show = $result->fetch(PDO::FETCH_ASSOC);
            $foto = $show->foto_contatos; // Correção aqui

            if ($foto != 'avatar-padrao.png') {
                // Caminho da imagem no servidor
                $filepath = "../../img/cont/" . $foto;

                // Deleta a imagem
                if (file_exists($filepath)) {
                    unlink($filepath);
                }
            }

            // Deleta o registro do banco de dados
            $delete = "DELETE FROM tb_contatos WHERE id_contatos = :id";
            try {
                $result = $conect->prepare($delete);
                $result->bindValue(':id', $id, PDO::PARAM_INT);
                $result->execute();

                if ($result->rowCount() > 0) {
                    header("Location: ../home.php");
                } else {
                    header("Location: ../home.php");
                }
            } catch (Exception $e) {
                echo '<strong>ERROR DE DELETE: </strong> ' . $e->getMessage();
            }
        } else {
            // Redirecionar se o registro não for encontrado
            header("Location: ../home.php");
        }
    } catch (PDOException $e) {
        echo '<strong>ERROR DE SELECT: </strong> ' . $e->getMessage(); // Adicionei a mensagem de erro
    }
}

