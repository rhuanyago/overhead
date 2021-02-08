<?php 

function Conecta(){    
    
    try{
        // $conexao = mysqli_connect("localhost", "root", "", "sistema") or die ('Não foi possível conectar!');
        //$conexao->set_charset("utf8");
        $conexao=new PDO("mysql:host=localhost;dbname=sistema;charset=utf8",'root','');
    }
    catch(PDOException $erro){
        $erro->getMessage();
    }   
    
    return  $conexao;
}

function ExecutaConsulta($conexao,$sql){
  $valor=func_get_args();
  $valores=array_slice($valor,2);
  $preparado=$conexao->query($sql);
  $preparado=$conexao->prepare($sql);
  $preparado->execute($valores);
  $executar=$preparado->fetchAll();
//$executar=$preparado->fetch_assoc();

  $arrTmp[] = $executar;

  $arr = [];
  foreach($arrTmp as $item){
    foreach($item as $kk){
      $arr[] = $kk;
    }
  }
  return $arr;

}



