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
								<a>
									<i class="fas fa-home"></i>
								</a>
							</li>
							<li><span>Cadastros</span></li>
							<li><span>Clientes</span></li>
						</ol>


					</div>
				</header>

				<!-- start: page -->
				<div class="row">
                    <div class="col-xl-12 order-1 mb-4">
                        <section class="card card-primary">
                            <header class="card-header">
                                <h2 class="card-title">Cadastro de Clientes</h2>
                            </header>

                            
                            <div class="card-body">
                                
                                <form class="form-horizontal form-bordered" id="registrarCliente" name="registrarCliente">                              

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
                                        <label class="col-lg-3 control-label text-lg-right pt-2">Nome</label>
                                        <div class="col-lg-6">
                                            <div class="input-group">
                                                <span class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-user"></i>
                                                    </span>
                                                </span>
                                                <input type="text" name="nome" id="nome" autocomplete="off" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="rg-error" class="form-group row ">
                                        <label class="col-lg-3 control-label text-lg-right pt-2">RG</label>
                                        <div class="col-lg-6">
                                            <input type="text" name="rg" id="rg" inputmode="numeric" autocomplete="off" data-plugin-masked-input data-input-mask="99.999.999-9"  class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-3 control-label text-lg-right pt-2">Data de Nascimento</label>
                                        <div class="col-lg-6">
                                            <div class="input-group">
                                                <span class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-calendar-alt"></i>
                                                    </span>
                                                </span>
                                                <input name="dtnascimento" id="dtnascimento" inputmode="numeric" data-plugin-masked-input data-input-mask="99/99/9999" placeholder="__/__/____" class="form-control" autocomplete="off" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-3 control-label text-lg-right pt-2">Telefone</label>
                                        <div class="col-lg-6">
                                            <div class="input-group">
                                                <span class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-phone"></i>
                                                    </span>
                                                </span>
                                                <input id="telefone" name="telefone" inputmode="numeric" autocomplete="off" placeholder="(DD) 99699-1234" data-plugin-masked-input data-input-mask="(99) 99999-9999" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-8 text-center">
                                            <span id="btnRegistrar" name="btnRegistrar" onclick="salvar()" class="btn btn-primary text-light mt-2 btn-txt"><i class="loading-icon fa fa-spinner fa-spin oculto"></i> Cadastrar </span>
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
    

    <script>
	function salvar(){ 

        var nome = document.getElementById("nome").value;
        var rg = document.getElementById("rg").value;
        var dtnascimento = document.getElementById("dtnascimento").value;
        var telefone = document.getElementById("telefone").value;

        vazios=validarFormVazio('#registrarCliente');

			if(vazios > 0){
                    // $('#loading_table').hide();  
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
					   nome: nome,
					   rg: rg,
					   dtnascimento: dtnascimento,
					   telefone: telefone,
					   paramTela: 'registrarCliente',
				},
				success:function(r){
                    //alert(r);
					if(r==1){
						document.getElementById("alert_error").classList.add("oculto"); //Caso o alert esteja na tela ele adiciona classe Oculto novamente pra esconde-lo!
                        // $(".loading-icon").addClass("oculto");
                        // $("#btnRegistrar").attr("disabled", false);  
                        document.getElementById("rg-error").classList.remove("has-danger");
                        document.getElementById("alert_ok").classList.remove("oculto"); //Remove o oculto da classe pra ser exibido!
                    	document.getElementById("alert_ok").innerHTML = ('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Sucesso! Novo Usuario inserido com sucesso!</strong>'); //Msg de Campos em Branco
                        $('#registrarCliente')[0].reset();
                        // $('#loading_table').hide();  
					}else if(r==0){
                        // $(".loading-icon").addClass("oculto");
                        // $("#btnRegistrar").attr("disabled", false); 
						document.getElementById("alert_ok").classList.add("oculto"); //Caso o alert esteja na tela ele adiciona classe Oculto novamente pra esconde-lo!
                    	document.getElementById("alert_error").classList.remove("oculto"); //Remove o oculto da classe pra ser exibido!
                        document.getElementById("rg-error").classList.add("has-danger");
                    	document.getElementById("alert_error").innerHTML = ('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong> RG ja cadastrado, tente novamente!</strong>'); //Msg de Campos em Branco
						document.getElementById('rg').value="";
						$("#rg").text("").focus();
						return false;
					}else if(r==2){
                        // $(".loading-icon").addClass("oculto");
                        // $("#btnRegistrar").attr("disabled", false); 
						document.getElementById("alert_ok").classList.add("oculto"); //Caso o alert esteja na tela ele adiciona classe Oculto novamente pra esconde-lo!
                    	document.getElementById("alert_error").classList.remove("oculto"); //Remove o oculto da classe pra ser exibido!
                    	document.getElementById("alert_error").innerHTML = ('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Atenção! As senhas nao sao iguais, tente novamente!</strong>'); //Msg de Campos em Branco
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
        //    }, 3000); // O valor é representado em milisegundos.
		};
</script>



<?php include 'footer_layout.php';  ?>