<?php

require_once "../Connections/conexao2.php";

class teste{

    public function __construct()
    {
        $this->conecta=Conecta();
    }

    
    public function teste2(){

        
        $sql="SELECT count(*) as total from tbusuarios WHERE email = 'admin@admin.com.br'";
        $resultado=ExecutaConsulta($this->conecta,$sql);
        // print_r($resultado);

        return $resultado;
        
    }
    
   

}


$a = new teste();
$epa = $a->teste2();

print_r($epa);

