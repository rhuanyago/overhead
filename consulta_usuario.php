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
							<li><span>Usuários</span></li>
						</ol>


					</div>
				</header>

				<!-- start: page -->
				<div class="row">
                    <div class="col-xl-12 order-1 mb-4">
                        <section class="card card-danger">
                            <header class="card-header">
                                <h2 class="card-title">Consultar Usuários</h2>
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
                                        <table class="table table-responsive-md table-hover mb-0" id="consultaUsuario">
                                        </table>
                                    </section>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
                <!-- end: page -->

                <!-- Modal -->
                <div class="modal fade" id="atualizaUsuarios" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myModalLabel">Atualizar Usuários</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <form id="frmCategoriaU">
                                    <input type="text" hidden="" id="idusuarioU" name="idusuarioU">
                                    <label>Nome</label>
                                    <input type="text" id="nomeU" name="nomeU" class="form-control input-sm">
                                    <label>E-mail</label>
                                    <input type="text" id="emailU" name="emailU" class="form-control input-sm">
                                    <label>Senha</label>
                                    <input type="password" id="senhaU" name="senhaU" class="form-control input-sm">
                                    <label>Confirmar Senha</label>
                                    <input type="password" id="senha_confirmaU" name="senha_confirmaU" class="form-control input-sm">
                                    <label>Função</label>
                                    <?php 
                                        $c = new conectar();
                                        $conexao = $c->conexao();

                                        $sql = "SELECT * FROM tbpermissao;";
                                        $sql = $conexao->query($sql);
                                    ?>
                                    <select name="permissaoU" id="permissaoU" class="form-control">
                                        <?php while ($row = $sql->fetch_assoc()) { ?>
                                             <option value="<?php echo $row['idpermissao'] ?>"><?php echo $row['permissao'] ?></option>
                                        <?php } ?>
                                    </select>
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
                                <span id="btnAtualizaUsuarios" name="btnAtualizaUsuarios" class="btn btn-success" ><i class="loading-icon fa fa-spinner fa-spin oculto"></i> Atualizar Informações</span>
                            </div>
                        </div>
                    </div>
                </div>               
                

			</section>
		</div>


    </section>
    
    
    <script type="text/javascript">

    $('#btnAtualizaUsuarios').click(function(){

        var idusuario = document.getElementById("idusuarioU").value;
        var nome = document.getElementById("nomeU").value;
        var email = document.getElementById("emailU").value;
        var senha = document.getElementById("senhaU").value;
        var senha_confirma = document.getElementById("senha_confirmaU").value;
        var telefone = document.getElementById("telefoneU").value;
        var dtnascimento = document.getElementById("dtnascimentoU").value;
        var habilitado = document.getElementById("habilitadoU").value;
        var idpermissao = document.getElementById("permissaoU").value;
        //dados=$('#frmCategoriaU').serialize();                

        $.ajax({
            type:"POST",
            data:{
                idusuario: idusuario,
                nome: nome,
                email: email,
                senha: senha,
                senha_confirma: senha_confirma,
                telefone: telefone,
                dtnascimento: dtnascimento,
                habilitado: habilitado,
                idpermissao: idpermissao,
                paramTela: 'AtualizarUsuarios',
            },
            url:"classes/conect.php",
            success:function(r){
                //alert(r);
                if(r==1){
                    alertify.success("Usuário Atualizado com Sucesso :)");
                    $('#atualizaUsuarios').modal('hide');
                }else if(r==0){
                    alertify.error("E-mail já cadastrado, tente novamente!");
                    document.getElementById("emailU").classList.add("has-danger");
                }else if(r==2){
                    alertify.error("As senhas não são iguais, Tente novamente!");
                }else{
                    alertify.error("Não foi possível atualizar as informações do Usuário!");
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
    $(document).on("click", "#btnAtualizaUsuarios", function () { //Função Modal Editar 
        var idusuario = $(this).attr('data-idusuario'); //Pegando os dados que são passados no botão
        var nome = $(this).attr('data-nome');  //Pegando os dados que são passados no botão
        var email = $(this).attr('data-email');  //Pegando os dados que são passados no botão
        var senha = $(this).attr('data-senha');  //Pegando os dados que são passados no botão
        var senha_confirma = $(this).attr('data-senha_confirma');  //Pegando os dados que são passados no botão
        var telefone = $(this).attr('data-telefone');  //Pegando os dados que são passados no botão
        var dtnascimento = $(this).attr('data-dt_nascimento');
        var habilitado = $(this).attr('data-habilitado');
        var permissao = $(this).attr('data-permissao');
        var idpermissao = $(this).attr('data-idpermissao');
        $(".modal-body #idusuarioU").val(idusuario); // Jogando os valores nos seus respectivos campos dentro do corpo do Modal
        $(".modal-body #nomeU").val(nome); // Jogando os valores nos seus respectivos campos dentro do corpo do Modal
        $(".modal-body #emailU").val(email); // Jogando os valores nos seus respectivos campos dentro do corpo do Modal
        $(".modal-body #senhaU").val(senha); // Jogando os valores nos seus respectivos campos dentro do corpo do Modal
        $(".modal-body #senha_confirmaU").val(senha_confirma); // Jogando os valores nos seus respectivos campos dentro do corpo do Modal
        $(".modal-body #permissaoU").val(permissao); // Jogando os valores nos seus respectivos campos dentro do corpo do Modal
        $(".modal-body #telefoneU").val(telefone); 
        $(".modal-body #dtnascimentoU").val(dtnascimento); 
        $(".modal-body #habilitadoU").val(habilitado); 
        $(".modal-body #permissaoU").val(idpermissao);
        $('#atualizaClientes').on('shown.bs.modal', function () {
            $('#nomeU').focus(); //pegando foco do campo MAC ao abrir
        });
    });
</script>

<script type="text/javascript">

$(document).on("click", "#btnExcluirUsuario", function () { //Função Modal Editar MAC
    var idusuario = $(this).attr('data-idusuario');
    alertify.confirm('Deseja excluir este Cliente?', function(){ 
        $.ajax({
            type:"POST",
            data:{'idusuario': idusuario,
                paramTela: 'ExcluirUsuario'
            },
            url:"classes/conect.php",
            success:function(r){
                if(r==1){
                    alertify.success("Usuário excluido com sucesso!!");
                    gerarDadosUP();
                }else{
                    alertify.error("Não foi possivel Excluir esse Usuário!");
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
    //$('#loading_table2').show();  
    $.ajax({
        type: 'POST',
        url: 'classes/conect.php',
        data: {
            paramTela: 'consultarUsuario'    
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
            tabela = $('#consultaUsuario').DataTable({  
                    "aaSorting": [[1, "asc"]],  //ordenação da 2° coluna do datatable para descendente 
                    "bInfo" :false,         
                    "scrollX": false, // cria o scroll no dataTable   
                    // paging: false,     
                    searching: true,   
                    ordering: true,                                                          
    				data: dados, 
                    columns: [ //head da table direto no javascript
                        {title: 'Nome' },    
                        {title: 'E-mail' },                        
                        {title: 'Função' },    
                        {title: 'Telefone' }, 
                        {title: 'Data de Nascimento' },                 
                        {title: 'Habilitado' } ,    
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