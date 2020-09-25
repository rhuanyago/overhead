<?php
include("Connections/conexao.php");
$c = new conectar();
$conexao = $c->conexao();

$referencia = $_POST['referencia'];

$sql = "SELECT c.referencia,c.descricao,c.preco,c.habilitado FROM tbproduto c where c.referencia = '$referencia' and c.habilitado = 'S' ";
$sql = $conexao->query($sql);
$row = $sql->fetch_array();

$preco = $row['preco'];
$descricao = $row['descricao'];

  
$ar = array('referencia'=>$referencia,
'preco'=>$preco,
'descricao'=>$descricao

);  

echo json_encode($ar);

?>
    