<?php 
include 'menu_layout.php'; 
require_once "Connections/conexao.php";

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
							<li><span>Usuarios</span></li>
						</ol>


					</div>
				</header>

				<!-- start: page -->
				<div class="row">
					<div class="col-xl-12 order-1 mb-4">
						<section class="card card-danger">
							<header class="card-header">
								<h2 class="card-title">Cadastro de Usuários</h2>
							</header>
							<div class="card-body">
								<form class="form-horizontal form-bordered" id="registroUsuario">

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

									<div id="nome-error" class="form-group row">
										<label class="col-lg-3 control-label text-lg-right pt-2">Nome</label>
										<div class="col-lg-6">
											<div class="input-group">
												<span class="input-group-prepend">
													<span class="input-group-text">
														<i class="fas fa-user"></i>
													</span>
												</span>
												<input type="text" name="nome" id="nome" autocomplete="off" class="form-control" required maxlength="100">
											</div>
										</div>
									</div>

									<div id="email-error" class="form-group row">
										<label class="col-lg-3 control-label text-lg-right pt-2" for="email">E-mail</label>
										<div class="col-lg-6">
											<div class="input-group mb-3">
												<span class="input-group-prepend">
													<span class="input-group-text">
														<i class="fas fa-envelope"></i>
													</span>
												</span>
												<input type="email" autocomplete="off" name="email" autocomplete="off" class="form-control" id="email" required>
											</div>
										</div>
									</div>

									<div class="form-group row">
										<label class="col-lg-3 control-label text-lg-right pt-2">Senha</label>
										<div class="col-lg-6">
											<div class="input-group">
												<span class="input-group-prepend">
													<span class="input-group-text">
														<i class="fas fa-user"></i>
													</span>
												</span>
												<input type="password" autocomplete="off" name="senha" id="senha" autocomplete="off" class="form-control" required minlength="6" maxlength="10">
											</div>
										</div>
									</div>

									<div class="form-group row">
										<label class="col-lg-3 control-label text-lg-right pt-2">Confirmar Senha</label>
										<div class="col-lg-6">
											<div class="input-group">
												<span class="input-group-prepend">
													<span class="input-group-text">
														<i class="fas fa-user"></i>
													</span>
												</span>
												<input type="password" autocomplete="off" name="senha_confirma" id="senha_confirma" autocomplete="off" class="form-control" required minlength="6" maxlength="10">
											</div>
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
												<input autocomplete="off" inputmode="numeric" name="dtnascimento" id="dtnascimento" data-plugin-masked-input data-input-mask="99/99/9999" placeholder="__/__/____" class="form-control" required>
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
												<input autocomplete="off" inputmode="numeric" name="telefone" id="telefone" placeholder="(DD) 99699-1234" data-plugin-masked-input data-input-mask="(99) 99999-9999" class="form-control" required>
											</div>
										</div>
									</div>

									<div class="form-group row">
										<label class="col-lg-3 control-label text-lg-right pt-2">Função</label>
										<div class="col-lg-6">
											<div class="input-group">
												<span class="input-group-prepend">
													<span class="input-group-text">
														<i class="fas fa-user"></i>
													</span>
												</span>
												<select name="permissao" id="permissao" class="form-control">
													<option value="">Selecione</option>
													<?php
													$c = new conectar();
													$conexao=$c->conexao();
													
													$sql = "SELECT * from tbpermissao where permissao <> 'SUPER-ADMIN' order by idpermissao";
													$sql = $conexao->query($sql);
													while ($rows_rsperm = mysqli_fetch_assoc($sql)) { ?>
														<option value="<?php echo $rows_rsperm['idpermissao'] ?>"><?php echo $rows_rsperm['permissao'] ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-sm-8 text-center">
											<span id="registrarUsuario" name="registrarUsuario" onclick="salvar()" class="btn btn-danger mt-2"> <i class="loading-icon fa fa-spinner fa-spin oculto"></i> Cadastrar</span>
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
			var email = document.getElementById("email").value;
			var senha = document.getElementById("senha").value;
			var senha_confirma = document.getElementById("senha_confirma").value;
			var dtnascimento = document.getElementById("dtnascimento").value;
			var telefone = document.getElementById("telefone").value;
			var permissao = document.getElementById("permissao").value;

			vazios=validarFormVazio('#registroUsuario');
		

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
					   nome: nome,
					   email: email,
					   senha: senha,
					   senha_confirma: senha_confirma,
					   dtnascimento: dtnascimento,
					   telefone: telefone,
					   permissao:permissao,
					   paramTela: 'registrarUsuario',
				},
				success:function(r){
					//alert(r);

					if(r==1){
						document.getElementById("alert_error").classList.add("oculto"); //Caso o alert esteja na tela ele adiciona classe Oculto novamente pra esconde-lo!
						document.getElementById("email-error").classList.remove("has-danger");
						// $(".loading-icon").addClass("oculto");
                        // $("#btnRegistrar").attr("disabled", false);  
                    	document.getElementById("alert_ok").classList.remove("oculto"); //Remove o oculto da classe pra ser exibido!
                    	document.getElementById("alert_ok").innerHTML = ('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Sucesso! Novo Usuário inserido com sucesso!</strong>'); //Msg de Campos em Branco
						$('#registroUsuario')[0].reset();
					}else if(r==0){
						document.getElementById("alert_ok").classList.add("oculto"); //Caso o alert esteja na tela ele adiciona classe Oculto novamente pra esconde-lo!
						// $(".loading-icon").addClass("oculto");
                        // $("#btnRegistrar").attr("disabled", false);  
                    	document.getElementById("alert_error").classList.remove("oculto"); //Remove o oculto da classe pra ser exibido!
						document.getElementById("email-error").classList.add("has-danger");
                    	document.getElementById("alert_error").innerHTML = ('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong> E-mail já cadastrado, tente novamente!</strong>'); //Msg de Campos em Branco
						document.getElementById('email').value="";
						$("#email").text("").focus();
						return false;
					}else if(r==2){
						document.getElementById("alert_ok").classList.add("oculto"); //Caso o alert esteja na tela ele adiciona classe Oculto novamente pra esconde-lo!
						document.getElementById("email-error").classList.remove("has-danger");
						// $(".loading-icon").addClass("oculto");
                        // $("#btnRegistrar").attr("disabled", false);  
                    	document.getElementById("alert_error").classList.remove("oculto"); //Remove o oculto da classe pra ser exibido!
                    	document.getElementById("alert_error").innerHTML = ('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Atenção! As senhas não são iguais, tente novamente!</strong>'); //Msg de Campos em Branco
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