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
							<li><span>Consultar</span></li>
							<li><span>Clientes</span></li>
						</ol>


					</div>
				</header>

				<!-- start: page -->
				<div class="row">
                    <div class="col-xl-12 order-1 mb-4">
                        <section class="card card-danger">
                            <header class="card-header">
                                <h2 class="card-title">Consultar Clientes</h2>
                            </header>
                            <div class="card-body">
                                <div class="col-lg-12">
                                    <section class="card">
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
                                        <table class="table table-responsive-md table-hover mb-0" id="consultaCliente">
                                            <thead>
                                                <tr>
                                                    <th>Reg</th>
                                                    <th>Nome</th>
                                                    <th>RG</th>                                
                                                    <th>Telefone</th>  
                                                    <th>Data de Nascimento</th>
                                                    <th>Habilitado</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </section>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
                <!-- end: page -->

                <!-- Modal -->
                <div class="modal fade" id="atualizaClientes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">Atualizar Clientes</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <form id="frmCategoriaU">
                                    <input type="text" hidden="" id="regU" name="regU">
                                    <label>Nome</label>
                                    <input type="text" id="nomeU" name="nomeU" class="form-control input-sm">
                                    <label>RG</label>
                                    <input type="text" id="rgU" name="rgU" data-plugin-masked-input data-input-mask="99.999.999-9" class="form-control input-sm">
                                    <label>Telefone</label>
                                    <input type="text" id="telefoneU" name="telefoneU" data-plugin-masked-input data-input-mask="(99) 99999-9999" class="form-control input-sm">
                                    <label>Data de Nascimento</label>
                                    <input type="text" id="dtnascimentoU" name="dtnascimentoU" data-plugin-masked-input data-input-mask="99/99/9999" class="form-control input-sm">
                                    <label>Habilitado</label>
                                    <select name="habilitadoU" id="habilitadoU" class="form-control">
                                        <option value="S">Sim</option>
                                        <option value="N">Não</option>
                                    </select>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <span id="btnAtualizaCliente" name="btnAtualizaCliente" class="btn btn-success" ><i class="loading-icon fa fa-spinner fa-spin oculto"></i> Atualizar Informações</span>
                            </div>
                        </div>
                    </div>
                </div>               
                

			</section>
		</div>


    </section>
    
    
    <script type="text/javascript">

			

    </script>
    
<script>
    
</script>

<script type="text/javascript">



</script>    


<script>

$(document).ready(function(){
    
    clientes = $('#consultaCliente').DataTable({  
        "ajax":{            
            "url": "classes/conect.php", 
            "method": 'POST', //usamos el metodo POST
            "data":{
                paramTela: 'consultarCliente'    
            }, //enviamos opcion 4 para que haga un SELECT
            "dataSrc":""
        },
        "columnDefs": [
            { className: 'text-center', targets: [0,1,2,3,4,5,6]},
            // { width: 15, targets: [3,4,5,6,7,8] },
            // { width: 80, targets: 1 },
        ],
        "columns":[
            {"data": 'reg' },                        
            {"data": 'nome' } ,
            {"data": 'rg' },                        
            {"data": 'telefone' },    
            {"data": 'dt_nascimento' },                        
            {"data": 'habilitado' } ,    
            {"data": 'btn'  }, 
        ]
    }); 

    $(document).on("click", "#btnAtualizaClientes", function () { //Função Modal Editar MAC
        var reg = $(this).attr('data-reg'); //Pegando os dados que são passados no botão
        var nome = $(this).attr('data-nome');  //Pegando os dados que são passados no botão
        var rg = $(this).attr('data-rg');  //Pegando os dados que são passados no botão
        var telefone = $(this).attr('data-telefone');  //Pegando os dados que são passados no botão
        var dtnascimento = $(this).attr('data-dt_nascimento');
        var habilitado = $(this).attr('data-habilitado');
        $(".modal-body #regU").val(reg); // Jogando os valores nos seus respectivos campos dentro do corpo do Modal
        $(".modal-body #nomeU").val(nome); // Jogando os valores nos seus respectivos campos dentro do corpo do Modal
        $(".modal-body #rgU").val(rg); // Jogando os valores nos seus respectivos campos dentro do corpo do Modal
        $(".modal-body #telefoneU").val(telefone); 
        $(".modal-body #dtnascimentoU").val(dtnascimento); 
        $(".modal-body #habilitadoU").val(habilitado); 
        $('#atualizaClientes').on('shown.bs.modal', function () {
            $('#nomeU').focus(); //pegando foco do campo MAC ao abrir
        });
    });


    $('#btnAtualizaCliente').click(function(){

        var reg = document.getElementById("regU").value;
        var nome = document.getElementById("nomeU").value;
        var rg = document.getElementById("rgU").value;
        var telefone = document.getElementById("telefoneU").value;
        var dtnascimento = document.getElementById("dtnascimentoU").value;
        var habilitado = document.getElementById("habilitadoU").value;        

            $.ajax({
                type:"POST",
                data:{
                    reg: reg,
                    nome: nome,
                    rg: rg,
                    telefone: telefone,
                    dtnascimento: dtnascimento,
                    habilitado: habilitado,
                    paramTela: 'AtualizarClientes',
                },
                url:"classes/conect.php",
                success:function(r){
                    //alert(r);
                    if(r==1){
                        alertify.success("Cliente Atualizado com Sucesso :)");
                        clientes.ajax.reload(null, false);
                    }else if(r==2){
                        alertify.error("Nao foi possível atualizar, Campos em Branco!");
                    }else if(r==0){
                        alertify.error("Esse RG ja esta cadastrado!");
                    }else{
                        alertify.error("Não foi possível atualizar as informações do Cliente!");
                    }
                },
                beforeSend: function(){
                    $('.loading-icon').removeClass("oculto");
                },
                complete: function(){
                    $('.loading-icon').addClass("oculto");
                    $('#atualizaClientes').modal('hide');                    
                }
            });
        });


    $(document).on("click", "#btnExcluirClientes", function () { //Função Modal Editar MAC
        var reg = $(this).attr('data-reg');
        alertify.confirm('Deseja excluir este Cliente?', function(){ 
            $.ajax({
                type:"POST",
                data:{'reg': reg,
                    paramTela: 'ExcluirCliente'
                },
                url:"classes/conect.php",
                success:function(r){
                    if(r==1){
                        alertify.success("Cliente excluido com sucesso!!");
                        clientes.ajax.reload(null, false);
                    }else{
                        alertify.error("Não foi possivel Excluir esse Cliente!");
                    }
                }
            });
        }, function(){ 
            alertify.error('Cancelado !')
        });
    });

});

</script>

<?php include 'footer_layout.php';  ?>