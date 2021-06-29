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
							<li><span>Permissões</span></li>
						</ol>


					</div>
				</header>

				<!-- start: page -->
				<div class="row">
                    <div class="col-xl-12">
                        <section class="card card-primary">
                            <header class="card-header">
                                <h2 class="card-title">Cadastro de Permissões</h2>
                            </header>
                            <div class="card-body">
                                <form class="form-horizontal form-bordered" id="frmPermissao" name="frmPermissao">

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
                                        <label class="col-lg-4 control-label text-lg-right pt-2">Permissão </label>
                                        <div class="col-lg-3">
                                            <div class="input-group">
                                                <span class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-box"></i>
                                                    </span>
                                                </span>
                                                <input type="text" name="permissao" id="permissao" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-4 control-label text-lg-right pt-2">Habilitado</label>
                                        <div class="col-lg-3">
                                            <div class="input-group">
                                                <span class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-ban"></i>
                                                    </span>
                                                </span>
                                                <select name="habilitado" id="habilitado" class="form-control">
                                                    <option value="ND">Selecione</option>
                                                    <option value="S">Sim</option>
                                                    <option value="N">Não</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-10 text-center">
                                            <span id="btnAdicionarPermissao" name="btnAdicionarPermissao"class="btn btn-primary text-light mt-2 btn-txt"><i class="loading-icon fa fa-spinner fa-spin oculto"></i> Adicionar Permissão </span>
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
                                <h2 class="card-title">Permissões</h2>
                            </header>
                            <div class="card-body">                     
                                <table class="table table-responsive-md table-hover mb-0" id="consultaPermissao">
                                </table>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="atualizaPermissao" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog modal-md" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">Atualizar Permissões</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="frmPermissaoU">
                                                <input type="text" hidden="" id="idpermissao" name="idpermissao">
                                                <label>Permissão</label>
                                                <input type="text" id="permissaoU" name="permissaoU" class="form-control input-sm">
                                                <label>Habilitado</label>
                                                <select name="habilitadoU" id="habilitadoU" class="form-control">
                                                    <option value="S">Sim</option>
                                                    <option value="N">Não</option>
                                                </select>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" id="btnAtualizaPermissao" class="btn btn-success" ><i class="loading-icon fa fa-spinner fa-spin oculto"></i> Alterar Permissão</button>
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
    

<script type="text/javascript">  

    $('#btnAdicionarPermissao').click(function(){

        var permissao = document.getElementById("permissao").value;
        var habilitado = document.getElementById("habilitado").value;

                
        $.ajax({
            url: "classes/conect.php",
            method: "POST",
            data:{
                permissao: permissao,
                habilitado: habilitado,
                paramTela: 'AdicionarPermissao',
            },
            success:function(r){
                //alert(r);
                if(r==1){
                //limpar formulário
                $('#frmPermissao')[0].reset();
                    alertify.success("Permissão adicionada com sucesso!");
                }else if(r==0){
                    alertify.error("Ja existe essa Permissão!");
                }else if(r==2){
                    alertify.error("Nao foi possível adicionar, Campos em Branco!");
                }else{
                    alertify.error("Não foi possível adicionar a Permissão");
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
    
    <script type="text/javascript">
    $('#btnAtualizaPermissao').click(function(){

        var idpermissao = document.getElementById("idpermissao").value;
        var permissao = document.getElementById("permissaoU").value;
        var habilitado = document.getElementById("habilitadoU").value;

        //dados=$('#frmCategoriaU').serialize();
        $.ajax({
            type:"POST",
            data:{
                idpermissao: idpermissao,
                permissao: permissao,
                habilitado: habilitado,
                paramTela: 'AtualizarPermissao',
            },
            url:"classes/conect.php",
            success:function(r){
                //alert(r);
                if(r==1){
                    alertify.success("Atualizado com Sucesso :)");
                    $('#atualizaPermissao').modal('hide');
                }else if(r==2){
                    alertify.error("Nao foi possivel atualizar, Campos em Branco!");
                }else{
                    alertify.error("Não foi possível atualizar a permissão!");
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
        $(document).on("click", "#btnAtualizaPermissao", function () { //Função Modal Editar 
            var idpermissao = $(this).attr('data-idpermissao'); //Pegando os dados que são passados no botão
            var permissao = $(this).attr('data-permissao');  //Pegando os dados que são passados no botão
            var habilitado = $(this).attr('data-habilitado'); 
            $(".modal-body #idpermissao").val(idpermissao); // Jogando os valores nos seus respectivos campos dentro do corpo do Modal
            $(".modal-body #permissaoU").val(permissao); // Jogando os valores nos seus respectivos campos dentro do corpo do Modal
            $(".modal-body #habilitadoU").val(habilitado); 
            $('#atualizaPermissao').on('shown.bs.modal', function () {
                $('#permissaoU').focus(); //pegando foco do campo MAC ao abrir
            });
        });
    </script>   
   

  <script type="text/javascript">

    function eliminarCategoria(idpermissao){
			alertify.confirm('Deseja excluir esta permissão?', function(){ 
				$.ajax({
					type:"POST",
					data:{'idpermissao': idpermissao,
                        paramTela: 'ExcluirPermissao'
                    },
					url:"classes/conect.php",
					success:function(r){
						if(r==1){
							alertify.success("Excluido com sucesso!!");
                            gerarDadosUP();
						}else{
							alertify.error("Não foi possivel Excluir essa Permissão!");
						}
					}
				});
			}, function(){ 
				alertify.error('Cancelado !')
			});
		}

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
            paramTela: 'consultaPermissao'    
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
            tabela = $('#consultaPermissao').DataTable({  
                    "aaSorting": [[0, "asc"]],  //ordenação da 2° coluna do datatable para descendente 
                    "bInfo" :false,         
                    "scrollX": false, // cria o scroll no dataTable   
                    // paging: false,     
                    searching: true,   
                    ordering: true,                                                          
    				data: dados, 
                    columns: [ //head da table direto no javascript
                        {title: 'ID Permissao' },    
                        {title: 'Permissao' },                        
                        {title: 'Habilitado' },     
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