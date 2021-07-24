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
                    <h2 class="card-title">Tipo de Pedido</h2>
                </header>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="alert  text-center" style="border:none;height:auto;">
                                <h2 class="text-center">Venda</h2>
                                <div class="col-sm-12">
                                    <div class="form-group text-center">
                                        <img src="img/venda2.png" style="height:212px;width:auto;"><br><br><br>
                                        <a class="btn btn-block btn-dark h1 text-white" value="Venda" id="gerarVenda" name="gerarVenda" href="escolhe_venda.php"><i class="loading-icon fa fa-spinner fa-spin oculto"></i> Gerar Venda</a>
                                    </div>
                                </div>
                            </div>


                        </div>


                        <div class="col-md-6">
                            <div class="alert text-center" style="border:none;height:430px;">
                                <h2 class="text-center">Compra</h2>
                                <div class="col-sm-12">
                                    <div class="form-group text-center">
                                        <img src="img/compra.png" style="height:236px;width:auto;"><br><br>
                                        <a href="nova_comanda.php" style="border:none;" value="Compra" class="btn btn-block btn-danger h1">Gerar Comanda</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</section>
</div>
<!-- end: page -->
</section>
</div>


</section>


<script type="text/javascript">
    // function gerarVenda() {
    //     var titulo = $("#gerarVenda").attr("value");
    //     var complete = document.getElementById("complete");

    //     $.ajax({
    //         url: "classes/conect.php",
    //         method: "POST",
    //         data: {
    //             titulo: titulo,
    //             param: complete,
    //             paramTela: 'gerarVenda',
    //         },
    //         success: function(r) {
    //             //alert(r);
    //             if (r == 1) {
    //                 alertify.success("Novo Pedido criado!");
    //             } else {
    //                 alertify.error("Não foi possível criar o Pedido!");
    //             }
    //         },
    //         beforeSend: function() {
    //             $('.loading-icon').removeClass("oculto");
    //         },
    //         complete: function() {
    //             $('.loading-icon').addClass("oculto");
    //         }
    //     });
    // };

</script>



<?php include 'footer_layout.php';  ?>