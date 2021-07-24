<?php
include 'menu_layout.php';
require_once "Connections/conexao.php";

?>


<style>
    .oculto {
        display: none;
    }

    /* Style para o loading dos tables */

    .button:disabled {
        opacity: 0.5;
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
                <li><span>Venda</span></li>
                <li><span>Tipo Venda</span></li>
            </ol>


        </div>
    </header>

    <!-- start: page -->
    <div class="row">
        <div class="col-md-12">
            <section class="card card-primary">
                <header class="card-header">
                    <h2 class="card-title">Novo Pedido</h2>
                </header>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-1">
                            <label class="control-label  text-weight-bold">ID</label>
                            <div class="input-group">
                                <input type="text" name="idcliente" id="idcliente" class="form-control" autocomplete="off" readonly required>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label class="control-label  text-weight-bold">Nome</label>
                            <div class="input-group">
                                <input type="text" name="nome_cli" id="nome_cli" class="form-control" autocomplete="off" autofocus required>
                            </div>
                            <div id="countryList"></div>
                        </div>
                        <!-- <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="control-label  text-weight-bold">Cidade</label>
                                    <input type="text" name="cidade" readonly class="form-control" />
                                </div>
                            </div> -->
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="control-label  text-weight-bold">Tipo</label>
                                <input type="text" name="tipo" value="Pedido" class="form-control" readonly />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="control-label  text-weight-bold">Incluir</label>
                                <a class="btn btn-block btn-dark h1 text-white" value="Venda" id="gerarVenda" name="gerarVenda" onclick="gerarVenda(this)" href="nova_venda.php"><i class="loading-icon fa fa-spinner fa-spin oculto"></i> Gerar Venda</a>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
        </div>
    </div>
</section>
</div>
<!-- end: page -->
</section>
</div>


</section>


<script type="text/javascript">
    function gerarVenda() {
        var titulo = $("#gerarVenda").attr("value");

        $.ajax({
            url: "classes/conect.php",
            method: "POST",
            data: {
                titulo: titulo,
                paramTela: 'gerarVenda',
            },
            success: function(r) {
                //alert(r);
                if (r == 1) {
                    alertify.success("Novo Pedido criado!");
                } else {
                    alertify.error("Não foi possível criar o Pedido!");
                }
            },
            beforeSend: function() {
                $('.loading-icon').removeClass("oculto");
            },
            complete: function() {
                $('.loading-icon').addClass("oculto");
            }
        });
    };

    $(document).ready(function() {
        $("input[name='nome_cli']").blur(function() {
            var $nome_cli = $("input[name='nome_cli']");
            var $idcliente = $("input[name='idcliente']");
            $.getJSON('pega_cli2.php', {
                nome: $(this).val()
            }, function(json) {
                $nome_cli.val(json.nome_cli);
                $idcliente.val(json.idcliente);
            });
        });

        $('#nome_cli').keyup(function() {
            var complete = $(this).val();
            if (complete != '') {
                $.ajax({
                    url: "classes/conect.php",
                    method: "POST",
                    data: {
                        param: complete,
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
            $('#nome_cli').val($(this).text());
            $('#countryList').fadeOut();
            $('#nome_cli').focus();
        });

    });

    function gerarVenda() {
        var titulo = $("#gerarVenda").attr("value");
        var idcliente = document.getElementById("idcliente").value;

        if (idcliente == 0 || idcliente == "") {
            // console.log('vazio');
            return;
        }

        $.ajax({
            url: "classes/conect.php",
            method: "POST",
            data: {
                titulo: titulo,
                param: idcliente,
                paramTela: 'gerarVenda',
            },
            success: function(r) {
                //alert(r);
                if (r == 1) {
                    alertify.success("Novo Pedido criado!");
                } else {
                    alertify.error("Não foi possível criar o Pedido!");
                }
            },
            beforeSend: function() {
                $('.loading-icon').removeClass("oculto");
            },
            complete: function() {
                $('.loading-icon').addClass("oculto");
            }
        });
    };
</script>



<?php include 'footer_layout.php';  ?>