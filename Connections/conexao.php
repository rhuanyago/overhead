<?php
//Conexão com o Banco de Dados

if (!isset($_SESSION)) {//Verificar se a sessão não já está aberta.
    session_start();
}

class conectar{

private $serverip = "localhost";

private $username = "root";

private $password = "";

private $db_name = "overhead";

  public function conexao(){

  $conexao = mysqli_connect($this->serverip, $this->username, $this->password, $this->db_name) or die ('Não foi possível conectar!');

  $conexao -> set_charset("utf8");

  return $conexao;

  }    



}

?>