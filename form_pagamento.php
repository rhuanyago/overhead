<?php
include 'menu_layout.php';
require_once "Connections/conexao.php";
require_once "classes/class.vision.php";

$c = new conectar();
$conexao = $c->conexao();

$idpedido = $_POST['idpedido'];

$obj = new vision();
$result = $obj->formaPagamento($idpedido);

foreach ($result as $key => $row_rscli) {
    $row_rscli['reg'];
    $row_rscli['valor'];
    $row_rscli['titulo'];
    $row_rscli['nome'];
    $row_rscli['status'];
    $row_rscli['tipo'];
}


?>


<style>
    .oculto {
        display: none;
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
                <li><span>Pedido</span></li>
                <li><span>Forma de Pagamento</span></li>
            </ol>


        </div>
    </header>

    <!-- start: page -->
    <div class="row">
        <div class="col-xl-12 order-1 mb-4">
            <section class="card card-primary">
                <header class="card-header">
                    <h2 class="card-title">Formas de Pagamento</h2>
                </header>
                <div class="card-body" style="font-size:14px">
                    <form name="formaPag" id="formaPag">
                        <input type="hidden" name="paramTela" value="adicionarForma" class="form-control text-weight-bold text-dark">

                        <div class="col-md-12">
                            <section class="card card-tertiary">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label class="control-label">Pedido</label>
                                                <input type="text" name="idpedido" id="idpedido" class="form-control text-weight-bold text-dark" readonly value="<?php echo $idpedido ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-1">
                                            <div class="form-group">
                                                <label class="control-label">REG</label>
                                                <input type="text" name="reg" id="reg" class="form-control text-weight-bold text-dark" readonly value="<?php echo $row_rscli['reg'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label class="control-label">Valor Consumido</label>
                                                <input type="text" name="preco" id="preco" class="form-control text-weight-bold text-danger text-right" readonly value="R$ <?php echo $row_rscli['valor']  ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label class="control-label">Tipo</label>
                                                <input type="url" name="tipo" id="tipo" class="form-control text-weight-bold text-dark text-right" readonly value="<?php echo  strtoupper($row_rscli['titulo']) ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-10">
                                            <div class="form-group">
                                                <label class="control-label">Cliente</label>
                                                <input type="text" name="nome" class="form-control text-weight-bold text-dark" readonly value="<?php echo $row_rscli['nome'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <?php if ($row_rscli['status'] == "A") { ?>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label class="control-label">Formas</label>
                                                    <select id="forma" name="forma" class="form-control">
                                                        <option value="" selected>------------------------</option>
                                                        <?php
                                                        $sql = "SELECT * from tbformas_pagamento";
                                                        $sql = $conexao->query($sql);
                                                        while ($rows_rsforma = $sql->fetch_assoc()) { ?>
                                                            <option value="<?php echo $rows_rsforma['idforma_pagamento'] ?>">
                                                                <?php echo $rows_rsforma['forma_descricao'] ?></option>
                                                        <?php } ?>
                                                    </select><br>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label class="control-label">Valor Pago</label>
                                                                <input type="text" name="valor" id="valor" inputmode="numeric" onkeyup="valorreais(this);" min="0" max="<?php echo $row_rscli['valor'] ?>" class="form-control text-weight-bold text-danger col-sm-12" value="0"><br>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label class="control-label">Valor Recebido R$</label>
                                                                <input type="hidden" name="valorrecebido" inputmode="numeric" id="valorrecebido" onkeyup="valorreais(this);" min="0"  class="form-control text-weight-bold text-dark col-sm-12" value="0">
                                                            </div>
                                                        </div> -->
                                                    </div>
                                                    <hr>
                                                    <button id="AdicionarForma" class="btn btn-dark btn-block  text-white">Adicionar Forma de
                                                        Pagamento</button>
                                                <?php } else {
                                            } ?>
                                                <div class="col-lg-12">
                                                    <div class="center">
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="form-group"><br>
                                                    <table class="table table-responsive-md table-hover mb-0" id="formasPagamento">
                                                        <thead>
                                                            <tr>
                                                                <th>Forma</th>
                                                                <th>Descri????o</th>
                                                                <!-- <th>RG</th> -->
                                                                <th>Valor</th>
                                                                <th>Troco</th>
                                                                <th>A????es</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                    </div>

                                    <!-- <hr>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a href="venda_finaliza.php?idpedido=<?php echo $row_rscli['idpedido'] ?>" class="btn btn-success btn-block text-weight-bold text-white" style="border:none;">Encerrar Venda <i class="fas fa-check-circle"></i></a>
                                        </div>
                                    </div> -->


                                </div>

                            </section>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
    <!-- end: page -->
</section>
</div>


</section>



<script type="text/javascript">
    // $('#AdicionarForma').click(function() {

    //     var idpedido = document.getElementById("idpedido").value;
    //     var forma = document.getElementById("forma").value;
    //     var tipo = document.getElementById("tipo").value;
    //     var valor = document.getElementById("valor").value;
    //     var valorrecebido = document.getElementById("valorrecebido").value;

    //     $.ajax({
    //         type: "POST",
    //         data: {
    //             idpedido: idpedido,
    //             forma: forma,
    //             tipo: tipo,
    //             valor: valor,
    //             valorrecebido: valorrecebido,
    //             paramTela: 'adicionarForma',
    //         },
    //         url: "classes/conect.php",
    //         success: function(r) {
    //             //alert(r);
    //             if (r == 1) {
    //                 alertify.success("Forma de Pagamento adicionada :)");
    //                 //$ ('#frmAdicionarProdutos').trigger ("reset");
    //                 // $("#produtos").selectedIndex = -1;
    //                 $('#referencia').val("");
    //                 $('#preco').val("");
    //                 $('#descricao').val("");
    //             } else if (r == 2) {
    //                 alertify.error("Insira um Valor ou Forma de Pagamento em Branco!");
    //             }
    //         },
    //         beforeSend: function() {
    //             $('.loading-icon').removeClass("oculto");
    //         },
    //         complete: function() {
    //             $('.loading-icon').addClass("oculto");
    //             gerarDadosUP();
    //         }
    //     });
    // });


    $("form#formaPag").submit(function(e) {
        e.preventDefault();

        var data = new FormData(this);

        // console.log(data);
        var valor_consumido = document.getElementById("preco").value;
        console.log(valor_consumido);

        var valor = document.getElementById("valor").value;
        console.log(valor);

        if (valor_consumido < valor) {
            console.log('deu ruim');
        }

        return;

        $.ajax({
            url: "classes/conect.php",
            type: "POST",
            data: data,
            mimeType: "multipart/form-data",
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            success: function(r) {
                //alert(r);

                if (r == 1) {
                    alertify.success("Forma de Pagamento adicionada :)");
                    //$ ('#frmAdicionarProdutos').trigger ("reset");
                    // $("#produtos").selectedIndex = -1;
                    $('#valor').val("0");
                    $('#descricao').val("");
                    formas.ajax.reload(null, false);
                } else if (r == 2) {
                    alertify.error("Insira um Valor ou Forma de Pagamento em Branco!");
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
    // var cont = 0;
    // var tabela = 0;
    // gerarDadosUP();

    // function gerarDadosUP() {
    //     var idpedido = document.getElementById("idpedido").value;
    //     $.ajax({
    //         type: 'POST',
    //         url: 'classes/conect.php',
    //         data: {
    //             idpedido: idpedido,
    //             paramTela: 'listarFormasPagamento'
    //         },
    //         success: function(data) {
    //             //$('#loading_table2').hide();                                                                                                          
    //             dados = null;
    //             dados = JSON.parse(data);
    //             if (cont == 0) {
    //                 cont++
    //             } else {
    //                 tabela.destroy();
    //             }
    //             // dados = [dados];
    //             tabela = $('#formasPagamento').DataTable({
    //                 "aaSorting": [
    //                     [1, "asc"]
    //                 ], //ordena????o da 2?? coluna do datatable para descendente 
    //                 "bInfo": false,
    //                 "scrollX": true, // cria o scroll no dataTable   
    //                 paging: false,
    //                 searching: false,
    //                 ordering: false,
    //                 data: dados,
    //                 columns: [ //head da table direto no javascript
    //                     {
    //                         title: 'Sigla'
    //                     },
    //                     {
    //                         title: 'Forma Pagamento'
    //                     },
    //                     {
    //                         title: 'Valor'
    //                     },
    //                     {
    //                         title: 'Troco'
    //                     },
    //                     {
    //                         title: 'A????es'
    //                     }
    //                 ],
    //                 language: { //PROPRIEDADES DO DATATABLE
    //                     "sEmptyTable": "Nenhum registro encontrado nesse per??odo",
    //                     "sInfo": "Mostrando de _START_ at?? _END_ de _TOTAL_ registros",
    //                     "sInfoEmpty": "Mostrando 0 at?? 0 de 0 registros",
    //                     "sInfoFiltered": "(Filtrados de MAX registros)",
    //                     "sInfoPostFix": "",
    //                     "sInfoThousands": ".",
    //                     "sLengthMenu": "_MENU_ Resultados por p??gina",
    //                     "sLoadingRecords": "Carregando...",
    //                     "sProcessing": "Processando...",
    //                     "sZeroRecords": "Nenhum registro encontrado",
    //                     "sSearch": "Pesquisar",
    //                     "oPaginate": {
    //                         "sNext": "Pr??ximo",
    //                         "sPrevious": "Anterior",
    //                         "sFirst": "Primeiro",
    //                         "sLast": "??ltimo"
    //                     },
    //                     "oAria": {
    //                         "sSortAscending": ": Ordenar colunas de forma ascendente",
    //                         "sSortDescending": ": Ordenar colunas de forma descendente"
    //                     },
    //                     "buttons": {
    //                         "copyTitle": "Copiar linhas"
    //                     }
    //                 },
    //                 // "columnDefs": [
    //                 //     {
    //                 //         "targets": [ 0 ],
    //                 //         "visible": false,
    //                 //         "searchable": false
    //                 //     },
    //                 // ] 				
    //             });
    //         }
    //     })
    // }
</script>

<script src="js/examples/examples.advanced.form.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('input[type="text"]').each(function() {
            var val = $(this).val().replace(',', '.');
            $(this).val(val);
        });
        var idpedido = document.getElementById("idpedido").value;

        formas = $('#formasPagamento').DataTable({

            "ajax": {
                "url": "classes/conect.php",
                "method": 'POST',
                "data": {
                    paramTela: 'listarFormasPagamento',
                    idpedido: idpedido,
                },
                "dataSrc": ""
            },
            "columnDefs": [{
                    className: 'text-center',
                    targets: [0, 1, 2, 3, 4]
                },
                // { width: 15, targets: [3,4,5,6,7,8] },
                // { width: 80, targets: 1 },
            ],
            paging: false,
            searching: false,
            ordering: false,
            info: false,
            "columns": [{
                    "data": 'forma'
                },
                {
                    "data": 'forma_descricao'
                },
                {
                    "data": 'valor'
                },
                {
                    "data": 'troco'
                },
                {
                    "data": 'btn'
                },
            ],
            language: { //PROPRIEDADES DO DATATABLE
                "sEmptyTable": "Nenhum registro encontrado nesse per??odo",
                "sInfo": "Mostrando de _START_ at?? _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 at?? 0 de 0 registros",
                "sInfoFiltered": "(Filtrados de MAX registros)",
                "sInfoPostFix": "",
                "sInfoThousands": ".",
                "sLengthMenu": "_MENU_ Resultados por p??gina",
                "sLoadingRecords": "Carregando...",
                "sProcessing": "Processando...",
                "sZeroRecords": "Nenhum registro encontrado",
                "sSearch": "Pesquisar",
                "oPaginate": {
                    "sNext": "Pr??ximo",
                    "sPrevious": "Anterior",
                    "sFirst": "Primeiro",
                    "sLast": "??ltimo"
                },
                "oAria": {
                    "sSortAscending": ": Ordenar colunas de forma ascendente",
                    "sSortDescending": ": Ordenar colunas de forma descendente"
                },
                "buttons": {
                    "copyTitle": "Copiar linhas"
                }
            }
        });
    });
</script>

<script type="text/javascript">
    function SubstituiVirgulaPorPonto(campo) {
        campo.value = campo.value.replace(/,/gi, ".");
    }
</script>

<script type="text/javascript">
    function valorreais(i) {
        var v = i.value.replace(/\D/g, '');
        v = (v / 100).toFixed(2) + '';
        v = v.replace(".", ",");
        i.value = v;
    }
</script>

<script type="text/javascript" src="vendor/priceformat/jquery.priceformat.min.js"></script>

<?php include 'footer_layout.php';  ?>