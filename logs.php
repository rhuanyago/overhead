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
							<li><span>Util</span></li>
							<li><span>Logs</span></li>
						</ol>


					</div>
				</header>

				<!-- start: page -->
                
                <div class="row">
                    <div class="col-xl-12 order-1 mb-4">
                        <section class="card card-primary">
                            <header class="card-header">
                                <h2 class="card-title">Logs</h2>
                            </header>
                            <div class="card-body">                     
                                <table class="table table-responsive-md table-hover mb-0" id="consultaLogs">
                                </table>
                            </div>

                        </section>
                    </div>
                </div>

			</section>
		</div>


    </section>

        

<script>

var cont = 0;
var tabela = 0;
gerarDadosUP();
function gerarDadosUP(){
    $.ajax({
        type: 'POST',
        url: 'classes/conect.php',
        data: {
            paramTela: 'consultaLogs'    
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
            tabela = $('#consultaLogs').DataTable({  
                    "aaSorting": [[2, "desc"]],  //ordenação da 2° coluna do datatable para descendente 
                    "bInfo" :false,         
                    "scrollX": false, // cria o scroll no dataTable   
                    paging: true,     
                    searching: false,   
                    ordering: true,                                                          
    				data: dados, 
                    columns: [ //head da table direto no javascript
                        {title: 'ID User' }, 
                        {title: 'E-mail' },    
                        {title: 'Hora' },                        
                        {title: 'IP' },     
                        {title: 'Mensagem'  },                                               
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