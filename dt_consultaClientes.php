<?php

require_once "Connections/conexao.php";

$c = new conectar();
$conexao=$c->conexao();

//Receber a requisão da pesquisa 
$requestData= $_REQUEST;


//Indice da coluna na tabela visualizar resultado => nome da coluna no banco de dados
$columns = array( 
	0 =>'reg', 
    1 =>'nome',
    2 =>'rg',
    3 =>'telefone',
    4 =>'dt_nascimento',
    5 =>'habilitado'
);

   // Essa consulta é apenas para pegar a quantidade de registros que tem no banco de dados
    $sql_initial = $conexao->query("SELECT * FROM tbclientes");
    $qnt_linhas = $sql_initial->num_rows; //Quantidade de registros
    
    //var_dump($qnt_linhas);
    
    $sql_string = "SELECT * FROM tbclientes WHERE 1=1 ";
    
    //Obter os dados a serem apresentados
    $sql_search = $conexao->query($sql_string);
              
    if(!empty($requestData['search']['value'])) {   // se houver um parâmetro de pesquisa, $requestData['search']['value'] contém o parâmetro de pesquisa
        $sql_string.=" AND ( reg LIKE '%".$requestData['search']['value']."%' ";    
        $sql_string.=" OR nome LIKE '%".$requestData['search']['value']."%' ";
        $sql_string.=" OR rg LIKE '%".$requestData['search']['value']."%' )";
    }   // PESQUISAR

    $totalFiltered = $sql_search->num_rows;
    
    //var_dump($totalFiltered);

    // Ordena resultado e limita na quantidade
    $sql_string.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

    //ORDENAR 
   
    //var_dump($sql_search);
    //die();

    $sql_search = $conexao->query($sql_string);
    
    // echo $sql_string;
    // die();

    $dados = array();
    //$result = $sql_search->fetch_assoc();
    while ($row = $sql_search->fetch_array()) {
        $reg = $row["reg"];
        $nome = $row["nome"];
        $rg = $row["rg"];
        $habilitado = $row["habilitado"];

        if ($habilitado == "S") {
            $habilitado = ' <span class="badge badge-success text-center">Sim</span>';
        }else{
            $habilitado = '<span class="badge badge-danger text-center">Não</span>';
        }
        $btnDel = "<span class='btn btn-dark text-white' data-toggle='modal' data-target='#atualizaClientes' onclick='adicionarDado('".$row['reg']."','".$row['nome']."', '".$row['rg']."', '".$row['telefone']."', '".$row['dt_nascimento']."', '".$row['habilitado']."')'><i class='fas fa-pencil-alt'></i></span><span class='btn btn-danger text-white' onclick=eliminarCategoria('".$row['reg']."')><i class='far fa-trash-alt'></i></span>";
       
       $dado = array();
       $dado[] = $reg;
       $dado[] = $nome;
       $dado[] = $rg;
       $dado[] = $row["telefone"];
       $dado[] = $row["dt_nascimento"];
       $dado[] = $habilitado;
       $dado[] = $btnDel;
       $dados[] = $dado;
    }

   // Ler e criar o array de dados
//    $dados = array();
//    foreach ($result as $key => $row) {
//        $btnDel = "<a data-confirm='Tem certeza que deseja deletar esse usuário?' class='btn btn-danger pull-right' rel='nofollow' data-method='delete' href=cadastro_mac.php?empresa=".$row['mac_company']."&mac=".$row['mac_value']."'><i class='fa fa-trash'></i></a><a href='cadastro_mac_editar.php?empresa=".$row['mac_company']."&mac=".$row['mac_value']."' class='btn btn-default  pull-right'><i class='fa fa-pencil'></i></a>";
       
//        $dado = array();
//        $dado[] = $row["mac_value"];
//        $dado[] = $row["mac_company"];
//        $dado[] = $btnDel;
//        $dados[] = $dado;
//    }


    //Cria o array de informações a serem retornadas para o Javascript
    $json_data = array(
        "draw" => intval( $requestData['draw'] ),//para cada requisição é enviado um número como parâmetro
        "recordsTotal" => intval( $qnt_linhas ),  //Quantidade de registros que há no banco de dados
        "recordsFiltered" => intval( $totalFiltered ), //Total de registros quando houver pesquisa
        "data" => $dados   //Array de dados completo dos dados retornados da tabela 
    );

    echo json_encode($json_data);  //enviar dados como formato json

?>