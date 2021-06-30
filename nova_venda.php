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
    .oculto {
        display: none;
    }

    /* Style para o loading dos tables */

    .button:disabled {
        opacity: 0.5;
    }

    .autocomplete {
        /*the container must be positioned relative:*/
        position: relative;
        display: inline-block;
    }

    input {
        border: 1px solid transparent;
        background-color: #f1f1f1;
        padding: 10px;
        font-size: 16px;
    }

    .autocomplete-items {
        position: absolute;
        border: 1px solid #d4d4d4;
        border-bottom: none;
        border-top: none;
        z-index: 99;
        /*position the autocomplete items to be the same width as the container:*/
        top: 100%;
        left: 0;
        right: 0;
    }

    .autocomplete-items div {
        padding: 10px;
        cursor: pointer;
        background-color: #fff;
        border-bottom: 1px solid #d4d4d4;
    }

    .autocomplete-items div:hover {
        /*when hovering an item:*/
        background-color: #e9e9e9;
    }

    .autocomplete-active {
        /*when navigating through the items using the arrow keys:*/
        background-color: DodgerBlue !important;
        color: #ffffff;
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
            <section class="card card-primary">
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
                    <form method="POST" id="frmAdicionarProdutos" action="form_pagamento.php">
                        <div class="row">
                            <div class="col-sm-2">
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
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label class=" control-label text-weight-bold">Referência</label>
                                    <input type="text" name="referencia" id="referencia" class="form-control text-weight-bold" maxlength="8" upper>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label  text-weight-bold">Descrição</label>
                                    <input type="text" name="descricao" id="descricao" class="form-control text-weight-bold" readonly>
                                </div>
                            </div>
                            <!-- <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="control-label  text-weight-bold">Categoria</label>
                                    <select name="categoria" id="categoria" class="form-control">
                                        <option selected>Selecione a Categoria</option>
                                        <?php foreach ($listarCat as $key) { ?>
                                            <option value="<?php echo $key['idcategoria'] ?>"><?php echo $key['nome']  ?></option>
                                        <?php  }  ?>
                                    </select>
                                </div>
                            </div> -->
                            <!-- <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="control-label  text-weight-bold">Produtos</label>
                                    <select name="produtos" id="produtos" class="form-control">
                                    </select>
                                </div>
                            </div> -->

                        </div> <!-- fim row-->

                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label class="control-label  text-weight-bold">Preço</label>
                                    <input type="number" name="preco" id="preco" class="form-control text-weight-bold text-danger" readonly>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label class="control-label  text-weight-bold">Qtde</label>
                                    <div data-plugin-spinner>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <button type="button" class="btn btn-default spinner-up">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                            <input type="number" name="qtde" id="qtde" min="" max="" step="1" class="spinner-input form-control" maxlength="2" readonly>
                                            <div class="input-group-append">
                                                <button type="button" id="spinner" class="btn btn-default spinner-down">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label class="control-label  text-weight-bold">Estoque</label>
                                    <input type="number" name="estoque" id="estoque" class="form-control text-weight-bold" maxlength="10" readonly>
                                </div>
                            </div>

                        </div> <!-- fim row -->

                        <div class="row">
                            <div class="col-sm-3">
                                <div id="addProduto" class="form-group">
                                    <label class="control-label  text-weight-bold">Incluir</label>
                                    <button id="AdicionarProduto" type="button" class="btn btn-dark btn-block" value=""><i class="fas fa-plus"></i> Adicionar Produto</button>
                                </div>
                            </div>
                            <br>
                            <div id="estoqueIndis" class="col-sm-12 oculto">
                                <div class="center">
                                    <div class="alert alert-danger">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <strong><i class="fas fa-exclamation-triangle"></i> Atenção! Produto com Estoque Indisponível.</strong>
                                    </div>
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
                                                            <td class="text-center"><?php echo $row['valor']; ?></td>
                                                            <td class="text-center"><?php echo $row['bruto']; ?></td>
                                                            <td class="actions-hover actions-fade text-center "><?php echo $row['btn']  ?></td>
                                                        </tr>
                                                    <?php
                                                        $valor = str_replace(',', '.', str_replace('.', '', $row['valor']));
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
                                    <button type="submit" class="btn btn-primary btn-block text-light">Formas de Pagamento</button><br>
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
                        <input autocomplete="off" name="descricaoU" id="descricaoU" class="form-control input-sm" maxlength="8" readonly="readonly">
                        <label>Referencia</label>
                        <input autocomplete="off" inputmode="numeric" name="referenciaU" id="referenciaU" class="form-control input-sm" maxlength="8" readonly="readonly">
                        <label>Quantidade</label>
                        <input autocomplete="off" inputmode="numeric" type="number" name="qtdeU" id="qtdeU" min="1" max="100" class="form-control input-sm" maxlength="2">
                    </form>
                </div>
                <div class="modal-footer">
                    <span id="btnAtualizaQuantidade" name="btnAtualizaQuantidade" class="btn btn-success"><i class="loading-icon fa fa-spinner fa-spin oculto"></i> Atualizar</span>
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
    $(document).ready(function() {

        var MIN_LENGTH = 2;

        $('#referencia').keyup(function() {

            var referencia = $('#referencia').val();

            if (referencia.length >= MIN_LENGTH) {

                $.ajax({
                    type: "POST",
                    data: {
                        referencia: referencia,
                        paramTela: 'pegarDescProdutos',
                    },

                    url: "classes/conect.php",
                    dataType: "json",
                    success: function(result) {
                        if (typeof result !== 'undefined') {
                            var referencia = result["referencia"];
                            var preco = result["preco"];
                            var descricao = result["descricao"];
                            var estoque = result["estoque"];

                            $("#referencia").val(referencia);
                            $("#preco").val(preco);
                            $("#descricao").val(descricao);
                            $("#qtde").val("1");
                            $("#estoque").val(estoque);
                            $("#qtde").attr({
                                "max": estoque,
                                "min": 0
                            });
                            if (estoque == 0) {
                                var element = document.getElementById("addProduto");
                                element.classList.add("oculto");
                                var estoqueIndis = document.getElementById("estoqueIndis");
                                estoqueIndis.classList.remove("oculto");
                            }
                        }
                    }
                });
            }
        });

        $('#referencia').keydown(function() {

            var referencia = $('#referencia').val();

            if (referencia.length <= 1 || referencia == '') {
                // $("#referencia").val('');
                $("#preco").val('');
                $("#descricao").val('');
                $("#qtde").val("1");
                $("#estoque").val('');
                var element = document.getElementById("addProduto");
                element.classList.remove("oculto");
                var estoqueIndis = document.getElementById("estoqueIndis");
                estoqueIndis.classList.add("oculto");
            }

        });

        $("#spinner").spinner({
            step: 1,
            min: 1,
            max: 10,
            numberFormat: "n",
        });

        $('#categoria').change(function() {
            var idcategoria = $('#categoria').val();
            //alert(idcategoria);
            $.ajax({
                type: "POST",
                data: {
                    idcategoria: idcategoria,
                    paramTela: 'pegarProdutos',
                },
                //url:"pega_produto.php",
                url: "classes/conect.php",
                dataType: "json",
                success: function(json) {
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
                    var estoque = result["estoque"];

                    $("#referencia").val(referencia);
                    $("#preco").val(preco);
                    $("#descricao").val(descricao);
                    $("#qtde").val("1");
                    $("#estoque").val(estoque);
                }
            });
        });
    })
</script>


<script type="text/javascript">
    $('#AdicionarProduto').click(function() {

        var idpedido = document.getElementById("idpedido").value;
        var referencia = document.getElementById("referencia").value;
        var preco = document.getElementById("preco").value;
        var qtde = document.getElementById("qtde").value;
        var descricao = document.getElementById("descricao").value;
        //dados=$('#frmCategoriaU').serialize();                

        $.ajax({
            type: "POST",
            data: {
                idpedido: idpedido,
                referencia: referencia,
                preco: preco,
                qtde: qtde,
                descricao: descricao,
                paramTela: 'adicionarProduto',
            },
            url: "classes/conect.php",
            success: function(r) {
                //alert(r);
                if (r == 1) {
                    alertify.success("Produto inserido com Sucesso :)");
                    //$ ('#frmAdicionarProdutos').trigger ("reset");
                    // $("#produtos").selectedIndex = -1;
                    $('#referencia').val("");
                    $('#preco').val("");
                    $('#descricao').val("");
                    jQuery('#categoria').prop('selectedIndex', 0);
                    jQuery('#produtos').prop('selectedIndex', 0);
                    jQuery('#qtde').prop('value', 1);
                    window.location.reload(true);
                } else {
                    alertify.error("Não foi possível inserir o produto !");
                }
            },
            beforeSend: function() {
                $('.loading-icon').removeClass("oculto");
            },
            complete: function() {
                $('.loading-icon').addClass("oculto");
                gerarDadosUP();
            }
        });
    });
</script>



<script type="text/javascript">
    $(document).on("click", "#btnExcluirItem", function() { //Função Modal Editar MAC
        var idpedido = document.getElementById("idpedido").value;
        var iditem = $(this).attr('data-iditem');
        alertify.confirm('Deseja excluir este Item?', function() {
            $.ajax({
                type: "POST",
                data: {
                    'idpedido': idpedido,
                    'iditem': iditem,
                    paramTela: 'ExcluirItem'
                },
                url: "classes/conect.php",
                success: function(r) {
                    if (r == 1) {
                        alertify.success("Item excluido com sucesso!!");
                        window.location.reload(true);
                    } else {
                        alertify.error("Não foi possivel Excluir esse Item!");
                    }
                }
            });
        }, function() {
            alertify.error('Cancelado !')
        });
    });
</script>

<script type="text/javascript">
    $('#btnAtualizaQuantidade').click(function() {
        var idpedido = document.getElementById("idpedido").value;
        var iditem = document.getElementById("idprodutoU").value;
        var descricao = document.getElementById("descricaoU").value;
        var referencia = document.getElementById("referenciaU").value;
        var qtde = document.getElementById("qtdeU").value;
        //dados=$('#frmCategoriaU').serialize();                

        $.ajax({
            type: "POST",
            data: {
                iditem: iditem,
                idpedido: idpedido,
                descricao: descricao,
                referencia: referencia,
                qtde: qtde,
                paramTela: 'atualizarQuantidade',
            },
            url: "classes/conect.php",
            success: function(r) {
                //alert(r);
                if (r == 1) {
                    alertify.success("Produto Atualizado com Sucesso :)");
                    $('#AtualizaItens').modal('hide');
                    window.location.reload(true);
                } else {
                    alertify.error("Não foi possível atualizar as informações do Produto!");
                }
            },
            beforeSend: function() {
                $('.loading-icon').removeClass("oculto");
            },
            complete: function() {
                $('.loading-icon').addClass("oculto");
            }
        });
    });
</script>

<script>
    $(document).on("click", "#btnAtualizaItens", function() { //Função Modal Editar 
        var idproduto = $(this).attr('data-iditem');
        var descricao = $(this).attr('data-descricao');
        var referencia = $(this).attr('data-referencia'); //Pegando os dados que são passados no botão
        var qtde = $(this).attr('data-qtde');
        $(".modal-body #idprodutoU").val(idproduto); // Jogando os valores nos seus respectivos campos dentro do corpo do Modal
        $(".modal-body #descricaoU").val(descricao); // Jogando os valores nos seus respectivos campos dentro do corpo do Modal
        $(".modal-body #referenciaU").val(referencia);
        $(".modal-body #qtdeU").val(qtde);
        $('#atualizaProdutos').on('shown.bs.modal', function() {
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
<!-- 
<script>
    function autocomplete(inp, arr) {
        /*the autocomplete function takes two arguments,
        the text field element and an array of possible autocompleted values:*/
        var currentFocus;
        /*execute a function when someone writes in the text field:*/
        inp.addEventListener("input", function(e) {
            var a, b, i, val = this.value;
            closeAllLists();
            if (!val) {
                return false;
            }
            currentFocus = -1;
            a = document.createElement("DIV");
            a.setAttribute("id", this.id + "autocomplete-list");
            a.setAttribute("class", "autocomplete-items");
            /*append the DIV element as a child of the autocomplete container:*/
            this.parentNode.appendChild(a);
            /*for each item in the array...*/
            for (i = 0; i < arr.length; i++) {
                /*check if the item starts with the same letters as the text field value:*/
                if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                    /*create a DIV element for each matching element:*/
                    b = document.createElement("DIV");
                    /*make the matching letters bold:*/
                    b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                    b.innerHTML += arr[i].substr(val.length);
                    /*insert a input field that will hold the current array item's value:*/
                    b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                    /*execute a function when someone clicks on the item value (DIV element):*/
                    b.addEventListener("click", function(e) {
                        /*insert the value for the autocomplete text field:*/
                        inp.value = this.getElementsByTagName("input")[0].value;
                        closeAllLists();
                    });
                    a.appendChild(b);
                }
            }
        });
        /*execute a function presses a key on the keyboard:*/
        inp.addEventListener("keydown", function(e) {
            var x = document.getElementById(this.id + "autocomplete-list");
            if (x) x = x.getElementsByTagName("div");
            if (e.keyCode == 40) {
                /*If the arrow DOWN key is pressed,
                increase the currentFocus variable:*/
                currentFocus++;
                /*and and make the current item more visible:*/
                addActive(x);
            } else if (e.keyCode == 38) { //up
                /*If the arrow UP key is pressed,
                decrease the currentFocus variable:*/
                currentFocus--;
                /*and and make the current item more visible:*/
                addActive(x);
            } else if (e.keyCode == 13) {
                /*If the ENTER key is pressed, prevent the form from being submitted,*/
                e.preventDefault();
                if (currentFocus > -1) {
                    /*and simulate a click on the "active" item:*/
                    if (x) x[currentFocus].click();
                }
            }
        });

        function addActive(x) {
            /*a function to classify an item as "active":*/
            if (!x) return false;
            /*start by removing the "active" class on all items:*/
            removeActive(x);
            if (currentFocus >= x.length) currentFocus = 0;
            if (currentFocus < 0) currentFocus = (x.length - 1);
            /*add class "autocomplete-active":*/
            x[currentFocus].classList.add("autocomplete-active");
        }

        function removeActive(x) {
            /*a function to remove the "active" class from all autocomplete items:*/
            for (var i = 0; i < x.length; i++) {
                x[i].classList.remove("autocomplete-active");
            }
        }

        function closeAllLists(elmnt) {
            /*close all autocomplete lists in the document,
            except the one passed as an argument:*/
            var x = document.getElementsByClassName("autocomplete-items");
            for (var i = 0; i < x.length; i++) {
                if (elmnt != x[i] && elmnt != inp) {
                    x[i].parentNode.removeChild(x[i]);
                }
            }
        }
        /*execute a function when someone clicks in the document:*/
        document.addEventListener("click", function(e) {
            closeAllLists(e.target);
        });
    }

    /*An array containing all the country names in the world:*/
    var countries = ["Afghanistan", "Albania", "Algeria", "Andorra", "Angola", "Anguilla", "Antigua & Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia & Herzegovina", "Botswana", "Brazil", "British Virgin Islands", "Brunei", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central Arfrican Republic", "Chad", "Chile", "China", "Colombia", "Congo", "Cook Islands", "Costa Rica", "Cote D Ivoire", "Croatia", "Cuba", "Curacao", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands", "Faroe Islands", "Fiji", "Finland", "France", "French Polynesia", "French West Indies", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guam", "Guatemala", "Guernsey", "Guinea", "Guinea Bissau", "Guyana", "Haiti", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland", "Isle of Man", "Israel", "Italy", "Jamaica", "Japan", "Jersey", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Kosovo", "Kuwait", "Kyrgyzstan", "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Mauritania", "Mauritius", "Mexico", "Micronesia", "Moldova", "Monaco", "Mongolia", "Montenegro", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauro", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "North Korea", "Norway", "Oman", "Pakistan", "Palau", "Palestine", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russia", "Rwanda", "Saint Pierre & Miquelon", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Serbia", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Korea", "South Sudan", "Spain", "Sri Lanka", "St Kitts & Nevis", "St Lucia", "St Vincent", "Sudan", "Suriname", "Swaziland", "Sweden", "Switzerland", "Syria", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "Timor L'Este", "Togo", "Tonga", "Trinidad & Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks & Caicos", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States of America", "Uruguay", "Uzbekistan", "Vanuatu", "Vatican City", "Venezuela", "Vietnam", "Virgin Islands (US)", "Yemen", "Zambia", "Zimbabwe"];

    /*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
    autocomplete(document.getElementById("myInput"), countries);
</script> -->

<?php include 'footer_layout.php';  ?>