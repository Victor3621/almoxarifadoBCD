<?php

header("Content-type: application/json");

require "conexao.php";

$metodo = $_SERVER["REQUEST_METHOD"];

if ($metodo == "POST"){
    $json = file_get_contents("php://input");

    $dados = json_decode($json,true);

    $sql = "INSERT INTO pecas (nome,categoria,fornecedor,quantidade,preco_unitario) VALUES (?,?,?,?,?)";

    $comando = $pdo->prepare($sql);
    if (
    $dados["categoria"] == "eletrica" ||  $dados["categoria"] == "mecanica" || $dados["categoria"] == "hidraulica" && $dados["quantidade"] <= 0 && $dados["preco_unitario"] >0){
        $comando -> execute([
        $dados["nome"],
        $dados["categoria"],
        $dados["fornecedor"],
        $dados["quantidade"],
        $dados["preco_unitario"]
    ]);
    echo json_encode(["mensagem" => "Produto cadastrado"]);
    } else {
        echo json_encode(["Mensagem" => "Verifique os dados e tente novamente!"]);
    };

};

if ($metodo == "GET"){
    $sql = "SELECT * FROM pecas ORDER BY id";
    $comando = $pdo-> query($sql);
    $produtos = $comando -> fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($produtos);
};

if ($metodo == "PUT"){
    $json = file_get_contents("php://input");
    $dados = json_decode($json,true);
    $sql = "UPDATE produtos SET nome=?, categoria=? WHERE id=?";
    $comando = $pdo -> prepare($sql);
    $comando -> execute([
        $dados["nome"],
        $dados["categooria"],
        $dados["id"]
    ]);

    echo json_encode(["Mensagem" =>"Chamado atualizado com sucesso!"]);
};

if ($metodo == "DELETE"){
    $json = file_get_contents("php://input");
    $dados = json_decode($json,true);
    $sql = "DELETE FROM produtos WHERE id=?";
    $comando = $pdo->prepare($sql);
    $comando -> execute([
        $dados["id"]
    ]);

    echo json_encode(["mensagem" => "Chamado deletado com sucesso!"]);
    };





