<?php
include 'menu_layout.php';
require_once "Connections/conexao.php";

?>


<style>
    .oculto {
        display: none;
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
                    <h2 class="card-title">Cadastro de Clientes <i class="fas fa-user-plus"></i></h2>
                </header>


                <div class="card-body">

                    <form class="form-horizontal form-bordered" method="POST" action="classes/conect.php" id="Cadastro" name="Cadastro">
                        <input name="paramTela" type="hidden" value="registrarCliente" required />
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
                            <label class="col-lg-3 control-label text-lg-right pt-2">Tipo</label>
                            <div class="col-lg-3">
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </span>
                                    <select class="form-control" name="tipocad">
                                        <option value="C">Cliente</option>
                                        <option value="F">Fornecedor</option>
                                        <option value="A">Ambos</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 control-label text-sm-right pt-0"></label>
                            <div class="col-sm-2">
                                <div class="radio-custom radio-primary">
                                    <input id="F" name="tipo" id="tipo" type="radio" value="F" required />
                                    <label for="F">Pessoa Física</label>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="radio-custom radio-primary">
                                    <input id="J" name="tipo" id="tipo" type="radio" value="J" required />
                                    <label for="J">Pessoa Jurídica</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 control-label text-lg-right pt-2">ISS</label>
                            <div class="col-lg-3">
                                <div class="input-group">
                                    <select name="iss" class="form-control">
                                        <option value="N">Não Retem</option>
                                        <option value="RO">Retido pelo Órgão Público</option>
                                        <option value="RT">Retido pelo Tomador</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row ">
                            <label class="col-lg-3 control-label text-lg-right pt-2">Nome</label>
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </span>
                                    <input type="text" name="nome" id="nome" autofocus maxlength="50" autocomplete="off" class="form-control">

                                </div>
                                <div id="countryList"></div>
                            </div>
                        </div>

                        <!-- <div class="form-group row campoPessoaJuridica">
                            <label class="col-lg-3 control-label text-lg-right pt-2">Nome Empresa</label>
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </span>
                                    <input type="text" name="nomeJuridico" id="nomeJuridico" autocomplete="off" class="form-control">

                                </div>
                                <div id="countryListJ"></div>
                            </div>
                        </div> -->

                        <div class="form-group row campoPessoaJuridica">
                            <label class="col-lg-3 control-label text-lg-right pt-2">Nome Fantasia</label>
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-user-circle"></i>
                                        </span>
                                    </span>
                                    <input type="text" name="nomeFantasia" id="nomeFantasia" autocomplete="off" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row campoPessoaJuridica">
                            <label class="col-lg-3 control-label text-lg-right pt-2">Apelido</label>
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-user-circle"></i>
                                        </span>
                                    </span>
                                    <input type="text" name="apelido" id="apelido" autocomplete="off" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row campoPessoaJuridica">
                            <label class="col-lg-3 control-label text-lg-right pt-2">CNPJ</label>
                            <div class="col-lg-6">
                                <input type="text" name="cnpj" id="cnpj" inputmode="numeric" data-plugin-masked-input data-input-mask="99.999.999/9999-99" autocomplete="off" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row campoPessoaFisica">
                            <label class="col-lg-3 control-label text-lg-right pt-2">CPF</label>
                            <div class="col-lg-6">
                                <input type="text" name="cpf" id="cpf" inputmode="numeric" data-plugin-masked-input data-input-mask="999.999.999-99" autocomplete="off" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row campoPessoaFisica">
                            <label class="col-lg-3 control-label text-lg-right pt-2">RG</label>
                            <div class="col-lg-6">
                                <input type="text" name="rg" inputmode="numeric" maxlength="20" autocomplete="off" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row campoPessoaFisica">
                            <label class="col-lg-3 control-label text-lg-right pt-2">Data de Nascimento</label>
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar-alt"></i>
                                        </span>
                                    </span>
                                    <input id="date" name="dtnascimento" id="dtnascimento" inputmode="numeric" data-plugin-masked-input data-input-mask="99/99/9999" placeholder="__/__/____" class="form-control" autocomplete="off">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row ">
                            <label class="col-lg-3 control-label text-lg-right pt-2">Telefone</label>
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-phone"></i>
                                        </span>
                                    </span>
                                    <input name="telefone" inputmode="numeric" autocomplete="off" data-plugin-masked-input data-input-mask="(99) 99999-9999" placeholder="(DD) 99699-1234" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row campoPessoaJuridica">
                            <label class="col-lg-3 control-label text-lg-right pt-2">Telefone 2</label>
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-phone"></i>
                                        </span>
                                    </span>
                                    <input name="telefone2J" id="telefone2J" inputmode="numeric" autocomplete="off" placeholder="(DD) 9969-1234" data-plugin-masked-input data-input-mask="(99) 9999-9999" class="form-control">
                                </div>
                            </div>
                        </div>


                        <header class="card-header mb-4">
                            <h2 class="card-title text-center col-lg-4">Endereço <i class="fas fa-address-card"></i></h2>
                        </header>

                        <div class="form-group row">
                            <label class="col-lg-3 control-label text-lg-right pt-2 ">CEP</label>
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <input type="text" name="cep" id="cep" autocomplete="off" class="form-control" data-plugin-masked-input data-input-mask="99999-999" required="required">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 control-label text-lg-right pt-2 ">Endereço</label>
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-truck"></i>
                                        </span>
                                    </span>
                                    <input type="text" name="endereco" id="endereco" autocomplete="off" class="form-control" required="required" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 control-label text-lg-right pt-2 ">Bairro</label>
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <input type="text" name="bairro" id="bairro" autocomplete="off" class="form-control" required="required" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 control-label text-lg-right pt-2 ">Estado</label>
                            <div class="col-lg-1">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="uf" id="uf" required="required" readonly></select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 control-label text-lg-right pt-2 ">Cidade</label>
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <input type="text" name="cidade" id="cidade" autocomplete="off" class="form-control" required="required" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 control-label text-lg-right pt-2 ">Complemento</label>
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <input type="text" name="complemento" id="complemento" autocomplete="off" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 control-label text-lg-right pt-2 ">Número</label>
                            <div class="col-lg-2">
                                <div class="input-group">
                                    <input type="text" name="numero" id="numero" autocomplete="off" class="form-control">
                                </div>
                            </div>
                        </div>



                        <div class="row">
                            <div class="col-sm-8 text-center">
                                <button type="submit" id="cadastrar" name="btnCadastrar" class="btn btn-success mt-2">Cadastrar</button>
                                <a href="home.php" class="btn btn-dark mt-2">Voltar</a>
                            </div>
                        </div>



                    </form>

                    <!-- <form class="form-horizontal form-bordered" id="registrarCliente" name="registrarCliente">



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
                                <input type="text" name="rg" id="rg" inputmode="numeric" autocomplete="off" data-plugin-masked-input data-input-mask="99.999.999-9" class="form-control" required>
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

                    </form> -->

                </div>
            </section>
        </div>
    </div>
    <!-- end: page -->
</section>
</div>


</section>


<script>
    $("form#Cadastro").submit(function(e) {
        e.preventDefault();

        var data = new FormData(this);

        console.log(data);

        $.ajax({
            url: "classes/conect.php",
            type: "POST",
            data: data,
            mimeType: "multipart/form-data",
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            success: function(r) {
                //alert(r);

                if (r == 1) {
                    document.getElementById("alert_error").classList.add("oculto"); //Caso o alert esteja na tela ele adiciona classe Oculto novamente pra esconde-lo!
                    // document.getElementById("referencia-error").classList.remove("has-danger");
                    // $(".loading-icon").addClass("oculto");
                    // $("#btnRegistrar").attr("disabled", false);  
                    document.getElementById("alert_ok").classList.remove("oculto"); //Remove o oculto da classe pra ser exibido!
                    document.getElementById("alert_ok").innerHTML = ('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Sucesso! Novo Cliente inserido com sucesso!</strong>'); //Msg de Campos em Branco
                    $('#Cadastro')[0].reset();
                } else if (r == 0) {
                    document.getElementById("alert_ok").classList.add("oculto"); //Caso o alert esteja na tela ele adiciona classe Oculto novamente pra esconde-lo!
                    // $(".loading-icon").addClass("oculto");
                    // $("#btnRegistrar").attr("disabled", false);  
                    document.getElementById("alert_error").classList.remove("oculto"); //Remove o oculto da classe pra ser exibido!
                    // document.getElementById("referencia-error").classList.add("has-danger");
                    document.getElementById("alert_error").innerHTML = ('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong> Cliente já cadastrado, tente novamente!</strong>'); //Msg de Campos em Branco
                    // $("#email").text("").focus();
                    return false;
                }
            },
            beforeSend: function() {
                $('.loading-icon').removeClass("oculto");
            },
            complete: function() {
                $('.loading-icon').addClass("oculto");
            }
        });
    });


    function salvar() {

        var nome = document.getElementById("nome").value;
        var rg = document.getElementById("rg").value;
        var dtnascimento = document.getElementById("dtnascimento").value;
        var telefone = document.getElementById("telefone").value;

        vazios = validarFormVazio('#registrarCliente');

        if (vazios > 0) {
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
            data: {
                nome: nome,
                rg: rg,
                dtnascimento: dtnascimento,
                telefone: telefone,
                paramTela: 'registrarCliente',
            },
            success: function(r) {
                //alert(r);
                if (r == 1) {
                    document.getElementById("alert_error").classList.add("oculto"); //Caso o alert esteja na tela ele adiciona classe Oculto novamente pra esconde-lo!
                    // $(".loading-icon").addClass("oculto");
                    // $("#btnRegistrar").attr("disabled", false);  
                    document.getElementById("rg-error").classList.remove("has-danger");
                    document.getElementById("alert_ok").classList.remove("oculto"); //Remove o oculto da classe pra ser exibido!
                    document.getElementById("alert_ok").innerHTML = ('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Sucesso! Novo Usuario inserido com sucesso!</strong>'); //Msg de Campos em Branco
                    $('#registrarCliente')[0].reset();
                    // $('#loading_table').hide();  
                } else if (r == 0) {
                    // $(".loading-icon").addClass("oculto");
                    // $("#btnRegistrar").attr("disabled", false); 
                    document.getElementById("alert_ok").classList.add("oculto"); //Caso o alert esteja na tela ele adiciona classe Oculto novamente pra esconde-lo!
                    document.getElementById("alert_error").classList.remove("oculto"); //Remove o oculto da classe pra ser exibido!
                    document.getElementById("rg-error").classList.add("has-danger");
                    document.getElementById("alert_error").innerHTML = ('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong> RG ja cadastrado, tente novamente!</strong>'); //Msg de Campos em Branco
                    document.getElementById('rg').value = "";
                    $("#rg").text("").focus();
                    return false;
                } else if (r == 2) {
                    // $(".loading-icon").addClass("oculto");
                    // $("#btnRegistrar").attr("disabled", false); 
                    document.getElementById("alert_ok").classList.add("oculto"); //Caso o alert esteja na tela ele adiciona classe Oculto novamente pra esconde-lo!
                    document.getElementById("alert_error").classList.remove("oculto"); //Remove o oculto da classe pra ser exibido!
                    document.getElementById("alert_error").innerHTML = ('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Atenção! As senhas nao sao iguais, tente novamente!</strong>'); //Msg de Campos em Branco
                    return false;
                }
            },
            beforeSend: function() {
                $('.loading-icon').removeClass("oculto");
            },
            complete: function() {
                $('.loading-icon').addClass("oculto");
            }
        });
        //    }, 3000); // O valor é representado em milisegundos.
    };

    $(document).ready(function() {
        $(".campoPessoaJuridica, .campoPessoaFisica").hide();

        function limpa_formulário_cep() {
            // Limpa valores do formulário de cep.
            $("#endereco").val("");
            $("#bairro").val("");
            $("#cidade").val("");
            $("#uf").val("");
            $("#ibge").val("");
        }

        $("#cep").blur(function() {

            //Nova variável "cep" somente com dígitos.
            var cep = $(this).val().replace(/\D/g, '');

            //Verifica se campo cep possui valor informado.
            if (cep != "") {

                //Expressão regular para validar o CEP.
                var validacep = /^[0-9]{8}$/;

                //Valida o formato do CEP.
                if (validacep.test(cep)) {

                    //Preenche os campos com "..." enquanto consulta webservice.
                    $("#endereco").val("...");
                    $("#bairro").val("...");
                    $("#cidade").val("...");
                    $("#uf").val("...");
                    $("#ibge").val("...");

                    //Consulta o webservice viacep.com.br/
                    $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function(dados) {

                        if (!("erro" in dados)) {
                            //Atualiza os campos com os valores da consulta.
                            $("#endereco").val(dados.logradouro);
                            $("#bairro").val(dados.bairro);
                            $("#cidade").val(dados.localidade);
                            $("#uf").val(dados.uf);
                            $("#ibge").val(dados.ibge);
                            $("#complemento").focus();
                        } //end if.
                        else {
                            //CEP pesquisado não foi encontrado.
                            limpa_formulário_cep();
                            alert("CEP não encontrado.");
                        }
                    });
                } //end if.
                else {
                    //cep é inválido.
                    limpa_formulário_cep();
                    alert("Formato de CEP inválido.");
                }
            } //end if.
            else {
                //cep sem valor, limpa formulário.
                limpa_formulário_cep();
            }
        });


    });

    $("input:radio[name=tipo]").on("change", function() {
        if ($(this).val() == "F") {
            $(".campoPessoaFisica").show();
            $('.campoPessoaFisica').attr('required');
            $(".campoPessoaJuridica").hide();
        } else if ($(this).val() == "J") {
            $(".campoPessoaFisica").hide();
            $('.campoPessoaJuridica').attr('required');
            $(".campoPessoaJuridica").show();
        }


    });
</script>



<?php include 'footer_layout.php';  ?>