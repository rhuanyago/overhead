<?php
// require_once "../Connections/conexao2.php";

if (!isset($_SESSION)) {//Verificar se a sessão não já está aberta.
    session_start();
}	

class vision{

    public $obj;
    public $conexao;       

    public function __construct()
    {   
        $c = new conectar();
        $this->conexao = $c->conexao();
        // $this->conecta=Conecta();
    }

    function ExecutaConsulta($conexao,$sql){
        $valor=func_get_args();
        $valores=array_slice($valor,2);
        $preparado=$conexao->query($sql);
        // $preparado=$conexao->prepare($sql);
        // $preparado->execute($valores);
        // $executar=$preparado->fetchAll();
        $executar=$preparado->fetch_assoc();
      
        // $arrTmp[] = $executar;
      
        // $arr = [];
        // foreach($arrTmp as $item){
        //   foreach($item as $kk){
        //     $arr[] = $kk;
        //   }
        // }
        return $executar;
      
    }

    // function ExecutaConsulta($conexao,$sql){
    //  // realizando o SQL
    // //  $sql = ('SELECT * FROM tbusuarios;');

    //  // Realizando a conexão
 
    //  $prepare_sql = $conexao->prepare($sql);
 
    //  $prepare_sql->execute();
        
     
    //  return $prepare_sql->fetch(PDO::FETCH_ASSOC);

    // }

    
    function salvaLog($mensagem) {
        //$c = new conectar();
        ////$conexao=$c->conexao();        

        $email = $_SESSION['email'];
        $ip = $_SESSION['ip']; // Salva o IP do visitante
        
        // Monta a query para inserir o log no sistema
        $sql = "INSERT INTO logs (email, hora, ip, mensagem) VALUES 
        ('$email', NOW(), '$ip', '$mensagem') ";

        return $this->conexao->query($sql);

    }

    public function consultarLogs(){

        //$c = new conectar();
        //$conexao = $c->conexao();

        $sql = "SELECT c.*, DATE_FORMAT(hora,'%d/%m/%Y %H:%i:%s') AS hora, a.idusuario FROM sistema.logs c, tbusuarios a WHERE a.email = c.email;";
        $sql = $this->conexao->query($sql);  

        $dados = array();

        while ($row = $sql->fetch_assoc()){
            $dado = array();
            $dado['idusuario'] = $row['idusuario'];
            $dado['email'] = $row['email'];
            $dado['hora'] = $row['hora'];
            $dado['ip'] = $row['ip'];
            $dado['mensagem'] = $row['mensagem'];

            $dados[] = $dado;
        }

        return $dados;

    }

    public function registrarUsuario($dados){
            //$c = new conectar();
            ////$conexao=$c->conexao();

            $sql = "SELECT count(*) as total from tbusuarios WHERE email = '$dados[1]' ";
            $sql = $this->conexao->query($sql);
            $row = $sql->fetch_assoc();

            if($row['total'] >= 1){
                return 0;
            }elseif($dados[2] != $dados[3]){
                return 2;
            }elseif($dados[6] == 'ND'){
                return 3;
            }else{

            $sqlins = "INSERT INTO tbusuarios (nome, email, senha, senha_confirma, dt_nascimento, telefone, data_criacao, habilitado, idpermissao) VALUES 
            ('$dados[0]', '$dados[1]', '$dados[2]', '$dados[3]', '$dados[4]', '$dados[5]', NOW(), 'S', '$dados[6]' )";

            return $this->conexao->query($sqlins);

            }
    }

    public function Login($dados){
        // //$c = new conectar();
        // //$conexao = $c->conexao();

        $email = $dados[0];
        $senha = md5($dados[1]);

        $sql = "SELECT a.*, c.permissao FROM tbusuarios a, tbpermissao c WHERE email = '$email' and senha = '$senha' and a.idpermissao = c.idpermissao limit 1 ";
        $row = $this->ExecutaConsulta($this->conexao, $sql);

        // print_r($sql);

        // $sql=ExecutaConsulta($this->conecta,$sql);
        // $sql = $this->conexao->query($sql);
        // $sql = $this->conexao->query($sql);
        // $row = $sql->fetch_assoc();
        // print_r($row);      

        if ($row) {
            $_SESSION['chave_acesso'] = md5('@wew67434$%#@@947@@#$@@!#54798#11a23@@dsa@!');
            $_SESSION['email'] = $email;
            $_SESSION['nome'] = $row['nome'];
            $_SESSION['permissao'] = $row['permissao'];
            $_SESSION['idpermissao'] = $row['idpermissao'];
            $_SESSION['last_time'] = time();
            $_SESSION['usuid'] = $row['idusuario'];
            $_SESSION['ip'] = $_SERVER["REMOTE_ADDR"];
            $mensagem = "O Usuário $email efetuou login no sistema!";
            $this->salvaLog($mensagem);
            return 1;
        }else{
            return 0;
        }

    }

    public function registrarCliente($dados){

        //$c = new conectar();
        //$conexao = $c->conexao();

        $nome = $dados[0];
        $rg = $dados[1];
        $dt_nascimento = $dados[2];
        $telefone = $dados[3];
        $usuid = $_SESSION['usuid'];

        $sql = "SELECT count(*) as total from tbclientes WHERE rg = '$rg' ";
        $sql = $this->conexao->query($sql);
        $row = $sql->fetch_assoc();

        if($row['total'] == 1){
            return 0;
        }else{

        $sql = "INSERT INTO tbclientes (nome, rg, telefone, dt_nascimento, data_cadastro, usuid, habilitado) VALUES 
        ('$nome', '$rg', '$telefone', '$dt_nascimento', NOW(), '$usuid', 'S') ";

        $mensagem = "O Usuário ".$_SESSION['email']." cadastrou o Cliente $nome ";
        $this->salvaLog($mensagem);

        return $this->conexao->query($sql);

        }

    }

    public function consultarCategoria(){

        //$c = new conectar();
        //$conexao = $c->conexao();

        $sql = "SELECT * from tbcategorias order by idcategoria; ";
        $sql = $this->conexao->query($sql);

        $dados = array();

        while ($row = $sql->fetch_assoc()) {            
           $dado = array();
           $dado['idcategoria'] = $row["idcategoria"];
           $dado['nome'] = $row["nome"];
           $dado['habilitado'] = $row["habilitado"];
           $dados[] = $dado;
        }

        return $dados;

        
    }

    public function adicionarCategoria($categoria, $habilitado){

        //$c = new conectar();
        //$conexao = $c->conexao();

        $sql = "SELECT count(*) as total from tbcategorias where nome='$categoria' ";
        $sql = $this->conexao->query($sql);
        $row = $sql->fetch_assoc();

        if ($row['total'] == 1) {
            return 0;
        }elseif(empty($categoria) || $habilitado=="ND") {
            return 2;
        }else{
            $sql = "INSERT INTO tbcategorias (nome, habilitado) VALUES ('$categoria','$habilitado')";

            return $this->conexao->query($sql);

        
        }

    }

    public function atualizarCategoria($idcategoria, $categoria, $habilitado){

        //$c = new conectar();
        //$conexao = $c->conexao();

        $sql = "SELECT count(*) as total from tbcategorias where nome='$categoria' ";
        $sql = $this->conexao->query($sql);

        if(empty($categoria)) {
            return 2;
        }else{

            $sql = "UPDATE tbcategorias SET nome = '$categoria', habilitado = '$habilitado' WHERE idcategoria = '$idcategoria' ";

            echo $this->conexao->query($sql);
        
        }

    }

    public function excluirCategoria($idcategoria){

        //$c = new conectar();
        //$conexao = $c->conexao();

        $sql = "DELETE FROM tbcategorias WHERE idcategoria = '$idcategoria' ";

        return $this->conexao->query($sql);


    }


    public function atualizarClientes($reg,$nome,$rg,$telefone,$dtnascimento,$habilitado){

        //$c = new conectar();
        //$conexao = $c->conexao();

        $usuid = $_SESSION['usuid'];
        $_SESSION['nomeAnterior'] = $nome;

        $sql = "SELECT reg,rg FROM tbclientes c WHERE reg = '$reg' ";
        $sql = $this->conexao->query($sql);
        $row = $sql->fetch_assoc();

        if (empty($nome) || empty($rg) || empty($telefone) || empty($dtnascimento)){
            return 2;
        }else if($rg != $row['rg']){
            $sql = "SELECT count(*) as existe FROM tbclientes c WHERE rg = '$rg' ";
            $sql = $this->conexao->query($sql);
            $row = $sql->fetch_assoc();

            if ($row['existe'] >= 1 ) {
                return 0;
            }else{             

                $sql = "UPDATE tbclientes SET nome = '$nome', rg = '$rg', telefone = '$telefone', dt_nascimento = '$dtnascimento', habilitado = '$habilitado', modificado = NOW(), usuid = '$usuid' WHERE reg = '$reg'";
                echo $this->conexao->query($sql);

                $mensagem = "O Usuário ".$_SESSION['email']." atualizou o Cliente para $nome ";
                $this->salvaLog($mensagem);
            }
            
        }else{            

            $sql = "UPDATE tbclientes SET nome = '$nome', rg = '$rg', telefone = '$telefone', dt_nascimento = '$dtnascimento', habilitado = '$habilitado', modificado = NOW(), usuid = '$usuid' WHERE reg = '$reg'";

            echo $this->conexao->query($sql);

            $mensagem = "O Usuário ".$_SESSION['email']." atualizou o Cliente para $nome ";
            $this->salvaLog($mensagem);

        }

        

    }

    public function excluirCliente($reg){

        //$c = new conectar();
        //$conexao = $c->conexao();

        $sql = "DELETE FROM tbclientes WHERE reg = '$reg' ";        
        
        $mensagem = "O Usuário ".$_SESSION['email']." excluiu o Cliente com o REG $reg ";
        $this->salvaLog($mensagem);

        return $this->conexao->query($sql);         
        

    }

    public function adicionarProdutos($categoria, $nome, $referencia, $preco, $habilitado){

        //$c = new conectar();
        //$conexao = $c->conexao();

        $preco = str_replace(",", ".", $preco);

        $usuid = $_SESSION['usuid'];

        $sql = "SELECT * FROM tbproduto where referencia = '$referencia' ";
        $sql = $this->conexao->query($sql);
        $row = $sql->num_rows;

        

        if ($row >= 1) {
            return 0;
        }elseif ($categoria == "ND") {
            return 2;
        }else {
            $sql = "INSERT INTO tbproduto (referencia, idcategoria, preco, descricao, habilitado, usuid) VALUES ('$referencia', '$categoria', '$preco', '$nome', '$habilitado', '$usuid')";
        
            return $this->conexao->query($sql);
        }

    }

    public function consultarCliente(){

        //$c = new conectar();
        //$conexao = $c->conexao();

        $sql = "SELECT * FROM tbclientes order by nome; ";
        $sql = $this->conexao->query($sql);

        $dados = array();

        while ($row = $sql->fetch_array()) {           
           $dado = array();
           $dado['reg'] = $row["reg"];
           $dado['nome'] = $row["nome"];
           $dado['rg'] = $row["rg"];
           $dado['telefone'] = $row["telefone"];
           $dado['dt_nascimento'] = $row["dt_nascimento"];
           $dado['habilitado'] = $row["habilitado"];
           $dados[] = $dado;
        }      

        return $dados; 
        
    }


    public function ultimosPedidos(){

        //$c = new conectar();
        //$conexao = $c->conexao();


        $sql = "SELECT a.*, c.nome,date_format(data_inc, '%H:%i') AS hora FROM tbpedidos a,tbclientes c where c.reg = a.reg and a.status = 'A' order by a.idpedido desc;";
        $sql = $this->conexao->query($sql);

        $dados = array();

        while ($row = $sql->fetch_assoc()) {
           
           $dado = array();

           $dado['idpedido'] = $row["idpedido"];
           $dado['comanda'] = $row["comanda"];
           $dado['reg'] = $row["reg"];
           $dado['tipo'] = $row["tipo"];
           $dado['nome'] = $row["nome"];
           $dado['status'] = $row["status"];
           $dado['titulo'] = $row["titulo"];
           $dado['hora'] = $row["hora"];
           $dado['valor'] = number_format($row["valor"], 2, ",", ".");
           $dados[] = $dado;

        }

        return $dados;

    }

    public function consultarUsuario(){
        //$c = new conectar();
        //$conexao = $c->conexao();

        $sql = "SELECT c.*, a.permissao FROM tbusuarios c, tbpermissao a where c.idpermissao = a.idpermissao order by c.nome";
        $sql = $this->conexao->query($sql);

        $dados = array();

        while ($row = $sql->fetch_assoc()) {
            $idusuario = $row["idusuario"];
            $nome = $row["nome"];
            $email = $row["email"];
            $dtnascimento = $row["dt_nascimento"];
            $telefone = $row["telefone"];
            $dtnascimento = $row["dt_nascimento"];
            $habilitado = $row["habilitado"];
            $permissao = $row["permissao"];    
            $idpermissao = $row["idpermissao"];  

           $dado = array();
           $dado['idusuario'] = $idusuario;
           $dado['nome'] = $nome;
           $dado['email'] = $email;
           $dado['senha'] = $row['senha'];
           $dado['senha_confirma'] = $row['senha_confirma'];
           $dado['idpermissao'] = $idpermissao;
           $dado['permissao'] = $permissao;
           $dado['telefone'] = $telefone;
           $dado['dtnascimento'] = $dtnascimento;
           $dado['habilitado'] = $habilitado;          
           $dados[] = $dado;
        }

        return $dados;

    }

    public function atualizarUsuarios($idusuario, $nome, $email, $senha, $senha_confirma, $telefone, $dtnascimento, $habilitado, $idpermissao){

        //$c = new conectar();
        //$conexao = $c->conexao();

        $sql = "SELECT count(*) as total from tbusuarios WHERE email = '$email' ";
        $sql = $this->conexao->query($sql);
        $row = $sql->fetch_assoc();
        
        if($senha != $senha_confirma){
            return 2;
        }elseif ($senha == '' || $senha == null && $senha_confirma == '' || $senha_confirma == null ) {
            $sql = "UPDATE tbusuarios SET nome = '$nome', email='$email', dt_nascimento='$dtnascimento', telefone='$telefone', data_modificado = NOW(), habilitado='$habilitado', idpermissao='$idpermissao' WHERE idusuario = '$idusuario' ";
            echo $this->conexao->query($sql);
        }else{
            $sql = "UPDATE tbusuarios SET nome = '$nome', email='$email', senha='$senha', senha_confirma='$senha_confirma' dt_nascimento='$dtnascimento', telefone='$telefone', data_modificado = NOW(), habilitado='$habilitado', idpermissao='$idpermissao' WHERE idusuario = '$idusuario' ";

            echo $this->conexao->query($sql);
        }
    }  
    
    public function excluirUsuarios($idusuario){
        //$c = new conectar();
        //$conexao = $c->conexao();

        $sql = "DELETE FROM tbusuarios WHERE idusuario = '$idusuario' ";

        return $this->conexao->query($sql);
    }

    public function consultarProdutos(){
        //$c = new conectar();
        //$conexao = $c->conexao();

        $sql = "SELECT c.nome,a.* FROM tbproduto a, tbcategorias c where a.idcategoria = c.idcategoria order by a.referencia";
        $sql = $this->conexao->query($sql);
        $dados = array();

        while ($row = $sql->fetch_assoc()) {

            $idproduto = $row['id'];
            $nome = $row['nome'];
            $referencia = $row['referencia'];
            $idcategoria = $row['idcategoria'];
            $preco = $row['preco'];
            $descricao = $row['descricao'];
            $habilitado = $row['habilitado'];

            $dado = array();
            $dado['idproduto'] = $idproduto;
            $dado['idcategoria'] = $idcategoria;
            $dado['nome'] = $nome;
            $dado['referencia'] = $referencia;
            $dado['descricao'] = $descricao;
            $dado['preco'] = $preco;
            $dado['habilitado'] = $habilitado;
            $dados[] = $dado;
        }

        return $dados;

    }


    public function atualizarProdutos($idproduto, $idcategoria, $descricao, $referencia, $preco, $habilitado){
        //$c = new conectar();
        //$conexao = $c->conexao();

        $usuid = $_SESSION['usuid'];
        
        $preco = str_replace(",", ".", $preco);

        if ($idcategoria == null || $descricao == "" || $referencia == "" || $preco == "" || $habilitado == "") {
            return 0;
        }else{

       $sql = "UPDATE tbproduto SET referencia = '$referencia', idcategoria = '$idcategoria', preco = '$preco', descricao = '$descricao', habilitado = '$habilitado', modificado = NOW(), usuid = '$usuid' WHERE id = '$idproduto'  ";

        echo $this->conexao->query($sql);
        }

    }

    public function excluirProdutos($idproduto, $referencia){
        //$c = new conectar();
        //$conexao = $c->conexao();

        $sql = "DELETE FROM tbproduto WHERE id = '$idproduto' and referencia = '$referencia' ";

        return $this->conexao->query($sql);


    }


    public function gerarVenda($titulo){
        //$c = new conectar();
        //$conexao = $c->conexao();


        $sql = "INSERT INTO tbpedidos (reg, tipo, titulo, data_inc) VALUES ('99','V','$titulo', NOW()) ";

        return $this->conexao->query($sql);


    }

    public function ultimoPedido(){
        //$c = new conectar();
        //$conexao = $c->conexao();

        $query = "SELECT max(idpedido)idpedido FROM tbpedidos c;";
        $query = $this->conexao->query($query);
        $row = $query->fetch_assoc();

        return $row;

    }

    public function listaCategoria(){
        //$c = new conectar();
        //$conexao = $c->conexao();

        $sql = "SELECT * from tbcategorias order by idcategoria";
        $sql = $this->conexao->query($sql);

        while ($row = $sql->fetch_assoc()) {
            $data[] = $row;
        }
        
        
    return $data;

    }

    public function pegarProdutos($idcategoria){
        //$c = new conectar();
        //$conexao = $c->conexao();

        $sql = "SELECT * from tbproduto where idcategoria = '$idcategoria' and habilitado = 'S'";
        $sql = $this->conexao->query($sql);
        
        $option2 = '<option value="" selected>Selecione o Produto</option>';
        $data[] = $option2;

        while ($row = $sql->fetch_array()) {
            $option = '<option value="' .$row['referencia']. '" >' .$row['descricao']. '</option>';
            
            $data[] = $option;
        }

    echo json_encode($data);

    }

    public function pegaDescProdutos($referencia){
        //$c = new conectar();
        //$conexao = $c->conexao();

        $sql = "SELECT c.referencia,c.descricao,c.preco,c.habilitado FROM tbproduto c where c.referencia = '$referencia' and c.habilitado = 'S'";
        $sql = $this->conexao->query($sql);
        $row = $sql->fetch_array();

        $preco = $row['preco'];
        $descricao = $row['descricao'];

        $ar = array(
            'referencia'=>$referencia,
            'preco'=>$preco,
            'descricao'=>$descricao
        );
        

    echo json_encode($ar);

    }

    public function listarItens($idpedido){

        //$c = new conectar();
        //$conexao = $c->conexao();

        $sql = "SELECT c.* from tbproduto b, tbpedidos_item c where b.descricao = c.descricao and c.idpedido = '$idpedido' and b.habilitado='S' order by iditem ";

        $sql = $this->conexao->query($sql);
        $dados = array();

        while ($row = $sql->fetch_assoc()) {
            $bruto = 0;
            $iditem = $row['iditem'];
            $idpedido = $row['iditem'];
            $referencia = $row['referencia'];
            $descricao = $row['descricao'];
            $quantidade = $row['quantidade'];
            $preco = $row['valor'];
            $bruto = $preco * $quantidade;
            $btn = "<span class='btn btn-dark text-white' data-toggle='modal' data-target='#AtualizaItens' title='Editar' id='btnAtualizaItens' data-iditem='".$iditem."' data-descricao='".$descricao."' data-referencia='".$referencia."' data-qtde='".$quantidade."'><i class='fas fa-pencil-alt'></i></span>";
            $btn .= "<span class='btn btn-danger text-white' id='btnExcluirItem' data-iditem='".$iditem."' ><i class='far fa-trash-alt'></i></span>";

            $preco = number_format($preco, 2, ",", ".");
            $bruto = number_format($bruto, 2, ",", ".");
            //$resultado = number_format($resultado, 2, ",", ".");

            $dado = array();
            $dado['referencia'] = $referencia;
            $dado['descricao'] = $descricao;
            $dado['quantidade'] = $quantidade;
            $dado['valor'] = $preco;
            $dado['bruto'] = $bruto;
            $dado['btn'] = $btn;
            $dados[] = $dado;
        }
        
        return $dados;
        
    }

    public function atualizarQuantidade($idpedido, $iditem, $referencia, $quantidade){
        //$c = new conectar();
        //$conexao = $c->conexao();

        $sql = "UPDATE tbpedidos_item SET quantidade = '$quantidade' WHERE idpedido = '$idpedido' and iditem= '$iditem' ";

        return $this->conexao->query($sql);
    }

    public function adicionarProduto($idpedido, $referencia, $preco, $qtde, $descricao){
        //$c = new conectar();
        //$conexao = $c->conexao();

        $sql = "SELECT c.iditem,c.quantidade, count(*) as existe FROM sistema.tbpedidos_item c where idpedido = '$idpedido' and referencia = '$referencia';";
        $sql = $this->conexao->query($sql);
        $row = $sql->fetch_assoc();

        if ($row['existe'] >= 1) {
            $qtde = $row['quantidade'] + $qtde;
            $iditem = $row['iditem'];
            $sql = "UPDATE tbpedidos_item SET referencia = '$referencia', descricao = '$descricao', quantidade = '$qtde', valor = '$preco' WHERE idpedido = '$idpedido' and iditem= '$iditem' ";
        }else{
            $sql = "INSERT INTO tbpedidos_item (idpedido, referencia, descricao, quantidade, valor) VALUES ('$idpedido', '$referencia', '$descricao', '$qtde', '$preco')";
        }

        return $this->conexao->query($sql);

    }

    public function excluirItem($idpedido, $iditem){
        //$c = new conectar();
        //$conexao = $c->conexao();
        
        $sql = "DELETE FROM tbpedidos_item WHERE idpedido = '$idpedido' and iditem = '$iditem' ";

        return $this->conexao->query($sql);
    }

    public function totalMes(){
        //$c = new conectar();
        //$conexao = $c->conexao();

        $sql = " SELECT ifnull(sum(c.valor+c.troco),0) as total from tbpedido_pagamento c WHERE MONTH(c.data_pagamento) = MONTH(now()) and c.status = 'F';";
        $rstotal = $this->conexao->query($sql);
        $result = $rstotal->fetch_assoc();
        $totalgeral = $result['total'];

        return $totalgeral;
    }
    
    public function vendasMes(){
        //$c = new conectar();
        //$conexao = $c->conexao();

        $sql = " SELECT ifnull(count(*),0) as vendames FROM tbpedidos c WHERE MONTH(c.data_finaliza) = MONTH(now()) and c.status = 'F';";
        $rsvendames = $this->conexao->query($sql);
        $result2 = $rsvendames->fetch_array();
        $totalmes = $result2['vendames'];

        return $totalmes;
    }

    public function totalDia(){
        //$c = new conectar();
        //$conexao = $c->conexao();

        $sql = " SELECT ifnull(sum(c.valor),0) as total, ifnull(sum(c.troco),0) as troco from tbpedido_pagamento c WHERE DAY(c.data_pagamento) = DAY(now()) and c.status = 'F';";
        $rstotal = $this->conexao->query($sql);
        $result = $rstotal->fetch_array();
        $totalvendas = $result['total'];
        $totaltroco = $result['troco'];

        $total = array(
          'totalvendas' => '',
          'totaltroco' => '',
        );

        $total['totalvendas'] = $totalvendas;
        $total['totaltroco'] = $totaltroco;

        //print_r($total);
        return $total;

    }

    public function vendasHoje(){
        //$c = new conectar();
        //$conexao = $c->conexao();

        $sql = "SELECT ifnull(count(*),0) as total FROM tbpedidos c WHERE DAY(c.data_finaliza) = Day(now()) and c.status = 'F';";
        $rsvendahj = $this->conexao->query($sql);
        $result = $rsvendahj->fetch_array();
        $vendashoje = $result['total'];

        return $vendashoje;
    }

    public function totCadastrosMes(){
        //$c = new conectar();
        //$conexao = $c->conexao();

        $sql = "SELECT ifnull(count(*),0) as total FROM tbclientes a WHERE MONTH(a.data_cadastro) = Month(now());";
        $rsclimes = $this->conexao->query($sql);
        $result = $rsclimes->fetch_array();
        $rstotclimes = $result['total'];

        return $rstotclimes;
    }

    public function totClientesCadastrados(){
        //$c = new conectar();
        //$conexao = $c->conexao();

        $sql = "SELECT ifnull(count(*),0) as total FROM tbclientes ";
        $rsclitot = $this->conexao->query($sql);
        $result = $rsclitot->fetch_array();
        $rstotcli = $result['total'];

        return $rstotcli;
    }

    public function adicionarPermissao($permissao, $habilitado){
        //$c = new conectar();
        //$conexao = $c->conexao();

        $sql = "SELECT count(*) as total FROM tbpermissao WHERE permissao = '$permissao' ";
        $sql = $this->conexao->query($sql);
        $row = $sql->fetch_assoc();

        if ($row['total'] >= 1) {
            return 0;
        }else {
            $sql = "INSERT INTO tbpermissao (permissao, habilitado) VALUES ('$permissao','$habilitado') ";
        }

        return $this->conexao->query($sql);

    }

    public function consultarPermissao(){
        //$c = new conectar();
        //$conexao = $c->conexao();

        $sql = "SELECT * from tbpermissao where permissao <> 'SUPER-ADMIN' order by idpermissao;";
        $sql = $this->conexao->query($sql);

        $dados = array();

        while ($row = $sql->fetch_assoc()) {
            $idpermissao = $row["idpermissao"];
            $permissao = $row["permissao"];
            $habilitado = $row["habilitado"];
    
            if ($habilitado == "S") {
                $habilitado = ' <span class="badge badge-success text-center">Sim</span>';
            }else{
                $habilitado = '<span class="badge badge-danger text-center">Não</span>';
            }
            $btn = "<a href='grupo_paginas.php?idpagina=" .$idpermissao." ' class='btn btn-primary text-white' title='Paginas' ><i class='fas fa-user-lock'></i></a>";
            $btn .= "<span class='btn btn-dark text-white' data-toggle='modal' data-target='#atualizaPermissao' title='Editar' id='btnAtualizaPermissao' data-idpermissao='".$idpermissao."' data-permissao='".$permissao."' data-habilitado='".$row["habilitado"]."'><i class='fas fa-pencil-alt'></i></span>";
            $btn .= "<span class='btn btn-danger text-white' id='btnExcluirPermissao' title='Excluir' onclick='eliminarCategoria(".$idpermissao.")' ><i class='far fa-trash-alt'></i></span>";
           
           $dado = array();
           $dado[] = $idpermissao;
           $dado[] = $permissao;
           $dado[] = $habilitado;
           $dado[] = $btn;
           $dados[] = $dado;
        }

        echo json_encode($dados);

    }

    public function atualizarPermissao($idpermissao,$permissao,$habilitado){
        //$c = new conectar();
        //$conexao = $c->conexao();

        $sql = "SELECT permissao from tbpermissao where permissao='$permissao' ";
        $sql = $this->conexao->query($sql);
        $row = $sql->fetch_assoc();

        if(empty($permissao)) {
            return 2;
        }else if($permissao != $row['permissao']){
            $sql = "SELECT count(*) as total from tbpermissao where permissao='$permissao' ";
            $sql = $this->conexao->query($sql);
            $row = $sql->fetch_assoc();

            if ($row['total'] >= 1) {
                return 0;
            }else {
                $sql = "UPDATE tbpermissao SET permissao = '$permissao', habilitado = '$habilitado' WHERE idpermissao = '$idpermissao' ";

                echo $this->conexao->query($sql);
            }

        }else{

            $sql = "UPDATE tbcategorias SET nome = '$permissao', habilitado = '$habilitado' WHERE idcategoria = '$idpermissao' ";

            echo $this->conexao->query($sql);
        
        }


    }

    public function excluirPermissao($idpermissao){

        //$c = new conectar();
        //$conexao = $c->conexao();

        $sql = "DELETE FROM tbpermissao WHERE idpermissao = '$idpermissao' ";

        return $this->conexao->query($sql);


    }

    public function adicionarTela($nomeTela,$idpermissao){
        //$c = new conectar();
        //$conexao = $c->conexao();

        $sql = "SELECT count(*) as existe FROM tbpermissao_pages WHERE idpermissao = '$idpermissao' and permissao_pages = '$nomeTela' ";
        $sql = $this->conexao->query($sql);
        $row = $sql->fetch_assoc();

        if ($row['existe'] >= 1) {
           $sql = "DELETE FROM tbpermissao_pages WHERE idpermissao = '$idpermissao' and permissao_pages = '$nomeTela' ";
        }else{
           $sql = "INSERT INTO tbpermissao_pages (idpermissao, permissao_pages) VALUES ('$idpermissao','$nomeTela')";
            
        }

        return $this->conexao->query($sql);

    }

    public function registrarPaginas($nome, $url){
        //$c = new conectar();
        //$conexao = $c->conexao();

        $sql = "SELECT count(*) as existe FROM tbpaginas WHERE paginas like '$url%' ";
        $sql = $this->conexao->query($sql);
        $row = $sql->fetch_assoc();

        if ($row['existe'] >= 1) {
            return 0;
        }else{
            $sql = "INSERT INTO tbpaginas (paginas, nome_paginas) VALUES ('$url','$nome')";
            
        }

        return $this->conexao->query($sql);

    }

    public function consultaPaginas(){
        //$c = new conectar();
        //$conexao = $c->conexao();

        $sql = "SELECT * FROM tbpaginas order by idpaginas";
        $sql = $this->conexao->query($sql);
        $dados = array();

        while ($row = $sql->fetch_assoc()) {

            $dado = array();
            $dado['idpaginas'] = $row['idpaginas'];
            $dado['paginas'] = $row['nome_paginas'];
            $dado['url'] = $row['paginas'];
            $dados[] = $dado;
        }

        return $dados;

    }

    public function excluirPaginas($idpaginas){

        //$c = new conectar();
        //$conexao = $c->conexao();

        $sql = "DELETE FROM tbpaginas WHERE idpaginas = '$idpaginas' ";

        return $this->conexao->query($sql);


    }

    public function AtualizarPaginas($idpaginas,$pagina,$url){

        //$c = new conectar();
        //$conexao = $c->conexao();

        $sql = "UPDATE tbpaginas SET paginas='$url', nome_paginas='$pagina' WHERE idpaginas = '$idpaginas' ";

        return $this->conexao->query($sql);


    }

    public function formaPagamento($idpedido){
        //$c = new conectar();
        //$conexao = $c->conexao();

        $sql = "SELECT a.nome,b.* FROM tbclientes a, tbpedidos b where a.reg = b.reg and idpedido = '$idpedido' ";
        $sql = $this->conexao->query($sql);
        $row = $sql->fetch_assoc();
        $dados = array();

            $dado = array();
            $dado['nome'] = $row['nome'];
            $dado['idpedido'] = $row['idpedido'];
            $dado['comanda'] = $row['comanda'];
            $dado['reg'] = $row['reg'];
            $dado['status'] = $row['status'];
            $dado['valor'] = number_format($row['valor'],2, ",", ".");
            $dado['tipo'] = $row['tipo'];
            $dado['titulo'] = strtoupper($row['titulo']);
            $dado['comanda'] = $row['comanda'];
            $dados[] = $dado;

            return $dados;

    }

    public function excluirPedidos($idpedido,$idcomanda){
        //$c = new conectar();
        //$conexao = $c->conexao();

        $sql1 = "UPDATE tbpedidos SET status='D' WHERE idpedido='$idpedido' ";        

        $this->atualizaComanda($idcomanda);

        $this->deletaPagamento($idpedido);

        return $this->conexao->query($sql1);
        
    }

    function atualizaComanda($idcomanda){
        //$c = new conectar();
        //$conexao = $c->conexao();

        $sql = "UPDATE tbcomanda SET status='A' WHERE idcomanda='$idcomanda' ";

        $mensagem = "A Comanda $idcomanda pode ser usada novamente!";
        $this->salvaLog($mensagem);

        return $this->conexao->query($sql);
    }
    
    function deletaPagamento($idpedido){
        //$c = new conectar();
        //$conexao = $c->conexao();

        $sql = "UPDATE tbpedido_pagamento SET status='D' WHERE idpedido ='$idpedido' ";

        $mensagem = "O Pagamento do Pedido $idpedido foi deletado!";
        $this->salvaLog($mensagem);

        return $this->conexao->query($sql);
    }

    public function adicionarForma($idpedido,$forma,$tipo,$valor,$valorrecebido){
        //$c = new conectar();
        //$conexao = $c->conexao();

        $valor=str_replace(",",".",$valor);
        $valorrecebido=str_replace(",",".",$valorrecebido);

        $troco = $valor - $valorrecebido;
        $troco=str_replace(",",".",$troco);

        if(($valor == "0") or ($forma == "")) {
            return 2; //Insira um Valor ou Forma de Pagamento em Branco!
        }else{

            if($forma == "R$"){

                $sql = "INSERT INTO tbpedido_pagamento (idpedido, forma, valor, troco, tipo) VALUES ('$idpedido', '$forma', '$valor', '$troco', '$tipo') ";
        
                return $this->conexao->query($sql);
        
            }else{

                $sql = "INSERT INTO tbpedido_pagamento (idpedido, forma, valor, troco, tipo) VALUES ('$idpedido', '$forma', '$valor', '0', '$tipo') ";

                return $this->conexao->query($sql);

            }

        }

    }

    public function listarFormasPagamento($idpedido){
        //$c = new conectar();
        //$conexao = $c->conexao();

        $sql = "SELECT * FROM tbpedido_pagamento c,tbformas_pagamento b where c.idpedido = '$idpedido' and c.forma = b.idforma_pagamento; ";
        $sql = $this->conexao->query($sql);
        $row = $sql->fetch_assoc();
        $dados = array();
            

            $troco = number_format($row['troco'],2,",", ".");
            $valor = number_format($row['valor'],2, ",", ".");
            $dado = array();
            $dado['forma'] = $row['forma'];
            $dado['forma_descricao'] = $row['forma_descricao'];
            $dado['troco'] =  $troco;
            $dado['status'] = $row['status'];
            $dado['valor'] = $valor;
            $dado['idforma'] = $row['idforma'];
            $dado['idpedido'] = $row['idpedido'];
            $dados[] = $dado;

        return $dados;

    }

    public function pegarCategoria(){
        //$c = new conectar();
        //$conexao = $c->conexao();

        $sql = "SELECT * from tbcategorias order by idcategoria";
        $result3 = $this->conexao->query($sql);
        while ($rows_rscat = $result3->fetch_assoc()) { 
            $option = '<option value="'.$rows_rscat['idcategoria'].'">'.$rows_rscat['idcategoria'].' - '.$rows_rscat['nome'].'</option>';
            $arr[] = $option;
        } 

        return $arr;
    }

    public function pegarPermissao(){
        //$c = new conectar();
        ////$conexao=$c->conexao();
        
        $sql = "SELECT * from tbpermissao where permissao <> 'SUPER-ADMIN' order by idpermissao";
        $sql = $this->conexao->query($sql);
        while ($rows_rsperm = mysqli_fetch_assoc($sql)) { 
            $option[] = '<option value="'.$rows_rsperm['idpermissao'].'">'.$rows_rsperm['permissao'].'</option>';
        } 

        return $option;
    }


}


?>