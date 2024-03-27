<?php

    if(isset($_POST)){
        // Conexão com o banco
        require_once('conectarBanco.php');

        if(isset($_POST['titulo'])){
            // Define o valor pesquisado
            $titulo_pesquisado = $_POST['titulo'];

            $pesquisa = "SELECT * FROM conteudos WHERE titulo like :titulo";
            $stmt = $conexao->prepare($pesquisa);
            $stmt->bindValue(':titulo','%' . $titulo_pesquisado . '%');
            $stmt->execute();
        }else if(isset($_POST['id'])){
            // Define o valor pesquisado
            $id_pesquisado = $_POST['id'];

            $pesquisa = "SELECT * FROM conteudos WHERE id = :id";
            $stmt = $conexao->prepare($pesquisa);
            $stmt->bindValue(':id',$id_pesquisado);
            $stmt->execute();
        }

        $retorno_pesquisa = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($retorno_pesquisa);
        
    }
?>