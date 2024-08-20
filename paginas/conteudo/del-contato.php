<?php 
include ('../../config/conexao.php');

if (isset($_GET['idDel'])){
    $id = $_GET['idDel'];
    //Primeiro,recupere o nome da imagem do repository
    $select = "SELECT foto_contatos FROM tb_contatos WHERE id_contatos=$id";

        try{
            $result = $conect->prepare($select);
            $result->bindValue('id',$id,PDO::PARAM_INT);
            $result-> execute();

            $contar = $result->rowCount();
            if ($foto != 'avatar-padrao.png') {
                //Caminho da imagem no servidor
                $filepath = "../../img/cont/". $foto;

                //Deleta a imagem
                if(file_exists($filepath)) {
                    unlink($filepath);
                }
            }
            //Agora, delete o registro do bamco de dados
            $delete = "DELETE FROM tb_contatos WHERE id_contatos=:id";
            try {
            $result = $conect->prepare($delete);
            $result->bindValue(':id',$id,PDO::PARAM_INT);
            $result->execute();

            }catch(Exception $e) {

            }
            

        }catch(PDOException $e) {

        }

    }
