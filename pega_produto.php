<?php
include("Connections/conexao.php");
$c = new conectar();
$conexao = $c->conexao();

$idcategoria = $_POST['idcategoria'];

$sql = "SELECT * from tbproduto where idcategoria = '$idcategoria' and habilitado = 'S' ";
$sql = $conexao->query($sql);

?>
    <option value="">Selecione o produto</option> 

<?php while ($rows_rsprodutos = $sql->fetch_assoc()) { ?>
    
    <option value="<?php echo $rows_rsprodutos['referencia'] ?>"><?php echo $rows_rsprodutos['descricao'] ?></option>
<?php } ?>