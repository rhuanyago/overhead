<?php

require_once "Connections/conexao.php";

$c = new conectar();
$conexao=$c->conexao();

//Receber a requisão da pesquisa 
$requestData= $_REQUEST;


//Indice da coluna na tabela visualizar resultado => nome da coluna no banco de dados
$columns = array( 
	0 =>'idpedido', 
    1 =>'comanda',
    2 =>'reg',
    3 =>'status',
    4 =>'valor',
    5 =>'titulo',
    6 =>'nome',
    7 =>'hora'
);

   // Essa consulta é apenas para pegar a quantidade de registros que tem no banco de dados
    $sql_initial = $conexao->query("SELECT a.*, c.nome,date_format(data_inc, '%H:%i') AS hora FROM tbpedidos a,tbclientes c where c.reg = a.reg and a.status = 'A' order by a.idpedido desc;");
    $qnt_linhas = $sql_initial->num_rows; //Quantidade de registros
    
    //var_dump($qnt_linhas);
    
    $sql_string = "SELECT a.*, c.nome,date_format(data_inc, '%H:%i') AS hora FROM tbpedidos a,tbclientes c where c.reg = a.reg and a.status = 'A' and 1=1 ";
    
    //Obter os dados a serem apresentados
    $sql_search = $conexao->query($sql_string);
              
    // if(!empty($requestData['search']['value'])) {   // se houver um parâmetro de pesquisa, $requestData['search']['value'] contém o parâmetro de pesquisa
    //     $sql_string.=" AND ( idpedido LIKE '%".$requestData['search']['value']."%' ";    
    //     $sql_string.=" OR comanda LIKE '%".$requestData['search']['value']."%' ";
    //     $sql_string.=" OR nome LIKE '%".$requestData['search']['value']."%' )";
    // }   // PESQUISAR

    $totalFiltered = $sql_search->num_rows;
    
    //var_dump($totalFiltered);

    // Ordena resultado e limita na quantidade
    //$sql_string.=' ORDER BY '. $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

    //ORDENAR 
   
    //var_dump($sql_search);
    //die();

    $sql_search = $conexao->query($sql_string);
    
    // echo $sql_string;
    // die();

    $dados = array();
    //$result = $sql_search->fetch_assoc();
    while ($row = $sql_search->fetch_array()) {
        $idpedido = $row["idpedido"];
        $comanda = $row["comanda"];
        $reg = $row["reg"];
        $status = $row["status"];

        if ($status == "A") {
            $status = '<span class="badge badge-info">Aberto</span>';
        }else{
            $status = '<span class="badge badge-success">Finalizado</span>';
        }
        $btnDel = "<a class='btn btn-default text-center' title='Adicionar Produtos' href='pedido_itens_adiciona.php?idpedido='".$rows_rspedidos['idpedido']."'><i class='fas fa-plus'></i></a><span class='btn btn-dark text-white' data-toggle='modal' data-target='#atualizaCategoria' onclick='adicionarDado('".$row['idpedido']."')'><i class='fas fa-pencil-alt'></i></span><span class='btn btn-danger text-white' onclick='eliminarCategoria('".$row['idpedido']."')'><i class='far fa-trash-alt'></i></span>";
       
       $dado = array();
       $dado[] = $idpedido;
       $dado[] = $comanda;
       $dado[] = $row["nome"];
       $dado[] = $status;
       $dado[] = $row["titulo"];
       $dado[] = $row["hora"];
       $dado[] = $row["valor"];
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