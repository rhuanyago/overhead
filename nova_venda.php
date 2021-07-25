<?php
include 'menu_layout.php';
require_once "Connections/conexao.php";
require_once "classes/class.vision.php";
$c = new conectar();
$conexao = $c->conexao();
$obj = new vision();

if (!isset($_GET['idpedido'])) {

    $result = $obj->ultimoPedido();
    $idpedido = $result['idpedido'];
} else {
    $idpedido = $_GET['idpedido'];
}


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

    .spinnerVal {
        text-align: center;
    }

    .customSpinner {
        display: flex;
        margin-bottom: 10px;
    }


    /*Apply individual Styles to one*/

    .spinner-roundVal {
        /* margin: auto 2px; */
        border-radius: 20px !important;
        /* width: auto !important; */
    }

    .spinner-roundbutton {
        border-radius: 100px !important;
    }

    .rhu {
        background-color: #eee;
        color: black;
        cursor: pointer;
    }

    .listin {
        padding: 12px;
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
                                    <!-- <input type="number" name="qtde" id="qtde" min="1" max="" step="1" class="form-control" maxlength="2"> -->

                                    <!--Input Form1-->
                                    <div class="input-group customSpinner">
                                        <div class="input-group-prepend">
                                            <button type="button" class="btn btn-primary text-light spinnerbutton spinnerMinus spinner-roundbutton">
                                                <span class="fa fa-minus"></span>
                                            </button>
                                        </div>
                                        <input type="text" readonly value="0" name="qtde" id="qtde" data-estoque="" class="form-control spinnerVal spinner-roundVal" />
                                        <div class="input-group-append">
                                            <button type="button" id="spinnerPlus" class="btn btn-primary text-light spinnerbutton spinnerPlus spinner-roundbutton">
                                                <span class="fa fa-plus"></span>
                                            </button>
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
                            <div class="col-sm-3">
                                <div id="addProduto" class="form-group">
                                    <label class="control-label  text-weight-bold">Incluir</label>
                                    <button id="AdicionarProduto" type="button" class="btn btn-dark btn-block" value=""><i class="fas fa-plus"></i> Adicionar Produto</button>
                                </div>
                            </div>


                        </div> <!-- fim row -->

                        <div class="row">
                            <div id="estoqueIndis" class="col-sm-12 oculto">
                                <div class="center">
                                    <div class="alert alert-danger">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <strong><i class="fas fa-exclamation-triangle"></i> Atenção! Produto com Estoque
                                            Indisponível.</strong>
                                    </div>
                                </div>
                            </div>
                            <div id="estoque1" class="col-sm-12 oculto">
                                <div class="center">
                                    <div class="alert alert-warning">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <strong><i class="fas fa-exclamation-triangle"></i> Atenção! Restam apenas 1 produto disponível em Estoque!</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <img id="img" class="float-center text-center" src="img/sem-foto.jpg" height=350 width=350\>

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
                                                        <th class="text-center">Opções</th>
                                                    </tr>

                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $resultado = 0;
                                                    $qtde = 0;
                                                    $arr = [];
                                                    ?>
                                                    <?php foreach ($rowListar as $key => $row) { ?>
                                                        <tr style="font-size:14px;">
                                                            <td><?php echo $row['referencia'] ?></td>
                                                            <td><?php echo $row['descricao'] ?></td>
                                                            <td class="text-center"><?php echo $row['quantidade'] ?></td>
                                                            <td class="text-center"><?php echo $row['valor']; ?></td>
                                                            <td class="text-center"><?php echo $row['bruto']; ?></td>
                                                            <td class="actions-hover actions-fade text-center ">
                                                                <?php echo $row['btn']  ?></td>
                                                        </tr>
                                                    <?php
                                                        $valor = str_replace(',', '.', str_replace('.', '', $row['valor']));
                                                        array_push($arr, $row['bruto']);
                                                        $qtde = $qtde + $row['quantidade'];
                                                    }
                                                    $resultado = array_sum($arr);
                                                    ?>
                                                    <tr style="font-size:16px;">
                                                        <td></td>
                                                        <td class="text-right" style="color:red"><b>Total<b></td>
                                                        <td class="text-center"><b><?php echo $qtde; ?><b></td>
                                                        <td class="text-center">
                                                            <b><?php echo number_format($resultado, 2, ",", "."); ?><b>
                                                        </td>
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
                                    <button type="submit" class="btn btn-primary btn-block text-light">Formas de
                                        Pagamento</button><br>
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
                    <div id="estoqueIndisAtt" class="col-sm-12 oculto">
                        <div class="center">
                            <div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <strong><i class="fas fa-exclamation-triangle"></i> Atenção! Produto com Estoque
                                    Indisponível.</strong>
                            </div>
                        </div>
                    </div>
                    <form id="frmProdutoU">
                        <input type="text" hidden="" id="idprodutoU" name="idprodutoU">
                        <input type="text" hidden="" id="idpedidoU" name="idpedidoU">
                        <label>Descrição</label>
                        <input autocomplete="off" name="descricaoU" id="descricaoU" class="form-control input-sm" maxlength="8" readonly="readonly">
                        <label>Referencia</label>
                        <input autocomplete="off" inputmode="numeric" name="referenciaU" id="referenciaU" class="form-control input-sm" maxlength="8" readonly="readonly">
                        <label>Preço</label>
                        <input autocomplete="off" inputmode="numeric" type="text" name="precoU" id="precoU" class="form-control input-sm" readonly>
                        <label>Quantidade</label>
                        <!-- <input autocomplete="off" inputmode="numeric" type="number" name="qtdeU" id="qtdeU" min="1" max="100" class="form-control input-sm" maxlength="2"> -->
                        <div class="input-group customSpinner">
                            <div class="input-group-prepend">
                                <button type="button" class="btn btn-primary text-light spinnerbutton spinnerMinus spinner-roundbutton">
                                    <span class="fa fa-minus"></span>
                                </button>
                            </div>
                            <input type="text" readonly name="qtdeU" id="qtdeU" class="form-control spinnerVal spinner-roundVal" />
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary text-light spinnerbutton spinnerPlus spinner-roundbutton">
                                    <span class="fa fa-plus"></span>
                                </button>
                            </div>
                        </div>
                        <label>Estoque</label>
                        <input autocomplete="off" inputmode="numeric" type="text" name="estoqueU" id="estoqueU" class="form-control input-sm" readonly>
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


        /* alert("ready");//Thank You Saviour */
        var minusButton = $(".spinnerMinus"); //to aquire all minus buttons
        var plusButton = $(".spinnerPlus"); //to aquire all plus buttons
        //Handle click
        minusButton.click(function() {
            var estoque = $('#qtde').attr('data-estoque');

            trigger_Spinner($(this), "-", {
                max: estoque,
                min: 1,
            }); //Triggers the Spinner Actuator
        }); /*end Handle Minus Button click*/

        plusButton.click(function() {
            var estoque = $('#qtde').attr('data-estoque');

            trigger_Spinner($(this), "+", {
                max: estoque,
                min: 1,
            }); //Triggers the Spinner Actuator    
        }); /*end Handle Plus Button Click*/

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
                        $("#spinnerPlus").prop("disabled", false);
                        if (typeof result !== 'undefined') {
                            var referencia = result["referencia"];
                            var preco = result["preco"];
                            var descricao = result["descricao"];
                            var estoque = result["estoque"];
                            var img = result["imagem"];
                            $("#referencia").val(referencia);
                            $("#preco").val(preco);
                            $("#descricao").val(descricao);
                            $("#qtde").val("1");
                            $("#estoque").val(estoque);

                            $('#qtde').attr('data-estoque', estoque);

                            if (img == '') {
                                $('#img').attr('src', 'img/sem-foto.jpg');
                            } else {
                                $('#img').attr('src', 'img/uploads/' + img);
                            }

                            if (estoque == 1) {
                                var estoqueIndis = document.getElementById("estoque1");
                                estoqueIndis.classList.remove("oculto");
                            }

                            if (estoque == 0 || estoque < 0) {
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

            $("#spinnerPlus").prop("disabled", false);

            if (referencia.length <= 1 || referencia == '') {
                // $("#referencia").val('');
                $("#preco").val('');
                $("#descricao").val('');
                $("#qtde").val("1");
                $("#estoque").val('');
                $('#qtde').attr('data-estoque', '');
                $('#img').attr('src', 'img/sem-foto.jpg');

                var element = document.getElementById("addProduto");
                element.classList.remove("oculto");
                var estoqueIndis = document.getElementById("estoqueIndis");
                estoqueIndis.classList.add("oculto");
                var estoqueIndis = document.getElementById("estoque1");
                estoqueIndis.classList.add("oculto");
            }

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

        $('#rg').keyup(function() {
            var rg = $(this).val();
            if (rg != '') {
                $.ajax({
                    url: "classes/conect.php",
                    method: "POST",
                    data: {
                        param: rg,
                        paramTela: 'complete',
                    },
                    success: function(data) {
                        $('#countryList').fadeIn();
                        $('#countryList').html(data);
                    }
                });
            }
        });

        $(document).on('click', 'li', function() {
            $('#rg').val($(this).text());
            $('#countryList').fadeOut();
            $('#rg').focus();
        });

    });

    //This function will take the clicked button and actuate the spinner based on the provided function/operator
    // - this allows you to adjust the limits of specific spinners based on classnames
    function trigger_Spinner(clickedButton, plus_minus, limits) {

        var valueElement = clickedButton.closest('.customSpinner').find(
            '.spinnerVal'); //gets the closest value element to this button
        var controllerbuttons = {
            minus: clickedButton.closest('.customSpinner').find('.spinnerMinus'),
            plus: clickedButton.closest('.customSpinner').find('.spinnerPlus')
        }; //to get the button pair associated only with this set of input controls//THank You Jesus!

        //Activate Spinner
        updateSpinner(limits, plus_minus, valueElement, controllerbuttons); //to update the Spinner

    }



    /*
    	max - maxValue
      min - minValue
      operator - +/-
      elem - the element that will be used to update the count
    */ //Thank You Jesus!
    function updateSpinner(limits, operator, elem, buttons) {


        var currentVal = parseInt(elem.val()); //get the current val

        // console.log(currentVal);

        //Operate on value -----------------
        if (operator == "+") {
            currentVal += 1; //Increment by one  
            //Thank You Jesus ----------------
            if (currentVal <= limits.max) {
                elem.val(currentVal);
            }
        } else if (operator == "-") {
            currentVal -= 1; //Decrement by one
            //Thank You Jesus ----------------
            if (currentVal >= limits.min) {
                elem.val(currentVal);
            }
        }

        //Independent Controllers - Handle Buttons disable toggle ------------------------
        buttons.plus.prop('disabled', (currentVal >= limits.max)); //enable/disable button
        buttons.minus.prop('disabled', (currentVal <= limits.min)); //enable/disable button  
    }
</script>


<script type="text/javascript">
    $('#AdicionarProduto').click(function() {

        var idpedido = document.getElementById("idpedido").value;
        var referencia = document.getElementById("referencia").value;
        var preco = document.getElementById("preco").value;
        var qtde = document.getElementById("qtde").value;
        var descricao = document.getElementById("descricao").value;
        //dados=$('#frmCategoriaU').serialize();    

        if (referencia == "") {
            alertify.set('notifier', 'position', 'top-center');
            alertify.error('Campo Referência em Branco!');
            return;
        }

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
                // alert(r);
                if (r == 1) {
                    alertify.success("Produto inserido com Sucesso :)");
                    //$ ('#frmAdicionarProdutos').trigger ("reset");
                    // $("#produtos").selectedIndex = -1;
                    $('#referencia').val("");
                    $('#preco').val("");
                    $('#descricao').val("");
                    jQuery('#categoria').prop('selectedIndex', 0);
                    jQuery('#produtos').prop('selectedIndex', 0);
                    $("#qtde").val("1");
                    jQuery('#qtde').prop('value', 1);
                    window.location.reload(true);
                } else if (r == false) {
                    var element = document.getElementById("addProduto");
                    element.classList.add("oculto");
                    var estoqueIndis = document.getElementById("estoqueIndis");
                    estoqueIndis.classList.remove("oculto");
                    jQuery('#qtde').prop('value', 1);
                } else {
                    alertify.error("Não foi possível inserir o produto !");
                }
            },
            beforeSend: function() {
                $('.loading-icon').removeClass("oculto");
            },
            complete: function() {
                $('.loading-icon').addClass("oculto");
                // gerarDadosUP();
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
        var preco = document.getElementById("precoU").value;
        var qtde = document.getElementById("qtdeU").value;
        //dados=$('#frmCategoriaU').serialize();                

        $.ajax({
            type: "POST",
            data: {
                iditem: iditem,
                idpedido: idpedido,
                descricao: descricao,
                referencia: referencia,
                preco: preco,
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
                } else if (r == false) {
                    // $('#AtualizaItens').modal('hide');
                    var estoqueIndis = document.getElementById("estoqueIndisAtt");
                    estoqueIndis.classList.remove("oculto");
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
        var preco = $(this).attr('data-preco'); //Pegando os dados que são passados no botão
        var qtde = $(this).attr('data-qtde');
        var estoque = $(this).attr('data-estoque');
        $(".modal-body #idprodutoU").val(
            idproduto); // Jogando os valores nos seus respectivos campos dentro do corpo do Modal
        $(".modal-body #descricaoU").val(
            descricao); // Jogando os valores nos seus respectivos campos dentro do corpo do Modal
        $(".modal-body #referenciaU").val(referencia);
        $(".modal-body #precoU").val(preco);
        $(".modal-body #qtdeU").val(qtde);
        $(".modal-body #estoqueU").val(estoque);
        $('#atualizaProdutos').on('shown.bs.modal', function() {
            $('#qtdeU').focus(); //pegando foco do campo MAC ao abrir
        });

    });
</script>

<?php include 'footer_layout.php';  ?>