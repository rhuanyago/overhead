<?php 
include 'menu_layout.php'; 
require_once "Connections/conexao.php";
require_once "classes/class.vision.php";
$c = new conectar();
$conexao = $c->conexao();

$obj = new vision();
$result = $obj->ultimoPedido();
$idpedido = $result['idpedido'];

$listarCat = $obj->listaCategoria();
//var_dump($listarCat);

$sql = "SELECT c.* from tbproduto b, tbpedidos_item c where b.descricao = c.descricao and c.idpedido = '$idpedido' and b.habilitado='S' order by iditem";
$sql = $conexao->query($sql);

$rowListar = $obj->listarItens($idpedido);
// print_r($rowListar);
?>


<style>
.oculto{
	display:none;		
}
/* Style para o loading dos tables */

.button:disabled {
        opacity: 0.5;
      }
</style>


			<section role="main" class="content-body">
                <header class="page-header page-header-left-breadcrumb">
                    <div class="right-wrapper">
                        <ol class="breadcrumbs">
                            <li>
                                <a href="home.php">
                                    <i class="fas fa-home"></i>
                                </a>
                            </li>
                            <li><span>Nova Venda</span></li>
                            <li><span>Criar Venda</span></li>
                        </ol>


                    </div>
                </header>

                <!-- start: page -->
                <div class="row">
                    <div class="col-md-12">
                        <section class="card card-danger">
                            <header class="card-header">
                                <h2 class="card-title">Novo Pedido de Venda</h2>
                            </header>
                            <div class="card-body">
                                <div class="col-lg-12">
                                    <div class="center">
                                        <?php
                                        if (isset($_SESSION['msg_erro_venda_excluir'])) :
                                            ?>
                                            <div class="alert alert-danger">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                <strong>Atenção! <?php echo $_SESSION['msg_erro_venda_excluir'] ?></strong>
                                            </div>
                                        <?php
                                        endif;
                                        unset($_SESSION['msg_erro_venda_excluir']);
                                        ?>
                                    </div>
                                </div>
                                <form method="POST" id="frmAdicionarProdutos" action="form_pagamento.php" >
                                    <div class="row">
                                        <div class="col-sm-1">
                                            <div class="form-group">
                                                <label class="control-label  text-weight-bold">Pedido</label>
                                                <input type="text" name="idpedido" id="idpedido" value="<?php echo $idpedido; ?>" class="form-control" readonly />
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label class="control-label  text-weight-bold">Tipo</label>
                                                <input type="text" name="tipo" value="Venda" class="form-control" readonly />
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label class="control-label  text-weight-bold">Categoria</label>
                                                <select name="categoria" id="categoria" class="form-control">
                                                    <option selected>Selecione a Categoria</option>
                                                    <?php foreach ($listarCat as $key) { ?>
                                                       <option value="<?php echo $key['idcategoria'] ?>"><?php echo $key['nome']  ?></option>                                                       
                                                    <?php  }  ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label class="control-label  text-weight-bold">Produtos</label>
                                                <select name="produtos" id="produtos" class="form-control">
                                                </select>
                                            </div>
                                        </div>

                                    </div> <!-- fim row-->

                                    <div class="row">
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label class="control-label  text-weight-bold">Referência</label>
                                                <input type="text" name="referencia" id="referencia" class="form-control text-weight-bold" maxlength="8" upper readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label class="control-label  text-weight-bold">Preço</label>
                                                <input type="number" name="preco" id="preco" class="form-control text-weight-bold text-danger" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label class="control-label  text-weight-bold">Qtde</label>
                                                <div data-plugin-spinner >
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <button type="button" class="btn btn-default spinner-up">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                        </div>
                                                        <input type="number" name="qtde" id="qtde" min="1" max="200" class="spinner-input form-control" maxlength="2" readonly>
                                                        <div class="input-group-append">
                                                            <button type="button" class="btn btn-default spinner-down">
                                                                <i class="fas fa-minus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="control-label  text-weight-bold">Descrição</label>
                                                <input type="text" name="descricao" id="descricao" class="form-control text-weight-bold" readonly>
                                            </div>
                                        </div>
                                    </div> <!-- fim row -->

                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label class="control-label  text-weight-bold">Incluir</label>
                                                <input id="AdicionarProduto" class="btn btn-dark btn-block" value="Adicionar Produto" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <br />
                                            <div class="table-responsive">
                                                <table class="table table-responsive-md table-hover mb-0">
                                                    <div class="scrollable visible-slider colored-slider" data-plugin-scrollable">
                                                        <div class="scrollable-content">
                                                            <thead>

                                                                <tr>
                                                                    <th>Referência</th>
                                                                    <th>Descrição</th>
                                                                    <th class="text-center">Qtde</th>
                                                                    <th class="text-center">Preço Unit.</th>
                                                                    <th class="text-center">Preço Bruto</th>
                                                                    <th class="text-center">Opção</th>
                                                                </tr>

                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $resultado = 0;
                                                                $qtde = 0;
                                                                ?>
                                                                <?php foreach ($rowListar as $key => $row) { ?>
                                                                    <tr style="font-size:14px;">
                                                                        <td><?php echo $row['referencia'] ?></td>
                                                                        <td><?php echo $row['descricao'] ?></td>
                                                                        <td class="text-center"><?php echo $row['quantidade'] ?></td>
                                                                        <td class="text-center"><?php echo $row['valor'];?></td>
                                                                        <td class="text-center"><?php echo $row['bruto'];?></td>
                                                                        <td class="actions-hover actions-fade text-center "><?php echo $row['btn']  ?></td>
                                                                    </tr>
                                                                <?php
                                                                    $valor = str_replace (',', '.', str_replace ('.', '', $row['valor']));
                                                                    $qtde = $qtde + $row['quantidade'];
                                                                    $multi = $valor * $row['quantidade'];
                                                                    $resultado = $resultado + $multi;
                                                                }
                                                                
                                                                ?>
                                                                <tr style="font-size:16px;">
                                                                    <td></td>
                                                                    <td class="text-right" style="color:red"><b>Total<b></td>
                                                                    <td class="text-center"><b><?php echo $qtde; ?><b></td>
                                                                    <td class="text-center"><b><?php echo number_format($resultado, 2, ",", "."); ?><b></td>
                                                                    <td></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <br>
                                                        <!-- <a href="form_pagamento.php?idpedido=<?php echo $idpedido ?>" class="btn btn-danger btn-block">Formas de Pagamento</a><br> -->
                                                        <button type="submit" class="btn btn-danger btn-block">Formas de Pagamento</button><br>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                            </form>
                                            <footer class="card-footer">
                                            </footer>
                                        </section>
                                    </div>
                            </div>
                            </form>
                            <!-- Modal -->
                            <div class="modal fade" id="AtualizaItens" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog modal-md" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">Atualizar Produto</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="frmProdutoU">
                                                <input type="text" hidden="" id="idprodutoU" name="idprodutoU">
                                                <input type="text" hidden="" id="idpedidoU" name="idpedidoU">
                                                <label>Descrição</label>
                                                <input autocomplete="off" name="descricaoU" id="descricaoU"  class="form-control input-sm" maxlength="8" readonly="readonly" >
                                                <label>Referencia</label>
                                                <input autocomplete="off" inputmode="numeric" name="referenciaU" id="referenciaU"  class="form-control input-sm" maxlength="8" readonly="readonly" >
                                                <label>Quantidade</label>
                                                <input autocomplete="off" inputmode="numeric" type="number" name="qtdeU" id="qtdeU" min="1" max="100" class="form-control input-sm" maxlength="2" >
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <span id="btnAtualizaQuantidade" name="btnAtualizaQuantidade" class="btn btn-success" ><i class="loading-icon fa fa-spinner fa-spin oculto"></i> Atualizar</span>
                                        </div>
                                    </div>
                                </div>
                            </div>                                                          
                            <footer class="card-footer">
                            </footer>
                        </section>
                    </div>
            </section>
		</div>


    </section>

    <script>
    $(document).ready(function(){
            $('#categoria').change(function(){
            var idcategoria = $('#categoria').val();
            //alert(idcategoria);
                $.ajax({
                    type:"POST",
                    data:{
                    idcategoria: idcategoria,
                    paramTela: 'pegarProdutos',
                    },
                    //url:"pega_produto.php",
                    url:"classes/conect.php",
                    dataType: "json",
                    success: function(json){
                        $("#produtos").html(json);
                    }
                    
                });
            })

            $('#produtos').change(function() {
            var produtos = $('select#produtos').val();
            //alert('Chamei');
            $.ajax({
                type: "POST",
                data: {
                    referencia: produtos,
                    paramTela: 'pegarDescProdutos',
                },

                url: "classes/conect.php",
                dataType: "json",
                success: function(result) {
                    //var dados = $.parseJSON(result);
                    var referencia = result["referencia"];
                    var preco = result["preco"];
                    var descricao = result["descricao"];

                    $("#referencia").val(referencia);
                    $("#preco").val(preco);
                    $("#descricao").val(descricao);
                    $("#qtde").val("1");
                }
            });
        });
    })
    </script>
    
    
    <script type="text/javascript">

    $('#AdicionarProduto').click(function(){

        var idpedido = document.getElementById("idpedido").value;
        var referencia = document.getElementById("referencia").value;
        var preco = document.getElementById("preco").value;
        var qtde = document.getElementById("qtde").value;
        var descricao = document.getElementById("descricao").value;
        //dados=$('#frmCategoriaU').serialize();                

        $.ajax({
            type:"POST",
            data:{
                idpedido: idpedido,
                referencia: referencia,
                preco: preco,
                qtde: qtde,
                descricao: descricao,
                paramTela: 'adicionarProduto',
            },
            url:"classes/conect.php",
            success:function(r){
                //alert(r);
                if(r==1){
                    alertify.success("Produto inserido com Sucesso :)");
                    //$ ('#frmAdicionarProdutos').trigger ("reset");
                   // $("#produtos").selectedIndex = -1;
                    $('#referencia').val("");
                    $('#preco').val("");
                    $('#descricao').val("");
                    jQuery('#categoria').prop('selectedIndex',0);
                    jQuery('#produtos').prop('selectedIndex',0);
                    jQuery('#qtde').prop('value',1);
                    window.location.reload(true);
                }else{
                    alertify.error("Não foi possível inserir o produto !"); 
                }
            },
            beforeSend: function(){
                $('.loading-icon').removeClass("oculto");
            },
            complete: function(){
                $('.loading-icon').addClass("oculto");
                gerarDadosUP();
            }
        });
    });

    </script>

    

<script type="text/javascript">

$(document).on("click", "#btnExcluirItem", function () { //Função Modal Editar MAC
    var idpedido = document.getElementById("idpedido").value;
    var iditem = $(this).attr('data-iditem');
    alertify.confirm('Deseja excluir este Item?', function(){ 
        $.ajax({
            type:"POST",
            data:{'idpedido': idpedido,
                'iditem': iditem,
                paramTela: 'ExcluirItem'
            },
            url:"classes/conect.php",
            success:function(r){
                if(r==1){
                    alertify.success("Item excluido com sucesso!!");
                    window.location.reload(true);
                }else{
                    alertify.error("Não foi possivel Excluir esse Item!");
                }
            }
        });
    }, function(){ 
        alertify.error('Cancelado !')
    });
});

</script>    

<script type="text/javascript">

    $('#btnAtualizaQuantidade').click(function(){
        var idpedido = document.getElementById("idpedido").value;
        var iditem = document.getElementById("idprodutoU").value;
        var descricao = document.getElementById("descricaoU").value;
        var referencia = document.getElementById("referenciaU").value;
        var qtde = document.getElementById("qtdeU").value;
        //dados=$('#frmCategoriaU').serialize();                

        $.ajax({
            type:"POST",
            data:{
                iditem: iditem,
                idpedido: idpedido,
                descricao: descricao,
                referencia: referencia,
                qtde: qtde,
                paramTela: 'atualizarQuantidade',
            },
            url:"classes/conect.php",
            success:function(r){
                //alert(r);
                if(r==1){
                    alertify.success("Produto Atualizado com Sucesso :)");
                    $('#AtualizaItens').modal('hide');
                    window.location.reload(true);
                }else{
                    alertify.error("Não foi possível atualizar as informações do Produto!");
                }
            },
            beforeSend: function(){
                $('.loading-icon').removeClass("oculto");
            },
            complete: function(){
                $('.loading-icon').addClass("oculto");
            }
        });
    });

    </script>
    
    <script>
        $(document).on("click", "#btnAtualizaItens", function () { //Função Modal Editar 
            var idproduto = $(this).attr('data-iditem'); 
            var descricao = $(this).attr('data-descricao'); 
            var referencia = $(this).attr('data-referencia');  //Pegando os dados que são passados no botão
            var qtde = $(this).attr('data-qtde'); 
            $(".modal-body #idprodutoU").val(idproduto); // Jogando os valores nos seus respectivos campos dentro do corpo do Modal
            $(".modal-body #descricaoU").val(descricao); // Jogando os valores nos seus respectivos campos dentro do corpo do Modal
            $(".modal-body #referenciaU").val(referencia);
            $(".modal-body #qtdeU").val(qtde);
            $('#atualizaProdutos').on('shown.bs.modal', function () {
                $('#qtdeU').focus(); //pegando foco do campo MAC ao abrir
            });
        });
    </script>

<!-- <script>

var cont = 0;
var tabela = 0;
gerarDadosUP();
function gerarDadosUP(){
    var idpedido = document.getElementById("idpedido").value;
    $.ajax({
        type: 'POST',
        url: 'classes/conect.php',
        data: {
            idpedido:idpedido,
            paramTela: 'listarItens'    
        },
        success: function(data){  
            //$('#loading_table2').hide();                                                                                                          
            dados = null;
            dados = JSON.parse(data);
                if(cont == 0){
                    cont++
                }else {
                    tabela.destroy();
                }                    
            // dados = [dados];
            tabela = $('#listarItens').DataTable({  
                    "aaSorting": [[1, "asc"]],  //ordenação da 2° coluna do datatable para descendente 
                    "bInfo" :false,         
                    "scrollX": true, // cria o scroll no dataTable   
                    paging: false,     
                    searching: false,   
                    ordering: false,                                                          
    				data: dados, 
                    columns: [ //head da table direto no javascript
                        {title: 'Referencia' },    
                        {title: 'Descricao' },                        
                        {title: 'Qtde' },    
                        {title: 'Preco Unit.' }, 
                        {title: 'Preco Bruto' },     
                        {title: 'Opcoes'  },                                               
                    ],
                    "columnDefs": [
                        { "width": "10%", "targets": 2 }
                    ],
                    language: { //PROPRIEDADES DO DATATABLE
						"sEmptyTable": "Nenhum registro encontrado nesse período",
						"sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
						"sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
						"sInfoFiltered": "(Filtrados de MAX registros)",
						"sInfoPostFix": "",
						"sInfoThousands": ".",
						"sLengthMenu": "_MENU_ Resultados por página",
						"sLoadingRecords": "Carregando...",
						"sProcessing": "Processando...",
						"sZeroRecords": "Nenhum registro encontrado",
						"sSearch": "Pesquisar",
						"oPaginate": {
							"sNext": "Próximo",
							"sPrevious": "Anterior",
							"sFirst": "Primeiro",
							"sLast": "Último"
						},
						"oAria": {
							"sSortAscending": ": Ordenar colunas de forma ascendente",
							"sSortDescending": ": Ordenar colunas de forma descendente"
						},
						"buttons": {
								"copyTitle": "Copiar linhas"
							}
						},
                        // "columnDefs": [
                        //     {
                        //         "targets": [ 0 ],
                        //         "visible": false,
                        //         "searchable": false
                        //     },
                        // ] 				
                }).row.add([
                     '', '<td class="text-right" style="color:red;"><b>Total<b></td>', '<td class="text-center"><b>', '<td class="text-center"><b><b></td>', '', ''
                    ]).draw();
            }				
        })
    } 
</script> -->



<?php include 'footer_layout.php';  ?>