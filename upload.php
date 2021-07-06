<?php
require_once "Connections/conexao.php";
// print_r($_POST);
// print_r($_FILES);

$idProduto = $_POST['idProduto'];

// $filename = $_POST['filename'];

$target_directory = "img/uploads";
$pname = rand(1000,10000)."-". $_FILES["file"]["name"];
$target_file = $target_directory.basename($_FILES["file"]["name"]);
$filetype = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$url = $target_directory."/".$pname;
$newfilename = $target_directory.$pname.".".$filetype;

if (move_uploaded_file($_FILES["file"]["tmp_name"], $newfilename)) {
    $c = new conectar();
    $conexao = $c->conexao();

    $sql = "INSERT INTO tbimagens (id_produto, nome, url, data_upload) VALUES ('$idProduto', '$pname', '$url', NOW())";
    $add_prod = $conexao->query($sql);


    echo 1;
}else {
    echo 0;
}



// $ds          = DIRECTORY_SEPARATOR;  //1
 
// $storeFolder = 'img/uploads';   //2
 
// if (!empty($_FILES)) {
     
//     $tempFile = $_FILES['file']['tmp_name'];          //3             
      
//     $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;  //4
     
//     $targetFile =  $targetPath. $_FILES['file']['name'];  //5
 
//     move_uploaded_file($tempFile,$targetFile); //6
     
// }
