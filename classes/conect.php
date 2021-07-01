<?php
require_once "../Connections/conexao.php";
require_once "../classes/class.vision.php";

$parametrotela = $_POST['paramTela'];	
$parametrotelaPost = isset($_POST['postHidden']);

if($parametrotela == 'consultaLogs'){
    
    $obj = new vision();

    $result = $obj->consultarLogs();

   foreach($result as $key => $row){
        $idusuario = $row['idusuario'];
        $email = $row['email'];
        $hora = $row['hora'];
        $ip = $row['ip'];
        $mensagem = $row['mensagem'];

       $arr[] = [$idusuario, $email, $hora, $ip, $mensagem];

   }
    

    echo json_encode($arr);
    //print_r($dados);
};


if($parametrotela == 'registrarUsuario'){
    
    $obj = new vision();

    $senha = md5($_POST['senha']);
    $senha_confirma = md5($_POST['senha_confirma']);

    $dados = array(
        $_POST['nome'],
        $_POST['email'],
        $senha,
        $senha_confirma,
        $_POST['dtnascimento'],
        $_POST['telefone'],
        $_POST['permissao']
    );

    echo $obj->registrarUsuario($dados);
    //print_r($dados);
};

if ($parametrotela == 'Login') {
    $obj = new vision();    

    $dados = array(
        $_POST['email'],
        $_POST['senha']
    );

    echo $obj->Login($dados);
}


if ($parametrotela == 'registrarCliente') {
    $obj = new vision();    

    $dados = array(
        $_POST['nome'],
        $_POST['rg'],
        $_POST['dtnascimento'],
        $_POST['telefone']
    );

    echo $obj->registrarCliente($dados);
}


if ($parametrotela == 'ConsultarCategoria') {
    $obj = new vision();
    $result = $obj->consultarCategoria();    
    foreach ($result as $key => $row) {
        $idcategoria = $row['idcategoria'];
        $nome = $row['nome'];
        $habilitado = $row['habilitado'];

        if ($habilitado == "S") {
            $habilitado = ' <span class="badge badge-success text-center">Sim</span>';
        }else{
            $habilitado = '<span class="badge badge-danger text-center">Não</span>';
        }
        $btn = "<span class='btn btn-dark text-white' data-toggle='modal' data-target='#atualizaCategoria' id='btnAtualizaCategoria' data-idcategoria='".$idcategoria."' data-nome='".$nome."' data-habilitado='".$row["habilitado"]."'><i class='fas fa-pencil-alt'></i></span>";
        $btn .= "<span class='btn btn-danger text-white' id='btnExcluirCategoria' onclick='eliminarCategoria(".$idcategoria.")' ><i class='far fa-trash-alt'></i></span>";

        $arr[] = [$idcategoria,$nome,$habilitado,$btn];
    }
    echo json_encode($arr);
}

if($parametrotela == 'AdicionarCategoria'){
    $obj = new vision();

    $categoria = $_POST['categoria'];
    $habilitado = $_POST['habilitado'];   
    

    echo $obj->adicionarCategoria($categoria,$habilitado);
}


if($parametrotela == 'AtualizarCategoria'){
    $obj = new vision();

    $idcategoria = $_POST['idcategoria'];
    $categoria = $_POST['categoria'];
    $habilitado = $_POST['habilitado'];   
    

    echo $obj->atualizarCategoria($idcategoria,$categoria,$habilitado);
}

if ($parametrotela == 'ExcluirCategoria') {
    $obj = new vision();

    $idcategoria = $_POST['idcategoria'];

    echo $obj->excluirCategoria($idcategoria);

}

if ($parametrotela == 'AtualizarClientes') {
    $obj = new vision();

    $reg = $_POST['reg'];
    $nome = $_POST['nome'];
    $rg = $_POST['rg'];
    $telefone = $_POST['telefone'];
    $dtnascimento = $_POST['dtnascimento'];
    $habilitado = $_POST['habilitado'];

    echo $obj->atualizarClientes($reg,$nome,$rg,$telefone,$dtnascimento,$habilitado);

}

if ($parametrotela == 'ExcluirCliente') {
    $obj = new vision();

    $reg = $_POST['reg'];

    echo $obj->excluirCliente($reg);
}


if ($parametrotela == 'adicionarProdutos') {
    $obj = new vision();

    $categoria = $_POST['categoria'];
    $nome = $_POST['nome'];
    $referencia = $_POST['referencia'];
    $preco = $_POST['preco'];
    $estoque = $_POST['estoque'];
    $habilitado = $_POST['habilitado'];

    echo $obj->adicionarProdutos($categoria, $nome, $referencia, $preco, $estoque, $habilitado);
}

if ($parametrotela == 'consultarCliente') {

    $obj = new vision();       
                   
    $result =  $obj->consultarCliente();

    foreach ($result as $key => $row){
        $reg = $row['reg'];
        $nome = $row['nome'];
        $rg = $row['rg'];
        $telefone = $row['telefone'];
        $dtnascimento = $row['dt_nascimento']; 
        $habilitado = $row['habilitado']; 
        
        if ($habilitado == "S") {
            $habilitado = ' <span class="badge badge-success text-center">Sim</span>';
        }else{
            $habilitado = '<span class="badge badge-danger text-center">Não</span>';
        }
        if(in_array('editarClientes', $_SESSION['nomeGrupo']) || $_SESSION['permissao'] == "SUPER-ADMIN") { 
            $btnDel = "<span class='btn btn-dark text-white' data-toggle='modal' data-target='#atualizaClientes' id='btnAtualizaClientes' data-reg='".$reg."' data-nome='".$nome."' data-rg='".$rg."' data-telefone='".$telefone."' data-dt_nascimento='".$dtnascimento."' data-habilitado='".$row['habilitado']."'><i class='fas fa-pencil-alt'></i></span>";
        }else{
            $btnDel = "<span class='btn btn-dark text-white disabled' ><i class='fas fa-pencil-alt'></i></span>";
        }
        if(in_array('excluirClientes', $_SESSION['nomeGrupo']) || $_SESSION['permissao'] == "SUPER-ADMIN") { 
            $btnDel .= "<span class='btn btn-danger text-white' id='btnExcluirClientes' data-reg='".$reg."' ><i class='far fa-trash-alt'></i></span>";   
        }else {
            $btnDel .= "<span class='btn btn-danger text-white disabled' ><i class='far fa-trash-alt'></i></span>";   
        }

        // $arr[] = [$reg,$nome,$rg,$telefone,$dtnascimento,$habilitado,$btnDel]; //Ordem dos Registros na Datatable
        
        $arr[] = [
            'reg' => $reg,
            'nome' => $nome,
            'rg' => $rg,
            'telefone' => $telefone,
            'dt_nascimento' => $dtnascimento,
            'habilitado'=> $habilitado,
            'btn' => $btnDel]; //Ordem dos Registros na Datatable


    }

    echo json_encode($arr);
    
}

if ($parametrotela == 'ultimosPedidos') {
   $obj = new vision();

   $result = $obj->ultimosPedidos();

   $arr = [];
   foreach ($result as $key => $row) {
       
    $idpedido = $row['idpedido'];
    $reg = $row['reg'];
    $tipo = $row['tipo'];
    $nome = $row['nome'];
    $status = $row['status'];
    $titulo = $row['titulo'];
    $hora = $row['hora'];
    $valor = $row['valor'];

    if ($status == "A") {
        $status = ' <span class="badge badge-success text-center">Aberto</span>';
    }else{
        $status = '<span class="badge badge-danger text-center">Fechado</span>';
    }

    $btn = "<a class='btn btn-default text-center' title='Adicionar Produtos' href='nova_venda.php?idpedido=".$idpedido."'><i class='fas fa-plus'></i></a>";
    $btn .= "<a class='btn btn-dark text-white text-center' title='Verificar Pedido' href='pedido_itens.php?idpedido=".$idpedido."'><i class='fas fa-pencil-alt'></i></a>";
    $btn .= "<a class='btn btn-danger text-white text-center' title='Excluir Pedido' id='btnExcluirPedidos' data-idpedido='".$idpedido."'><i class='far fa-trash-alt'></i></a>";

    // $arr[] = [$idpedido, $comanda, $nome, $status, $titulo, $hora, $valor, $btn];    

    $arr[] = [
        'pedido' => $idpedido, 
        'nome' => $nome, 
        'status' => $status, 
        'titulo' => $titulo, 
        'hora' => $hora, 
        'valor' => $valor, 
        'btn' => $btn
    ];    



   }

   echo json_encode($arr); 

}

if ($parametrotela == 'consultarUsuario') {
    $obj = new vision();
 
    $result = $obj->consultarUsuario();   

    foreach ($result as $key => $row){
        $idusuario = $row['idusuario'];
        $nome = $row['nome'];
        $email = $row['email'];
        $permissao = $row['permissao'];
        $telefone = $row['telefone'];
        $dtnascimento = $row['dtnascimento'];
        $habilitado = $row['habilitado'];

        if ($habilitado == "S") {
            $habilitado = '<span class="badge badge-success text-center">Sim</span>';
        }else{
            $habilitado = '<span class="badge badge-danger text-center">Não</span>';
        }
        $btn = "<span class='btn btn-dark text-white' data-toggle='modal' data-target='#atualizaUsuarios' id='btnAtualizaUsuarios' data-idusuario='".$idusuario."' data-nome='".$nome."' data-email='".$email."' data-senha'".$row['senha']."' data-senha_confirma'".$row['senha_confirma']."' data-telefone='".$telefone."' data-dt_nascimento='".$dtnascimento."' data-habilitado='".$row['habilitado']."' data-idpermissao='".$row['idpermissao']."' data-permissao='".$permissao."'><i class='fas fa-pencil-alt'></i></span>";
        $btn .= "<span class='btn btn-danger text-white' id='btnExcluirUsuario' data-idusuario='".$idusuario."' ><i class='far fa-trash-alt'></i></span>";

        // $arr[] = [$nome,$email,$permissao,$telefone,$dtnascimento,$habilitado,$btn]; //Posição que cria o datatable;

        $arr[] = [
            'nome' => $nome,
            'email' => $email,
            'permissao' => $permissao,
            'telefone' => $telefone,
            'dtnascimento' => $dtnascimento,
            'habilitado' => $habilitado,
            'btn' => $btn
        ]; //Posição que cria o datatable;

    }  

    echo json_encode($arr);
 
 }

 if ($parametrotela == 'AtualizarUsuarios') {
     $obj = new vision();

     $idusuario = $_POST['idusuario'];
     $nome = $_POST['nome'];
     $email = $_POST['email'];
     $senha = $_POST['senha'];
     $senha_confirma = $_POST['senha_confirma'];
     $telefone = $_POST['telefone'];
     $dtnascimento = $_POST['dtnascimento'];
     $habilitado = $_POST['habilitado'];
     $idpermissao = $_POST['idpermissao'];

     echo $obj->atualizarUsuarios($idusuario, $nome, $email, $senha, $senha_confirma, $telefone, $dtnascimento, $habilitado, $idpermissao);


 }

 if ($parametrotela == 'ExcluirUsuario') {
     $obj = new vision();

     $idusuario = $_POST['idusuario'];

     echo $obj->excluirUsuarios($idusuario);
 }

 if ($parametrotela == 'consultarProdutos') {
     $obj = new vision();
     $result = $obj->consultarProdutos();

     $arr = [];
     foreach ($result as $key => $row){
        $idproduto = $row['idproduto'];
        $idcategoria = $row['idcategoria'];
        $nome = $row['nome'];
        $referencia = $row['referencia'];
        $descricao = $row['descricao'];
        $preco = $row['preco'];
        $estoque = $row['estoque'];
        $habilitado = $row['habilitado'];
        if ($habilitado == "S") {
            $habilitado = ' <span class="badge badge-success text-center">Sim</span>';
        }else{
            $habilitado = '<span class="badge badge-danger text-center">Não</span>';
        }
        $btn = "<span class='btn btn-dark text-white' data-toggle='modal' data-target='#atualizaProdutos' id='btnAtualizaProdutos' data-idproduto='".$idproduto."' data-idcategoria='".$idcategoria."'  data-nome='".$nome."' data-referencia='".$referencia."' data-descricao='".$descricao."' data-valor='".$preco. "'  data-estoque='" . $estoque . "' data-habilitado='".$row['habilitado']."'><i class='fas fa-pencil-alt'></i></span>";
        $btn .= "<span class='btn btn-danger text-white' id='btnExcluirProdutos' data-idproduto='".$idproduto."' data-referencia='".$referencia."' ><i class='far fa-trash-alt'></i></span>";

        $arr[] = [$nome, $referencia, $descricao, $preco, $estoque,$habilitado, $btn];


     }
     

     echo json_encode($arr);
     
 }

 if ($parametrotela == 'AtualizarProdutos') {
     $obj = new vision();

    $idproduto = $_POST['idproduto'];
    $idcategoria = $_POST['idcategoria'];
    $descricao = $_POST['descricao'];
    $referencia = $_POST['referencia'];
    $preco = $_POST['preco'];
    $estoque = $_POST['estoque'];
    $habilitado = $_POST['habilitado'];

    echo $obj->atualizarProdutos($idproduto, $idcategoria, $descricao, $referencia, $preco, $estoque, $habilitado);

 }

 if ($parametrotela=="ExcluirProdutos") {
     $obj = new vision();

    $idproduto = $_POST['idproduto'];
    $referencia = $_POST['referencia'];

    echo $obj->excluirProdutos($idproduto, $referencia);

 }

 if ($parametrotela == "gerarVenda") {
     $obj = new vision();
     
    $titulo = $_POST['titulo'];

    echo $obj->gerarVenda($titulo);

 }

 if ($parametrotela == "pegarProdutos") {
    $obj = new vision();
    
   $idcategoria = $_POST['idcategoria'];

   echo $obj->pegarProdutos($idcategoria);

}

 if ($parametrotela == "pegarDescProdutos") {
    $obj = new vision();
    
   $referencia = $_POST['referencia'];

   echo $obj->pegaDescProdutos($referencia);

}

if ($parametrotela == "pegarProdReferencia") {
    $obj = new vision();

    $referencia = $_POST['referencia'];

    echo $obj->pegarProdReferencia($referencia);
}

if ($parametrotela == "listarItens") {
    $obj = new vision();

    $idpedido = $_POST['idpedido'];

    echo $obj->listarItens($idpedido);
}

if ($parametrotela == "atualizarQuantidade") {
    $obj = new vision();

    $idpedido = $_POST['idpedido'];
    $iditem = $_POST['iditem'];
    $referencia = $_POST['referencia'];
    $preco = $_POST['preco'];
    $quantidade = $_POST['qtde'];

    echo $obj->atualizarQuantidade($idpedido, $iditem, $referencia, $preco,$quantidade);
}

if ($parametrotela == "adicionarProduto") {
    $obj = new vision();

    $idpedido = $_POST['idpedido'];
    $referencia = $_POST['referencia'];
    $preco = $_POST['preco'];
    $qtde = $_POST['qtde'];
    $descricao = $_POST['descricao'];

    echo $obj->adicionarProduto($idpedido, $referencia, $preco, $qtde, $descricao);
}

if ($parametrotela == "ExcluirItem") {
    $obj = new vision();

    $idpedido = $_POST['idpedido'];
    $iditem = $_POST['iditem'];

    echo $obj->excluirItem($idpedido, $iditem);
}

if ($parametrotela == "AdicionarPermissao") {
    $obj = new vision();

    $permissao = $_POST['permissao'];
    $habilitado = $_POST['habilitado'];

    echo $obj->adicionarPermissao($permissao, $habilitado);

}

if ($parametrotela == "consultaPermissao") {
    $obj = new vision();

    echo $obj->consultarPermissao();
}



if($parametrotela == 'AtualizarPermissao'){
    $obj = new vision();

    $idpermissao = $_POST['idpermissao'];
    $permissao = $_POST['permissao'];
    $habilitado = $_POST['habilitado'];   
    

    echo $obj->atualizarPermissao($idpermissao,$permissao,$habilitado);
}


if($parametrotela == 'ExcluirPermissao'){
    $obj = new vision();

    $idpermissao = $_POST['idpermissao'];
    

    echo $obj->excluirPermissao($idpermissao);
}

if($parametrotela == 'adicionarTela'){
    $obj = new vision();

    $nomeTela = $_POST['tela'];
    $idpermissao = $_POST['idpermissao'];

    echo $obj->adicionarTela($nomeTela,$idpermissao);
}

if ($parametrotela == 'registrarPaginas') {
    $obj = new vision();    

    $nome = $_POST['nome'];
    $url = $_POST['url'];

    echo $obj->registrarPaginas($nome, $url);
}

if ($parametrotela == 'consultaPaginas') {
    $obj = new vision();    

    $result = $obj->consultaPaginas();

    //print_r($result);

    foreach ($result as $key => $row){
        $idpaginas = $row['idpaginas'];
        $paginas = $row['paginas'];
        $url = $row['url'];

        $btn = "<span class='btn btn-dark text-white' data-toggle='modal' data-target='#atualizaPaginas' id='btnAtualizaPaginas' data-idpaginas='".$idpaginas."' data-pagina='".$paginas."'  data-url='".$url."'><i class='fas fa-pencil-alt'></i></span>";
        $btn .= "<span class='btn btn-danger text-white' id='btnExcluirPaginas' data-idpaginas='".$idpaginas."'><i class='far fa-trash-alt'></i></span>";

        $arr[] = [$paginas, $url, $btn];
    }
    
    //print_r($arr);

    echo json_encode($arr);
}

if($parametrotela == 'ExcluirPaginas'){
    $obj = new vision();

    $idpaginas = $_POST['idpaginas'];
    

    echo $obj->excluirPaginas($idpaginas);
}

if($parametrotela == 'AtualizarPaginas'){
    $obj = new vision();

    $idpaginas = $_POST['idpaginas'];
    $pagina = $_POST['pagina'];
    $url = $_POST['url'];

    echo $obj->AtualizarPaginas($idpaginas,$pagina,$url);
}

if ($parametrotela == 'ExcluirPedidos') {
    $obj = new vision();

    $idpedido = $_POST['idpedido'];
    // $idcomanda = $_POST['idcomanda'];
    
    echo $obj->excluirPedidos($idpedido);
}

if ($parametrotela == 'adicionarForma') {
    $obj = new vision();

    $idpedido = $_POST['idpedido'];
    $forma = $_POST['forma'];
    $tipo = $_POST['tipo'];
    $valor = $_POST['valor'];
    $valorrecebido = $_POST['valorrecebido'];

    echo $obj->adicionarForma($idpedido,$forma,$tipo,$valor,$valorrecebido);
}

if ($parametrotela == 'listarFormasPagamento') {
    $obj = new vision();

    $idpedido = $_POST['idpedido'];

    $result = $obj->listarFormasPagamento($idpedido);  
    
    // print_r($result);
   

    foreach ($result as $key => $row) {
        $forma = $row['forma'];
        $forma_descricao = $row['forma_descricao'];
        $troco = $row['troco'];
        $status = $row['status'];
        $valor = $row['valor'];
        $idforma = $row['idforma'];
        $idpedido = $row['idpedido'];
        if ($row['status'] == "F" ) { 
        $btn = '' ;
        }else{
        $btn = "<td class='actions-hover actions-fade text-center'>
                <span class='delete-row' data-toggle='modal' data-target='#deletarForma' id='btnDeletarForma' data-idpedido='".$idpedido."' data-idforma='".$idforma."'><i class='far fa-trash-alt'></i></a>
        	    </td>";
        } 

        $arr[] = [$forma, $forma_descricao, $valor, $troco, $btn];
        
    }

    echo json_encode($arr);
}

?>