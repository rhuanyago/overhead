<?php
require_once "Connections/conexao.php";

$c = new conectar();

$conexao = $c->conexao();

$nome_cli = filter_input(INPUT_GET, 'term', FILTER_SANITIZE_STRING);

//SQL para selecionar os registros
$result_msg_cont = "SELECT * FROM tbclientes WHERE nome LIKE '" . $nome_cli . "%' limit 10";
$sql = $conexao->query($result_msg_cont);

while($row_msg_cont = mysqli_fetch_assoc($sql)){
    $data[] = $row_msg_cont['nome'];
}

echo json_encode($data);