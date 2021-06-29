<?php 
require_once "menu_layout.php" ;
require_once "Connections/conexao.php";
require_once "classes/class.vision.php";

    $obj = new vision();

?>

 <style>
.oculto {
    display: none;
}
.loading{
    min-height: 150px;
}


 </style>

 <section role="main" class="content-body">
     <header class="page-header page-header-left-breadcrumb">
        <?php if (isset($_SESSION['validaPermissao'])) { ?>         
        <div class="col-lg-12">
            <div class="center">
                   <?php echo $_SESSION['validaPermissao']; ?>
            </div>
        </div>
        <?php unset($_SESSION['validaPermissao']); } ?>

        <?php if(in_array('home.php', $nomeGrupo) || $_SESSION['permissao'] == "SUPER-ADMIN") { ?>

        <div class="right-wrapper">
            <ol class="breadcrumbs">
                <li>
                    <a href="#">
                        <i class="fas fa-home"></i>
                    </a>
                </li>
                <li><span>Dashboard</span></li>
            </ol>
        </div>
        <h2>Painel Geral</h2>
     </header>
     
     <!-- start: page -->
     <div class="row">
         <div class="col-xl-12 order-1 mb-4">
             <section class="card">
                 <div class="text-left">
                     <a class="btn btn-dark text-white" href="nova_venda.php" style="border:none;"><i
                             class="fas fa-plus"></i> Novo Pedido</a>
                     <a class="btn btn-primary text-white" href="pedidos_finalizados.php" style="border:none;"><i
                             class="fas fa-check-circle"></i> Pedidos Finalizados</a>
                 </div>
                 <header class="card-header card-header-transparent">
                     <h2 class="card-title">Últimos Pedidos</h2>
                 </header>
                 <div class="card-body">
                     <div class="col-lg-12">
                         <div class="center">
                             <div id="alert_ok" class="alert alert-success oculto">

                             </div>
                         </div>
                     </div>
                     <div class="col-lg-12">
                         <div class="center">
                             <div id="alert_error" class="alert alert-danger oculto">

                             </div>
                         </div>
                     </div>               
                     <table class="table table-responsive-md table-hover mb-0" id="ultimosPedidos">
                        <thead>
                            <tr>
                                <th>Pedido</th>
                                <th>Comanda</th>
                                <th>Nome</th>                                
                                <th>Status</th>  
                                <th>Titulo</th>
                                <th>Hora</th>
                                <th>Valor</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                     </table>
                 </div>
             </section>
         </div>
     </div>
     <div class="row">
         <div class="col-md-12">
             <div class="row mb-3">
                 <div class="col-xl-6">
                     <section class="card card-featured-left card-featured-danger mb-3">
                         <div class="card-body">
                             <div class="widget-summary">
                                 <div class="widget-summary-col widget-summary-col-icon">
                                     <div class="summary-icon bg-danger">
                                         <i class="fas fa-life-ring"></i>
                                     </div>
                                 </div>
                                 <div class="widget-summary-col">
                                     <div class="summary">
                                         <h4 class="title">Total Vendido no Mês</h4>
                                         <div class="info">
                                             <strong class="amount">R$ <?php echo $obj->totalMes() ?></strong>
                                         </div><br>
                                         <h4 class="title">Vendas no Mês</h4>
                                         <div class="info">
                                             <strong class="amount"><?php echo $obj->vendasMes() ?></strong>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                     </section>
                 </div>
                 <div class="col-xl-6">
                     <section class="card card-featured-left card-featured-success">
                         <div class="card-body">
                             <div class="widget-summary">
                                 <div class="widget-summary-col widget-summary-col-icon">
                                     <div class="summary-icon bg-success">
                                         <i class="fas fa-dollar-sign"></i>
                                     </div>
                                 </div>
                                 <div class="widget-summary-col">
                                        <?php
                                            $result =  $obj->totalDia();
                                        ?>
                                     <div class="summary">
                                         <h4 class="title">Total Recebido no Dia</h4>
                                         <div class="info">
                                             <strong class="amount">R$ <?php echo $result['totalvendas'] ?></strong>
                                         </div><br>
                                         <h4 class="title">Saídas / Troco no Dia</h4>
                                         <div class="info">
                                             <strong class="amount">R$ <?php echo $result['totaltroco'] ?></strong>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                     </section>
                 </div>
             </div>
             <div class="row">
                 <div class="col-xl-6">
                     <section class="card card-featured-left card-featured-tertiary mb-3">
                         <div class="card-body">
                             <div class="widget-summary">
                                 <div class="widget-summary-col widget-summary-col-icon">
                                     <div class="summary-icon bg-tertiary">
                                         <i class="fas fa-shopping-cart"></i>
                                     </div>
                                 </div>
                                 <div class="widget-summary-col">
                                     <div class="summary">
                                         <h4 class="title">Vendas de Hoje</h4>
                                         <div class="info">
                                             <strong class="amount"><?php echo $obj->vendasHoje() ?></strong>
                                         </div>
                                     </div><br><br>
                                 </div>
                             </div>
                         </div>
                     </section>
                 </div>
                 <div class="col-xl-6 mb-4">
                     <section class="card card-featured-left card-featured-quaternary">
                         <div class="card-body">
                             <div class="widget-summary">
                                 <div class="widget-summary-col widget-summary-col-icon">
                                     <div class="summary-icon bg-quaternary">
                                         <i class="fas fa-user"></i>
                                     </div>
                                 </div>
                                 <div class="widget-summary-col">
                                     <div class="summary">
                                         <h4 class="title">Cadastros no Mês</h4>
                                         <div class="info">
                                             <strong class="amount"><?php echo $obj->totCadastrosMes() ?></strong>
                                         </div><br>
                                         <h4 class="title">Total Clientes Cadastrados</h4>
                                         <div class="info">
                                             <strong class="amount"><?php echo $obj->totClientesCadastrados() ?></strong>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </section>
                 </div>
             </div>
         </div>
     </div>
     <?php 
    }else {

    } 
?>
     <!-- end: page -->
 </section>
 </div>

 </section>


 <script type="text/javascript">

$(document).on("click", "#btnExcluirPedidos", function () { //Função Modal Editar MAC
    var idpedido = $(this).attr('data-idpedido');
    var idcomanda = $(this).attr('data-idcomanda');
    alertify.confirm('Deseja excluir este Produto?', function(){ 
        $.ajax({
            type:"POST",
            data:{'idpedido': idpedido,
                'idcomanda': idcomanda,
                paramTela: 'ExcluirPedidos'
            },
            url:"classes/conect.php",
            success:function(r){
                if(r==1){
                    alertify.success("Pedido excluído com sucesso!!");
                    gerarDadosUP();
                }else{
                    alertify.error("Não foi possível Excluir esse Produto!");
                }
            }
        });
    }, function(){ 
        alertify.error('Cancelado !')
    });
});

</script>    

<script>

$(document).ready(function() {

    ultimosPedidos = $('#ultimosPedidos').DataTable({  
        "ajax":{            
            "url": "classes/conect.php", 
            "method": 'POST', //usamos el metodo POST
            "data":{
                paramTela: 'ultimosPedidos'
            }, //enviamos opcion 4 para que haga un SELECT
            "dataSrc":""
        },
        "columnDefs": [
            { className: 'text-center', targets: [0,1,2,3,4,5,6,7]},
            // { width: 15, targets: [3,4,5,6,7,8] },
            // { width: 80, targets: 1 },
        ],
        "columns":[
            {"data": "pedido"},
            {"data": "comanda"},
            {"data": "nome"},
            {"data": "status"},
            {"data": "titulo"},
            {"data": "hora"},
            {"data": "valor"},
            {"data": "btn"},
        ]
    }); 

});

</script>


 <?php 
    
    require_once "footer_layout.php";



   

    ?>