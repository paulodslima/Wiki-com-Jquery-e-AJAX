<?php
    // Conexão com o banco
    require_once('conectarBanco.php');

    // Define o valor
    $titulo_novo = $_POST['titulo'];
    $conteudo_novo = $_POST['conteudo'];
    $autor_novo = $_POST['autor'];
    $id = $_POST['id'];

    if(!empty($id) && $id != ''){

        $alteracao = "UPDATE conteudos set titulo = :titulo_novo, conteudo = :conteudo_novo, autor = :autor_novo  WHERE id = :id";
        $stmt = $conexao->prepare($alteracao);
        $stmt->bindValue(':titulo_novo', $titulo_novo);
        $stmt->bindValue(':conteudo_novo', $conteudo_novo);
        $stmt->bindValue(':autor_novo', $autor_novo);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        if($stmt->rowCount() > 0){
            $resposta = "Conteúdo alterado com sucesso!";
            $retorno = array(
                "0" => $resposta,
                "1" => $id);
        }
    }else{
        $inclusao = "INSERT INTO conteudos(titulo, conteudo, autor) VALUES (:titulo_novo,:conteudo_novo,:autor_novo)";
        $stmt = $conexao->prepare($inclusao);
        $stmt->bindValue(':titulo_novo', $titulo_novo);
        $stmt->bindValue(':conteudo_novo', $conteudo_novo);
        $stmt->bindValue(':autor_novo', $autor_novo);
        $stmt->execute();

        if($stmt->rowCount() > 0){
            $resposta = "Conteúdo incluido com sucesso!";
            $retorno = array("0" => $resposta);
        }
    }

    echo json_encode($retorno);
?>