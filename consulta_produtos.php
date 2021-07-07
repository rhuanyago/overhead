<?php
include 'menu_layout.php';
require_once "Connections/conexao.php";

$c = new conectar();
$conexao = $c->conexao();
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
                    <a>
                        <i class="fas fa-home"></i>
                    </a>
                </li>
                <li><span>Consultar</span></li>
                <li><span>Produtos</span></li>
            </ol>


        </div>
    </header>

    <!-- start: page -->
    <div class="row">
        <div class="col-xl-12 order-1 mb-4">
            <section class="card card-primary">
                <header class="card-header">
                    <h2 class="card-title">Consultar Produtos</h2>
                </header>
                <div class="card-body">
                    <div class="col-lg-12">
                        <section class="card">
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
                            <table class="table table-responsive-md table-hover mb-0" id="consultaProdutos">
                            </table>
                        </section>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- end: page -->

    <!-- Modal -->
    <div class="modal fade" id="atualizaProdutos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Atualizar Produto</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form id="frmProdutoU">
                        <input type="text" hidden="" id="idprodutoU" name="idprodutoU">
                        <?php
                        $sql = "SELECT * FROM tbcategorias order by idcategoria;";
                        $sql = $conexao->query($sql);
                        ?>
                        <label>Categoria</label>
                        <select name="categoriaU" id="categoriaU" class="form-control">
                            <?php while ($row = $sql->fetch_assoc()) { ?>
                                <option value="<?php echo $row['idcategoria'] ?>"><?php echo $row['nome'] ?></option>
                            <?php } ?>
                        </select>
                        <label>Descrição</label>
                        <input type="text" id="descricaoU" name="descricaoU" class="form-control input-sm">
                        <label>Referência</label>
                        <input autocomplete="off" inputmode="numeric" name="referenciaU" id="referenciaU" class="form-control input-sm" maxlength="8">
                        <label>Preço</label>
                        <input type="text" onkeyup="valorreais(this);" onfocus="valorreais(this)" inputmode="numeric" name="precoU" id="precoU" value="0" min="0" class="form-control input-sm">
                        <label>Estoque</label>
                        <input type="number" inputmode="numeric" name="estoqueU" id="estoqueU" value="0" min="0" class="form-control input-sm">
                        <label>Habilitado</label>
                        <select name="habilitadoU" id="habilitadoU" class="form-control">
                            <option value="S">Sim</option>
                            <option value="N">Não</option>
                        </select>
                        <label>Foto</label>
                        <img id="img" class="form-control " src="img/sem-foto.jpg" width=50\>
                        <!-- <span class='btn btn-danger text-white form-control' id='btnExcluirProdutos'><i class='far fa-trash-alt'></i></span> -->
                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="input-append">
                                <div class="uneditable-input">
                                    <i class="fas fa-file fileupload-exists"></i>
                                    <span class="fileupload-preview"></span>
                                </div>
                                <span class="btn btn-primary text-light btn-file">
                                    <span class="fileupload-exists">Trocar</span>
                                    <span class="fileupload-new">Selecionar Arquivo</span>
                                    <input type="file" class="fileToUpload " accept="image/*" onchange="preview_image(event)" name="fileUpload" />
                                </span>
                                <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remover</a>
                                <!-- <button type="button" class="btn btn-primary text-light fileupload-exists" id="enviar" onclick="uploadFile();"><i class="glyphicon glyphicon-floppy-open"></i> Enviar</button> -->
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <span id="btnAtualizaProdutos" name="btnAtualizaProdutos" class="btn btn-success"><i class="loading-icon fa fa-spinner fa-spin oculto"></i> Atualizar Informações</span>
                </div>
            </div>
        </div>
    </div>


</section>
</div>


</section>


<script type="text/javascript">
    $('#btnAtualizaProdutos').click(function() {

        var idproduto = document.getElementById("idprodutoU").value;
        var idcategoria = document.getElementById("categoriaU").value;
        var descricao = document.getElementById("descricaoU").value;
        var referencia = document.getElementById("referenciaU").value;
        var preco = document.getElementById("precoU").value;
        var estoque = document.getElementById("estoqueU").value;
        var habilitado = document.getElementById("habilitadoU").value;
        //dados=$('#frmCategoriaU').serialize();                

        $.ajax({
            type: "POST",
            data: {
                idproduto: idproduto,
                idcategoria: idcategoria,
                descricao: descricao,
                referencia: referencia,
                preco: preco,
                estoque: estoque,
                habilitado: habilitado,
                paramTela: 'AtualizarProdutos',
            },
            url: "classes/conect.php",
            success: function(r) {
                //alert(r);
                if (r == 1) {
                    alertify.success("Produto Atualizado com Sucesso :)");
                    $('#atualizaProdutos').modal('hide');
                } else {
                    alertify.error("Não foi possível atualizar as informações do Produto!");
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

<script>
    $(document).on("click", "#btnAtualizaProdutos", function() { //Função Modal Editar 
        var idproduto = $(this).attr('data-idproduto'); //Pegando os dados que são passados no botão
        var idcategoria = $(this).attr('data-idcategoria'); //Pegando os dados que são passados no botão
        var descricao = $(this).attr('data-descricao'); //Pegando os dados que são passados no botão
        var referencia = $(this).attr('data-referencia'); //Pegando os dados que são passados no botão
        var preco = $(this).attr('data-valor');
        var estoque = $(this).attr('data-estoque');
        var habilitado = $(this).attr('data-habilitado');
        var img = $(this).attr('data-img');
        $(".modal-body #idprodutoU").val(idproduto); // Jogando os valores nos seus respectivos campos dentro do corpo do Modal
        $(".modal-body #categoriaU").val(idcategoria); // Jogando os valores nos seus respectivos campos dentro do corpo do Modal
        $(".modal-body #descricaoU").val(descricao); // Jogando os valores nos seus respectivos campos dentro do corpo do Modal
        $(".modal-body #referenciaU").val(referencia); // Jogando os valores nos seus respectivos campos dentro do corpo do Modal
        $(".modal-body #precoU").val(preco); // Jogando os valores nos seus respectivos campos dentro do corpo do Modal
        $(".modal-body #estoqueU").val(estoque); // Jogando os valores nos seus respectivos campos dentro do corpo do Modal
        $(".modal-body #habilitadoU").val(habilitado);
        $('#atualizaProdutos').on('shown.bs.modal', function() {
            $('#descricaoU').focus(); //pegando foco do campo MAC ao abrir
        });

        $('.modal-body #img').attr('src', img);


    });
</script>

<script type="text/javascript">
    $(document).on("click", "#btnExcluirProdutos", function() { //Função Modal Editar MAC
        var idproduto = $(this).attr('data-idproduto');
        var referencia = $(this).attr('data-referencia');
        alertify.confirm('Deseja excluir este Produto?', function() {
            $.ajax({
                type: "POST",
                data: {
                    'idproduto': idproduto,
                    'referencia': referencia,
                    paramTela: 'ExcluirProdutos'
                },
                url: "classes/conect.php",
                success: function(r) {
                    if (r == 1) {
                        alertify.success("Produto excluido com sucesso!!");
                        gerarDadosUP();
                    } else {
                        alertify.error("Não foi possivel Excluir esse Produto!");
                    }
                }
            });
        }, function() {
            alertify.error('Cancelado !')
        });
    });
</script>

<script>
    var cont = 0;
    var tabela = 0;
    gerarDadosUP();

    function gerarDadosUP() {
        //$('#loading_table2').show();  
        $.ajax({
            type: 'POST',
            url: 'classes/conect.php',
            data: {
                paramTela: 'consultarProdutos'
            },
            success: function(data) {
                //$('#loading_table2').hide();                                                                                                          
                dados = null;
                dados = JSON.parse(data);
                if (cont == 0) {
                    cont++
                } else {
                    tabela.destroy();
                }
                // dados = [dados];
                tabela = $('#consultaProdutos').DataTable({
                    "aaSorting": [
                        [0, "asc"]
                    ], //ordenação da 2° coluna do datatable para descendente 
                    "bInfo": false,
                    "scrollX": false, // cria o scroll no dataTable   
                    autoWidth: true,
                    responsive: true,
                    // paging: false,     
                    searching: true,
                    ordering: true,
                    data: dados,
                    columns: [ //head da table direto no javascript
                        //{title: 'ID' }, 
                        {
                            title: 'Imagem'
                        },
                        {
                            title: 'Categoria'
                        },
                        {
                            title: 'Referência'
                        },
                        {
                            title: 'Descrição'
                        },
                        {
                            title: 'Preço'
                        },
                        {
                            title: 'Estoque'
                        },
                        {
                            title: 'Habilitado'
                        },
                        {
                            title: 'Ações'
                        },
                    ],
                    "columnDefs": [{
                            className: 'text-center',
                            targets: [0, 1, 2, 3, 4, 5, 6,7]
                        },
                        // { width: 15, targets: [3,4,5,6,7,8] },
                        {
                            width: 80,
                            targets: 0
                        },
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
                    }
                });
            }
        })
    }
</script>

<script type="text/javascript">
    // jQuery.noConflict();
    // jQuery(function($) {
    //     $("#referenciaU").mask("99.99999");
    // });
</script>

<script type="text/javascript">
    function valorreais(i) {
        var v = i.value.replace(/\D/g, '');
        v = (v / 100).toFixed(2) + '';
        v = v.replace(".", ",");
        v = v.replace(/(\d)(\d{3})(\d{3}),/g, "$1.$2.$3,");
        v = v.replace(/(\d)(\d{3}),/g, "$1.$2,");
        i.value = v;
    }
</script>

<?php include 'footer_layout.php';  ?>