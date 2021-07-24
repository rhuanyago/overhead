<?php
require_once "Connections/conexao.php";

$c = new conectar();
$conexao=$c->conexao();

function retorna($nome, $conexao)
{
    $row_aluno = "SELECT * FROM tbclientes WHERE nome = '$nome' limit 1";
    $sql = $conexao->query($row_aluno);
    if ($sql->num_rows) {
        $rows_rsperm = mysqli_fetch_assoc($sql);
        $valores['nome_cli'] = $rows_rsperm['nome'];
        $valores['idcliente'] = $rows_rsperm['reg'];
    } else {
        $valores['nome_cli'] = 'Cliente não encontrado';
    }
    return json_encode($valores);
}

if (isset($_GET['nome'])) {
    echo retorna($_GET['nome'], $conexao);
}



?>