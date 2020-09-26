<?php 
include 'menu_layout.php'; 
require_once "Connections/conexao.php";
require_once "classes/class.vision.php";
$obj = new vision();
$categoria = $obj->pegarCategoria();
//print_r($result);

?>


<style>
.oculto{
	display:none;		
}
.field.--has-error {
  border-color: #f00;
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
							<li><span>Cadastros</span></li>
							<li><span>Produtos</span></li>
						</ol>


					</div>
				</header>

				<!-- start: page -->
				<div class="row">
                    <div class="col-xl-12 order-1 mb-4">
                        <section class="card card-danger">
                            <header class="card-header">
                                <h2 class="card-title">Cadastro de Produtos</h2>
                            </header>
                            <div class="card-body">
                                <form class="form-horizontal form-bordered" id="registroProdutos" name="registroProdutos">

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

                                    <div class="form-group row">
                                        <label class="col-lg-3 control-label text-lg-right pt-2">Categoria</label>
                                        <div class="col-lg-6">
                                            <div class="input-group">
                                                <span class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-user"></i>
                                                    </span>
                                                </span>
                                                <select name="categoria" id="categoria" class="form-control">
                                                    <option value="ND">Selecione a Categoria</option>
                                                    <?php foreach ($categoria as $key => $categorias) {
                                                        echo $categorias;
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-3 control-label text-lg-right pt-2">Produto (Nome) </label>
                                        <div class="col-lg-6">
                                            <div class="input-group">
                                                <span class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-box"></i>
                                                    </span>
                                                </span>
                                                <input type="text" autocomplete="off" name="descricao" id="descricao" class="form-control" maxlength="50" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row" id="referencia-error">
                                        <label class="col-lg-3 control-label text-lg-right pt-2">Referência</label>
                                        <div class="col-lg-6">
                                            <div class="input-group">
                                                <span class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-barcode"></i>
                                                    </span>
                                                </span>
                                                <input autocomplete="off" inputmode="numeric" name="referencia" id="referencia"  class="form-control" maxlength="8" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-3 control-label text-lg-right pt-2">Preço</label>
                                        <div class="col-lg-6">
                                            <div class="input-group">
                                                <span class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-dollar-sign"></i>
                                                    </span>
                                                </span>
                                                <input type="text" onkeyup="valorreais(this);" inputmode="numeric" name="preco" id="preco" value="0" min="0" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-3 control-label text-lg-right pt-2">Habilitado</label>
                                        <div class="col-lg-6">
                                            <div class="input-group">
                                                <span class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-ban"></i>
                                                    </span>
                                                </span>
                                                <select name="habilitado" id="habilitado" class="form-control">
                                                    <option value="S">Sim</option>
                                                    <option value="N">Não</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-8 text-center">
                                            <span name="registrarProdutos" id="registrarProdutos" onclick="salvar()" class="btn btn-danger mt-2"><i class="loading-icon fa fa-spinner fa-spin oculto"></i> Inserir Produto</span>
                                            <a href="home.php" class="btn btn-dark mt-2">Voltar</a>
                                        </div>
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
        $(document).ready(function() {
            $('input[type="text"]').each(function() {
                var val = $(this).val().replace(',', '.');
                $(this).val(val);
            });
        });
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

    <script type="text/javascript">
        jQuery.noConflict();
        jQuery(function($) {
            $("#referencia").mask("99.99999");
        });
    </script>

    <script>
	function salvar(){ 
			
			var categoria = document.getElementById("categoria").value;
			var nome = document.getElementById("descricao").value;
			var referencia = document.getElementById("referencia").value;
			var preco = document.getElementById("preco").value;
			var habilitado = document.getElementById("habilitado").value;

			vazios=validarFormVazio('#registroProdutos');
		

			if(vazios > 0){
					document.getElementById("alert_error").classList.add("oculto"); //Caso o alert esteja na tela ele adiciona classe Oculto novamente pra esconde-lo!
				    document.getElementById("alert_ok").classList.add("oculto"); //Caso o alert esteja na tela ele adiciona classe Oculto novamente pra esconde-lo!
                    document.getElementById("alert_error").classList.remove("oculto"); //Remove o oculto da classe pra ser exibido!
                    document.getElementById("alert_error").innerHTML = ('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Atenção! Campos em Branco!</strong>'); //Msg de Campos em Branco
				return false;
			}

			// $(".loading-icon").removeClass("oculto");
        	// $("#btnRegistrar").attr("disabled", true); 

			//setTimeout(function () { //Função pra Esconder os alerts com o tempo!

			//dados=$('#registroUsuario').serialize();
			$.ajax({
				url: "classes/conect.php",
            	method: "POST",
				   data:{
					   categoria: categoria,
					   nome: nome,
					   referencia: referencia,
					   preco: preco,
					   habilitado: habilitado,
					   paramTela: 'adicionarProdutos',
				},
				success:function(r){
					//alert(r);

					if(r==1){
						document.getElementById("alert_error").classList.add("oculto"); //Caso o alert esteja na tela ele adiciona classe Oculto novamente pra esconde-lo!
						document.getElementById("referencia-error").classList.remove("has-danger");
						// $(".loading-icon").addClass("oculto");
                        // $("#btnRegistrar").attr("disabled", false);  
                    	document.getElementById("alert_ok").classList.remove("oculto"); //Remove o oculto da classe pra ser exibido!
                    	document.getElementById("alert_ok").innerHTML = ('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Sucesso! Novo Produto inserido com sucesso!</strong>'); //Msg de Campos em Branco
						$('#registroProdutos')[0].reset();
					}else if(r==0){
						document.getElementById("alert_ok").classList.add("oculto"); //Caso o alert esteja na tela ele adiciona classe Oculto novamente pra esconde-lo!
						// $(".loading-icon").addClass("oculto");
                        // $("#btnRegistrar").attr("disabled", false);  
                    	document.getElementById("alert_error").classList.remove("oculto"); //Remove o oculto da classe pra ser exibido!
						document.getElementById("referencia-error").classList.add("has-danger");
                    	document.getElementById("alert_error").innerHTML = ('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong> Referência já cadastrada, tente novamente!</strong>'); //Msg de Campos em Branco
						document.getElementById('referencia').value="";
						$("#email").text("").focus();
						return false;
					}else if(r==2){
						document.getElementById("alert_ok").classList.add("oculto"); //Caso o alert esteja na tela ele adiciona classe Oculto novamente pra esconde-lo!
						document.getElementById("referencia-error").classList.remove("has-danger");
						// $(".loading-icon").addClass("oculto");
                        // $("#btnRegistrar").attr("disabled", false);  
                    	document.getElementById("alert_error").classList.remove("oculto"); //Remove o oculto da classe pra ser exibido!
                    	document.getElementById("alert_error").innerHTML = ('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Categoria em Branco, seleciona uma categoria!</strong>'); //Msg de Campos em Branco
						return false;
					}
				},
				beforeSend: function(){
					$('.loading-icon').removeClass("oculto");
				},
				complete: function(){
					$('.loading-icon').addClass("oculto");
				}
			});
		//}, 3000); // O valor é representado em milisegundos.
		
	};
</script>



<?php include 'footer_layout.php';  ?>