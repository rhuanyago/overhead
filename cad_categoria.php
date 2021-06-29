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
							<li><span>Categorias</span></li>
						</ol>


					</div>
				</header>

				<!-- start: page -->
				<div class="row">
                    <div class="col-xl-12">
                        <section class="card card-primary">
                            <header class="card-header">
                                <h2 class="card-title">Cadastro de Categorias</h2>
                            </header>
                            <div class="card-body">
                                <form class="form-horizontal form-bordered" id="frmCategorias" name="frmCategorias">

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
                                        <label class="col-lg-4 control-label text-lg-right pt-2">Categoria </label>
                                        <div class="col-lg-3">
                                            <div class="input-group">
                                                <span class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-box"></i>
                                                    </span>
                                                </span>
                                                <input type="text" name="categoria" id="categoria" class="form-control" required>
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
                                            <span id="btnAdicionarCategoria" name="btnAdicionarCategoria"class="btn btn-primary text-light mt-2 btn-txt"><i class="loading-icon fa fa-spinner fa-spin oculto"></i> Adicionar Categoria </span>
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
                                <h2 class="card-title">Categorias</h2>
                            </header>
                            <div class="card-body">                     
                                <table class="table table-responsive-md table-hover mb-0" id="consultaCategoria">
                                </table>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="atualizaCategoria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog modal-md" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">Atualizar Categorias</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="frmCategoriaU">
                                                <input type="text" hidden="" id="idcategoria" name="idcategoria">
                                                <label>Categoria</label>
                                                <input type="text" id="categoriaU" name="categoriaU" class="form-control input-sm">
                                                <label>Habilitado</label>
                                                <select name="habilitadoU" id="habilitadoU" class="form-control">
                                                    <option value="S">Sim</option>
                                                    <option value="N">Não</option>
                                                </select>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" id="btnAtualizaCategoria" class="btn btn-success" ><i class="loading-icon fa fa-spinner fa-spin oculto"></i> Alterar Categoria</button>

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

    $('#btnAdicionarCategoria').click(function(){

        var categoria = document.getElementById("categoria").value;
        var habilitado = document.getElementById("habilitado").value;

                
        $.ajax({
            url: "classes/conect.php",
            method: "POST",
            data:{
                categoria: categoria,
                habilitado: habilitado,
                paramTela: 'AdicionarCategoria',
            },
            success:function(r){
                //alert(r);
                if(r==1){
                //limpar formulário
                $('#frmCategorias')[0].reset();
                    alertify.success("Categoria adicionada com sucesso!");
                }else if(r==0){
                    alertify.error("Ja existe essa categoria!");
                }else if(r==2){
                    alertify.error("Nao foi possivel adicionar, Campos em Branco!");
                }else{
                    alertify.error("Não foi possível adicionar a categoria");
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

<script>

var cont = 0;
var tabela = 0;
gerarDadosUP();
function gerarDadosUP(){
    $.ajax({
        type: 'POST',
        url: 'classes/conect.php',
        data: {
            paramTela: 'ConsultarCategoria'    
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
            tabela = $('#consultaCategoria').DataTable({  
                    "aaSorting": [[0, "asc"]],  //ordenação da 2° coluna do datatable para descendente 
                    "bInfo" :false,         
                    "scrollX": false, // cria o scroll no dataTable   
                    // paging: false,     
                    searching: true,   
                    ordering: true,                                                          
    				data: dados, 
                    columns: [ //head da table direto no javascript
                        {title: 'ID Categoria' },    
                        {title: 'Categoria' },                        
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