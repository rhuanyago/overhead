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
							<li><span>Páginas</span></li>
						</ol>


					</div>
				</header>

				<!-- start: page -->
				<div class="row">
                    <div class="col-xl-12 order-1 mb-4">
                        <section class="card card-primary">
                            <header class="card-header">
                                <h2 class="card-title">Cadastro de Páginas</h2>
                            </header>

                            
                            <div class="card-body">
                                
                                <form class="form-horizontal form-bordered" id="registrarPaginas" name="registrarPaginas">                              

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
                                        <label class="col-lg-3 control-label text-lg-right pt-2">Nome da Página</label>
                                        <div class="col-lg-6">
                                            <div class="input-group">
                                                <span class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="far fa-file-alt"></i>
                                                    </span>
                                                </span>
                                                <input type="text" name="nome" id="nome" autocomplete="off" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="rg-error" class="form-group row ">
                                        <label class="col-lg-3 control-label text-lg-right pt-2">URL / Permissão</label>
                                        <div class="col-lg-6">
                                            <div class="input-group">
                                                <span class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-at"></i>
                                                    </span>
                                                </span>
                                                <input type="text" name="url" id="url" autocomplete="off" class="form-control" required>
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
                
                <div class="row">
                    <div class="col-xl-12 order-1 mb-4">
                        <section class="card card-default">
                            <header class="card-header">
                                <h2 class="card-title">Páginas</h2>
                            </header>
                            <div class="card-body">                     
                                <table class="table table-responsive-md table-hover mb-0" id="consultaPaginas">
                                </table>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="atualizaPaginas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog modal-md" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">Atualizar Página</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="frmCategoriaU">
                                                <input type="text" hidden="" id="idpaginas" name="idpaginas">
                                                <label>Pagina</label>
                                                <input type="text" id="paginaU" name="paginaU" class="form-control input-sm">
                                                <label>URL</label>
                                                <input type="text" id="urlU" name="urlU" class="form-control input-sm">
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" id="btnAtualizaPaginas" class="btn btn-success" ><i class="loading-icon fa fa-spinner fa-spin oculto"></i> Alterar Página</button>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </section>
                    </div>
                </div>
                
			</section>
		</div>


    </section>
    

    <script>
	function salvar(){ 

        var nome = document.getElementById("nome").value;
        var url = document.getElementById("url").value;

        vazios=validarFormVazio('#registrarPaginas');

			if(vazios > 0){
                    // $('#loading_table').hide();  
                    document.getElementById("alert_ok").classList.add("oculto"); //Caso o alert esteja na tela ele adiciona classe Oculto novamente pra esconde-lo!
                    document.getElementById("alert_error").classList.remove("oculto"); //Remove o oculto da classe pra ser exibido!
                    document.getElementById("alert_error").innerHTML = ('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Atenção! Campos em Branco!</strong>'); //Msg de Campos em Branco
				return false;
			}
            
			$.ajax({
				url: "classes/conect.php",
            	method: "POST",
				   data:{
					   nome: nome,
					   url: url,
					   paramTela: 'registrarPaginas',
				},
				success:function(r){
                    //alert(r);
					if(r==1){
						document.getElementById("alert_error").classList.add("oculto"); //Caso o alert esteja na tela ele adiciona classe Oculto novamente pra esconde-lo!
                        // $(".loading-icon").addClass("oculto");
                        // $("#btnRegistrar").attr("disabled", false);  
                        document.getElementById("rg-error").classList.remove("has-danger");
                        document.getElementById("alert_ok").classList.remove("oculto"); //Remove o oculto da classe pra ser exibido!
                    	document.getElementById("alert_ok").innerHTML = ('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Sucesso! Nova Página inserida!</strong>'); //Msg de Campos em Branco
                        $('#registrarPaginas')[0].reset();
                        gerarDadosUP();
                        // $('#loading_table').hide();  
					}else if(r==0){
                        // $(".loading-icon").addClass("oculto");
                        // $("#btnRegistrar").attr("disabled", false); 
						document.getElementById("alert_ok").classList.add("oculto"); //Caso o alert esteja na tela ele adiciona classe Oculto novamente pra esconde-lo!
                    	document.getElementById("alert_error").classList.remove("oculto"); //Remove o oculto da classe pra ser exibido!
                        document.getElementById("rg-error").classList.add("has-danger");
                    	document.getElementById("alert_error").innerHTML = ('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong> Página ja cadastrada, tente novamente!</strong>'); //Msg de Campos em Branco
						document.getElementById('url').value="";
						$("#url").text("").focus();
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

<script type="text/javascript">
    $('#btnAtualizaPaginas').click(function(){

        var idpaginas = document.getElementById("idpaginas").value;
        var pagina = document.getElementById("paginaU").value;
        var url = document.getElementById("urlU").value;

        //dados=$('#frmCategoriaU').serialize();
        $.ajax({
            type:"POST",
            data:{
                idpaginas: idpaginas,
                pagina: pagina,
                url: url,
                paramTela: 'AtualizarPaginas',
            },
            url:"classes/conect.php",
            success:function(r){
                //alert(r);
                if(r==1){
                    alertify.success("Atualizado com Sucesso :)");
                    $('#atualizaPaginas').modal('hide');
                    gerarDadosUP();
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
            }
        });
    });
</script>

<script>
    $(document).on("click", "#btnAtualizaPaginas", function () { //Função Modal Editar 
        var idpaginas = $(this).attr('data-idpaginas'); //Pegando os dados que são passados no botão
        var pagina = $(this).attr('data-pagina');  //Pegando os dados que são passados no botão
        var url = $(this).attr('data-url'); 
        $(".modal-body #idpaginas").val(idpaginas); // Jogando os valores nos seus respectivos campos dentro do corpo do Modal
        $(".modal-body #paginaU").val(pagina); // Jogando os valores nos seus respectivos campos dentro do corpo do Modal
        $(".modal-body #urlU").val(url); 
        $('#atualizaPaginas').on('shown.bs.modal', function () {
            $('#paginaU').focus(); //pegando foco do campo MAC ao abrir
        });
    });
</script>   

<script type="text/javascript">

$(document).on("click", "#btnExcluirPaginas", function () { //Função Modal Editar MAC
    var idpaginas = $(this).attr('data-idpaginas');
    alertify.confirm('Deseja excluir esta Página?', function(){ 
        $.ajax({
            type:"POST",
            data:{'idpaginas': idpaginas,
                paramTela: 'ExcluirPaginas'
            },
            url:"classes/conect.php",
            success:function(r){
                if(r==1){
                    alertify.success("Página excluída com sucesso!!");
                    gerarDadosUP();
                }else{
                    alertify.error("Não foi possível Excluir essa Página!");
                }
            }
        });
    }, function(){ 
        alertify.error('Cancelado !')
    });
});

</script>   

<script>

var cont = 0;
var tabela = 0;
gerarDadosUP();
function gerarDadosUP(){
    $.ajax({
        type: 'POST',
        url: 'classes/conect.php',
        data: {
            paramTela: 'consultaPaginas'    
        },
        success: function(data){  
            //$('#loading_table2').hide();                                                                                                          
            dados = null;
            dados = JSON.parse(data);
                if(cont == 0){
                    cont++
                }else {
                    tabela.destroy();
                }                    
            // dados = [dados];
            tabela = $('#consultaPaginas').DataTable({  
                    "aaSorting": [[0, "asc"]],  //ordenação da 2° coluna do datatable para descendente 
                    "bInfo" :false,         
                    "scrollX": false, // cria o scroll no dataTable   
                    // paging: false,     
                    searching: true,   
                    ordering: true,                                                          
    				data: dados, 
                    columns: [ //head da table direto no javascript
                        {title: 'Página' },                        
                        {title: 'URL' },     
                        {title: 'Ações'  },                                               
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
                } );
            }				
        })
    } 
</script>

<?php include 'footer_layout.php';  ?>