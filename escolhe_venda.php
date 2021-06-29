<?php 
include 'menu_layout.php'; 
require_once "Connections/conexao.php";

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
                                        <div class="alert alert-default text-center" style="border:none;height:430px;">
                                            <h2 class="text-center">Venda</h2>
                                            <div class="col-sm-12">
                                                <div class="form-group text-center">
                                                    <img src="img/venda.png" style="height:212px;width:auto;"><br><br><br>
                                                    <a class="btn btn-block btn-dark h1 text-white" value="Venda" id="gerarVenda" name="gerarVenda" onclick="gerarVenda(this)" href="nova_venda.php"><i class="loading-icon fa fa-spinner fa-spin oculto"></i> Gerar Venda</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="alert alert-default text-center" style="border:none;height:430px;">
                                            <h2 class="text-center">Lounge</h2>
                                            <div class="col-sm-12">
                                                <div class="form-group text-center">
                                                    <img src="img/narguile.png" style="height:236px;width:auto;"><br><br>
                                                    <a href="nova_comanda.php" style="border:none;" value="Lounge"  class="btn btn-block btn-danger h1">Gerar Comanda</a>
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

    function gerarVenda(){
        var titulo = $("#gerarVenda").attr("value");
                
        $.ajax({
            url: "classes/conect.php",
            method: "POST",
            data:{
                titulo: titulo,
                paramTela: 'gerarVenda',
            },
            success:function(r){
                //alert(r);
                if(r==1){
                    alertify.success("Novo Pedido criado!");
                }else{
                    alertify.error("Não foi possível criar o Pedido!");
                }
            },
            beforeSend: function(){
                $('.loading-icon').removeClass("oculto");
            },
            complete: function(){
                $('.loading-icon').addClass("oculto");
            }
        });
    };
</script>
    
    <script type="text/javascript">
    $('#btnAtualizaCategoria').click(function(){

        var idcategoria = document.getElementById("idcategoria").value;
        var categoria = document.getElementById("categoriaU").value;
        var habilitado = document.getElementById("habilitadoU").value;

        //dados=$('#frmCategoriaU').serialize();
        $.ajax({
            type:"POST",
            data:{
                idcategoria: idcategoria,
                categoria: categoria,
                habilitado: habilitado,
                paramTela: 'AtualizarCategoria',
            },
            url:"classes/conect.php",
            success:function(r){
                //alert(r);
                if(r==1){
                    alertify.success("Atualizado com Sucesso :)");
                    $('#atualizaCategoria').modal('hide');
                }else if(r==2){
                    alertify.error("Nao foi possivel atualizar, Campos em Branco!");
                }else{
                    alertify.error("Não foi possível atualizar a categoria!");
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

    <script>
        $(document).on("click", "#btnAtualizaCategoria", function () { //Função Modal Editar 
            var idcategoria = $(this).attr('data-idcategoria'); //Pegando os dados que são passados no botão
            var nome = $(this).attr('data-nome');  //Pegando os dados que são passados no botão
            var habilitado = $(this).attr('data-habilitado'); 
            $(".modal-body #idcategoria").val(idcategoria); // Jogando os valores nos seus respectivos campos dentro do corpo do Modal
            $(".modal-body #categoriaU").val(nome); // Jogando os valores nos seus respectivos campos dentro do corpo do Modal
            $(".modal-body #habilitadoU").val(habilitado); 
            $('#atualizaCategoria').on('shown.bs.modal', function () {
                $('#categoriaU').focus(); //pegando foco do campo MAC ao abrir
            });
        });
    </script>   
   

  <script type="text/javascript">

    function eliminarCategoria(idcategoria){
			alertify.confirm('Deseja excluir esta categoria?', function(){ 
				$.ajax({
					type:"POST",
					data:{'idcategoria': idcategoria,
                        paramTela: 'ExcluirCategoria'
                    },
					url:"classes/conect.php",
					success:function(r){
						if(r==1){
							alertify.success("Excluido com sucesso!!");
                            gerarDadosUP();
						}else{
							alertify.error("Não foi possivel Excluir essa categoria!");
						}
					}
				});
			}, function(){ 
				alertify.error('Cancelado !')
			});
		}

    </script>    



<?php include 'footer_layout.php';  ?>