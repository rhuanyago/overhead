<?php 
include 'menu_layout.php'; 
require_once "Connections/conexao.php";
$c = new conectar();
$conexao = $c->conexao();

$idpaginas = $_GET['idpagina'];

$sql = "SELECT * FROM tbpermissao  WHERE idpermissao = '$idpaginas';";
$sql = $conexao->query($sql);
$row = $sql->fetch_assoc();

$idPerfil = $idpaginas;
$paginas = [];
$sql = "SELECT * FROM tbpermissao_pages where idpermissao = '$idpaginas';";
$sql = $conexao->query($sql); 
while($r = $sql->fetch_assoc()){
  $paginas[] = $r['permissao_pages'];
  $idpermissao = $r['idpermissao'];
}   

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
							<li><span>Permissões</span></li>
							<li><span>Páginas</span></li>
						</ol>


					</div>
				</header>

				<!-- start: page -->
				<div class="row">
                    <div class="col-xl-12 order-1 mb-4">
                        <section class="card card-primary">
                            <header class="card-header">
                                <h2 class="card-title">Permissões <?php echo $row['permissao'];?></h2>
                                <input type="hidden" name="idpermissao" id="idpermissao" value="<?php echo $idpaginas;?>" > </h2>
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
                                        <div class="col-sm-12 text-left">
                                            <a href="cad_permissoes.php" class="btn btn-dark mt-2"><i class="fas fa-arrow-left"></i> Voltar</a>
                                        </div>
                                    </div>

                                    <?php
                                       

                                        $sql = "SELECT * from tbpaginas order by idpaginas";
                                        $result3 = $conexao->query($sql);
                                        
                                        while ($row = $result3->fetch_assoc()) { ?>
                                    
                                    <div class="form-group row">
                                        <label class="col-lg-6 control-label text-lg-right pt-2"><?php echo $row['nome_paginas'] ?></label>
                                        <div class="col-lg-6">
                                            <div class="switch switch-danger ">
                                                <input type="checkbox" name="switch" value="" onchange="addPag('<?php echo $row['paginas'] ?>');" <?php echo (in_array($row['paginas'],$paginas)) ? 'checked' : ''; ?> data-plugin-ios-switch  />
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <?php } ?>


                                    
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
function addPag(param){

    var nomeTela = param;
    var idpermissao = document.getElementById("idpermissao").value;
    console.log(nomeTela);
    $.ajax({
				url: "classes/conect.php",
            	method: "POST",
				   data:{
                       tela: nomeTela,
                       idpermissao: idpermissao,
					   paramTela: 'adicionarTela',
				},
				success:function(r){
				}
			});

    

}

</script>



<?php include 'footer_layout.php';  ?>