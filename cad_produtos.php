<?php
include 'menu_layout.php';
require_once "Connections/conexao.php";
require_once "classes/class.vision.php";
$obj = new vision();
$categoria = $obj->pegarCategoria();
//print_r($result);
$id = $obj->ultimoProduto();

$ultimoIdProduto = $id['id'] + 1;
?>

<link href="css/dropzone.css" type="text/css" rel="stylesheet" />
<script src="js/dropzone.js"></script>

<style>
    .oculto {
        display: none;
    }

    .field.--has-error {
        border-color: #f00;
    }


    #progressBarUpload {
        position: relative;
        display: none;
        width: 0;
        height: 30px;
        background-color: #33ccff;
        text-align: center;
        line-height: 30px;
        color: white;
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
                <li><span>Produtos</span></li>
            </ol>


        </div>
    </header>

    <!-- start: page -->
    <div class="row">
        <div class="col-xl-12 order-1 mb-4">
            <section class="card card-primary">
                <header class="card-header">
                    <h2 class="card-title">Cadastro de Produtos</h2>
                </header>
                <div class="card-body">

                    <form class="form-horizontal form-bordered" enctype="multipart/form-data" id="registroProdutos" name="registroProdutos">
                        <input type="hidden" name="paramTela" value="adicionarProdutos">
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
                            <label class="col-lg-3 control-label text-lg-right pt-2">Categoria</label>
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </span>
                                    <select name="categoria" id="categoria" class="form-control">
                                        <option value="ND">Selecione a Categoria</option>
                                        <?php foreach ($categoria as $key => $categorias) {
                                            echo $categorias;
                                        } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 control-label text-lg-right pt-2">Produto (Nome) </label>
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-box"></i>
                                        </span>
                                    </span>
                                    <input type="text" autocomplete="off" name="descricao" id="descricao" class="form-control" maxlength="50" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row" id="referencia-error">
                            <label class="col-lg-3 control-label text-lg-right pt-2">Referência</label>
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-barcode"></i>
                                        </span>
                                    </span>
                                    <input autocomplete="off" inputmode="numeric" name="referencia" id="referencia" class="form-control" maxlength="10" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 control-label text-lg-right pt-2">Preço</label>
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span>
                                    </span>
                                    <input type="text" onkeyup="valorreais(this);" inputmode="numeric" name="preco" id="preco" value="0" min="0" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 control-label text-lg-right pt-2">Estoque</label>
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-exchange-alt"></i>
                                        </span>
                                    </span>
                                    <input type="number" inputmode="numeric" name="estoque" id="estoque" min="0" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 control-label text-lg-right pt-2">Upload Fotos</label>
                            <div class="col-lg-6">
                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                    <div class="input-append">
                                        <div class="uneditable-input">
                                            <i class="fas fa-file fileupload-exists"></i>
                                            <span class="fileupload-preview"></span>
                                        </div>
                                        <span class="btn btn-primary text-light btn-file">
                                            <span class="fileupload-exists">Trocar</span>
                                            <span class="fileupload-new">Selecionar Arquivo</span>
                                            <input type="file" class="fileToUpload" accept="image/*" onchange="preview_image(event)" name="fileUpload" />
                                        </span>
                                        <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload">Remover</a>
                                        <!-- <button type="button" class="btn btn-primary text-light fileupload-exists" id="enviar" onclick="uploadFile();"><i class="glyphicon glyphicon-floppy-open"></i> Enviar</button> -->
                                    </div>
                                </div>

                                <img class="float-center oculto" id="output_image" height=255 width=255\>

                            </div>

                        </div>

                        <!-- <div class="form-group row">
                            <label class="col-lg-3 control-label text-lg-right pt-2">Nome Arquivo</label>
                            <div class="col-lg-6">
                                <input class="form-control col-md-2" type="text" name="filename" id="filename">

                            </div>
                        </div> -->


                        <div class="form-group row oculto">
                            <div class="col-lg-6">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" id="progressBarUpload">
                                    <span></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 control-label text-lg-right pt-2">Habilitado</label>
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-ban"></i>
                                        </span>
                                    </span>
                                    <select name="habilitado" id="habilitado" class="form-control">
                                        <option value="S">Sim</option>
                                        <option value="N">Não</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-8 text-center">
                                <button name="registrarProdutos" id="registrarProdutos" type="submit" class="btn btn-primary text-light mt-2"><i class="loading-icon fa fa-spinner fa-spin oculto"></i> Inserir Produto</button>
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



<script type="text/javascript">
    $(document).ready(function() {
        $('input[type="text"]').each(function() {
            var val = $(this).val().replace(',', '.');
            $(this).val(val);
        });

        $('.fileupload-exists').click(function() {
            var output = document.getElementById('output_image');
            output.classList.add('oculto');
        });



        $("form#registroProdutos").submit(function(e) {
            e.preventDefault();

            var data = new FormData(this);

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
                        document.getElementById("referencia-error").classList.remove("has-danger");
                        // $(".loading-icon").addClass("oculto");
                        // $("#btnRegistrar").attr("disabled", false);  
                        document.getElementById("alert_ok").classList.remove("oculto"); //Remove o oculto da classe pra ser exibido!
                        document.getElementById("alert_ok").innerHTML = ('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Sucesso! Novo Produto inserido com sucesso!</strong>'); //Msg de Campos em Branco
                        $('#registroProdutos')[0].reset();
                        var output = document.getElementById('output_image');
                        output.classList.add('oculto');
                    } else if (r == 0) {
                        document.getElementById("alert_ok").classList.add("oculto"); //Caso o alert esteja na tela ele adiciona classe Oculto novamente pra esconde-lo!
                        // $(".loading-icon").addClass("oculto");
                        // $("#btnRegistrar").attr("disabled", false);  
                        document.getElementById("alert_error").classList.remove("oculto"); //Remove o oculto da classe pra ser exibido!
                        document.getElementById("referencia-error").classList.add("has-danger");
                        document.getElementById("alert_error").innerHTML = ('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong> Referência já cadastrada, tente novamente!</strong>'); //Msg de Campos em Branco
                        document.getElementById('referencia').value = "";
                        $("#email").text("").focus();
                        return false;
                    } else if (r == 2) {
                        document.getElementById("alert_ok").classList.add("oculto"); //Caso o alert esteja na tela ele adiciona classe Oculto novamente pra esconde-lo!
                        document.getElementById("referencia-error").classList.remove("has-danger");
                        // $(".loading-icon").addClass("oculto");
                        // $("#btnRegistrar").attr("disabled", false);  
                        document.getElementById("alert_error").classList.remove("oculto"); //Remove o oculto da classe pra ser exibido!
                        document.getElementById("alert_error").innerHTML = ('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Categoria em Branco, seleciona uma categoria!</strong>'); //Msg de Campos em Branco
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





    });

    function preview_image(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('output_image');
            output.src = reader.result;
            output.classList.remove('oculto');
        }
        reader.readAsDataURL(event.target.files[0]);
    }

    // uploadFirmware();

    function uploadFile() {
        // var filename = $('#filename');
        var ultimoId = '<?php echo $ultimoIdProduto ?>';
        var file_data = $('.fileToUpload').prop('files')[0];
        var form_data = new FormData();
        form_data.append("file", file_data);
        // form_data.append("filename", filename);
        form_data.append("idProduto", ultimoId);

        // console.log(form_data);
        $.ajax({
            url: "upload.php",
            type: "POST",
            dataType: 'script',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(data) {

                if (data == '1') {
                    alertify.success('Arquivo Enviado com Sucesso!').delay(5).dismissOthers();
                }

            }
        })
    }

    function uploadFirmware(params) {

        var formFiles, divReturn, progressBar;

        formFiles = document.getElementById('registroProdutos');
        divReturn = document.getElementById('return');
        progressBar = document.getElementById('progressBarUpload');
        btnLoading = document.getElementById('enviar');

        formFiles.addEventListener('submit', sendForm, false);

        function sendForm(evt) {
            evt.preventDefault();

            var formData, ajax, pct;

            formData = new FormData(evt.target);

            ajax = new XMLHttpRequest();

            ajax.onreadystatechange = function() {

                if (ajax.readyState == 4) {
                    formFiles.reset();
                    // divReturn.textContent = ajax.response;
                    progressBar.style.display = 'none';
                    btnLoading.innerHTML = '<i class="glyphicon glyphicon-floppy-open"></i> Enviar';
                    alertify.set('notifier', 'position', 'top-center');
                    if (ajax.response == 'Este Arquivo já existe no Servidor, Tente novamente') {
                        alertify.error(ajax.response).delay(5).dismissOthers();
                    } else if (ajax.response == 'Arquivo enviado com sucesso!') {
                        alertify.success(ajax.response).delay(5).dismissOthers();
                    }
                    // listarArquivos();
                } else if (ajax.response == 'Este Arquivo já existe no Servidor, Tente novamente') {
                    // listarArquivos();
                } else {
                    progressBar.style.display = 'block';
                    // divReturn.style.display = 'block';
                    btnLoading.innerHTML = '<i class="fa fa-refresh fa-spin"></i> Enviando...';
                    // divReturn.textContent = 'Enviando arquivo!';
                }
            }

            ajax.upload.addEventListener('progress', function(evt) {

                pct = Math.floor((evt.loaded * 100) / evt.total);
                progressBar.style.width = pct + '%';
                progressBar.getElementsByTagName('span')[0].textContent = pct + '%';

            }, false);

            ajax.open('POST', 'classes/conect.php');
            ajax.send(formData);

        }

    }
</script>

<script type="text/javascript">
    function valorreais(i) {
        var v = i.value.replace(/\D/g, '');
        v = (v / 100).toFixed(2) + '';
        v = v.replace(".", ",");
        v = v.replace(/(\d)(\d{3})(\d{3}),/g, "$1.$2.$3,");
        v = v.replace(/(\d)(\d{3}),/g, "$1.$2,");
        i.value = v;
    }
</script>

<script type="text/javascript">
    // jQuery.noConflict();
    // jQuery(function($) {
    //     $("#referencia").mask("99.99999");
    // });
</script>

<script>
    function salvar() {

        var categoria = document.getElementById("categoria").value;
        var nome = document.getElementById("descricao").value;
        var referencia = document.getElementById("referencia").value;
        var preco = document.getElementById("preco").value;
        var habilitado = document.getElementById("habilitado").value;
        var estoque = document.getElementById("estoque").value;

        vazios = validarFormVazio('#registroProdutos');


        if (vazios > 0) {
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
            data: {
                idProduto: "<?php echo $ultimoIdProduto ?>",
                categoria: categoria,
                nome: nome,
                referencia: referencia,
                preco: preco,
                habilitado: habilitado,
                estoque: estoque,
                paramTela: 'adicionarProdutos',
            },
            success: function(r) {
                //alert(r);

                if (r == 1) {
                    document.getElementById("alert_error").classList.add("oculto"); //Caso o alert esteja na tela ele adiciona classe Oculto novamente pra esconde-lo!
                    document.getElementById("referencia-error").classList.remove("has-danger");
                    // $(".loading-icon").addClass("oculto");
                    // $("#btnRegistrar").attr("disabled", false);  
                    document.getElementById("alert_ok").classList.remove("oculto"); //Remove o oculto da classe pra ser exibido!
                    document.getElementById("alert_ok").innerHTML = ('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Sucesso! Novo Produto inserido com sucesso!</strong>'); //Msg de Campos em Branco
                    $('#registroProdutos')[0].reset();
                } else if (r == 0) {
                    document.getElementById("alert_ok").classList.add("oculto"); //Caso o alert esteja na tela ele adiciona classe Oculto novamente pra esconde-lo!
                    // $(".loading-icon").addClass("oculto");
                    // $("#btnRegistrar").attr("disabled", false);  
                    document.getElementById("alert_error").classList.remove("oculto"); //Remove o oculto da classe pra ser exibido!
                    document.getElementById("referencia-error").classList.add("has-danger");
                    document.getElementById("alert_error").innerHTML = ('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong> Referência já cadastrada, tente novamente!</strong>'); //Msg de Campos em Branco
                    document.getElementById('referencia').value = "";
                    $("#email").text("").focus();
                    return false;
                } else if (r == 2) {
                    document.getElementById("alert_ok").classList.add("oculto"); //Caso o alert esteja na tela ele adiciona classe Oculto novamente pra esconde-lo!
                    document.getElementById("referencia-error").classList.remove("has-danger");
                    // $(".loading-icon").addClass("oculto");
                    // $("#btnRegistrar").attr("disabled", false);  
                    document.getElementById("alert_error").classList.remove("oculto"); //Remove o oculto da classe pra ser exibido!
                    document.getElementById("alert_error").innerHTML = ('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Categoria em Branco, seleciona uma categoria!</strong>'); //Msg de Campos em Branco
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
        //}, 3000); // O valor é representado em milisegundos.

    };
</script>


<?php include 'footer_layout.php';  ?>