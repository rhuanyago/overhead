<?php
require_once "Connections/conexao.php";

?>

<!doctype html>
<html class="fixed" data-style-switcher-options="{'layoutStyle': 'boxed'}">

<head>

    <!-- Basic -->
    <meta charset="UTF-8">
    <title>Sill3nTz Games - Login</title>
    <meta name="keywords" content="HTML5 Admin Template" />
    <meta name="description" content="Porto Admin - Responsive HTML5 Template">
    <meta name="author" content="okler.net">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <!-- Web Fonts  -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="vendor/animate/animate.css">

    <link rel="stylesheet" href="vendor/font-awesome/css/fontawesome-all.min.css" />
    <link rel="stylesheet" href="vendor/magnific-popup/magnific-popup.css" />
    <link rel="stylesheet" href="vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="css/theme.css" />

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="css/custom.css">

    <!-- Head Libs -->
    <script src="vendor/modernizr/modernizr.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="http://code.jquery.com/jquery-1.11.1.js"></script>
    <script src="funcoes.js"></script>

    <style>
        body {
            /* background-image: url('img/back_over.jpg'); */
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
        }

        .oculto {
            display: none;
        }
    </style>


</head>

<body>
    <!-- start: page -->
    <section class="body-sign">
        <div class="center-sign">
            <a class="logo float-left d-none d-sm-table-cell text-center">
                <img src="img/logo_over.png" height="75" width="330" alt="Vision Lounge" />
            </a>

            <div class="panel card-sign">
                <div class="card-title-sign mt-3 text-right">
                    <h2 class="title text-uppercase font-weight-bold m-0"><i class="fas fa-user mr-1"></i>Acessar
                        Sistema</h2>
                </div>
                <div class="card-body">

                    <div id="alert_error" class="alert alert-danger oculto">

                    </div>

                    <form id="Frmlogin">
                        <div class="form-group mb-3">
                            <label>E-mail</label>
                            <div class="input-group">
                                <input name="email" id="email" type="text" class="form-control form-control-lg" />
                                <span class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </span>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <div class="clearfix">
                                <label class="float-left">Senha</label>
                                <a href="esqueci_minha_senha.asp" class="float-right">Esqueceu a Senha?</a>
                            </div>
                            <div class="input-group">
                                <input name="senha" id="senha" type="password" class="form-control form-control-lg" />
                                <span class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                </span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-8">
                                <div class="checkbox-custom checkbox-default">
                                    <input id="RememberMe" name="rememberme" type="checkbox" />
                                    <label for="RememberMe">Lembrar Me?</label>
                                </div>

                            </div>

                            <div class="col-sm-12 text-right">
                                <!--
                                    <a href="cadastrar.php" class="mb-1 mt-1 mr-1 btn btn-dark">Cadastrar-se</a>
                                -->
                                <span name="btnLogar" id="btnLogar" class="mb-1 mt-1 mr-1 btn btn-primary text-light" onclick="Entrar()"><i class="fas fa-unlock-alt"></i> Acessar</span>
                            </div>

                        </div>
                        <hr>
                        <p class="text-center"><i class="fas fa-laptop"></i> Desenvolvido por: Rhuan Yago </p>
                        <p class="text-center text-muted mt-3 mb-3 text-primary">&copy; Overhead | Copyright 2021. All
                            Rights Reserved.</p>
                    </form>
                </div>
            </div>


        </div>
    </section>
    <!-- end: page -->

    <!-- Vendor -->
    <script src="vendor/jquery/jquery.js"></script>
    <script src="vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
    <script src="vendor/jquery-cookie/jquery-cookie.js"></script>
    <script src="vendor/popper/umd/popper.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.js"></script>
    <script src="vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="vendor/common/common.js"></script>
    <script src="vendor/nanoscroller/nanoscroller.js"></script>
    <script src="vendor/magnific-popup/jquery.magnific-popup.js"></script>
    <script src="vendor/jquery-placeholder/jquery-placeholder.js"></script>

    <!-- Theme Base, Components and Settings -->
    <script src="js/theme.js"></script>

    <!-- Theme Custom -->
    <script src="js/custom.js"></script>

    <!-- Theme Initialization Files -->
    <script src="js/theme.init.js"></script>

</body>

</html>


<script>
    function Entrar() {

        var email = document.getElementById("email").value;
        var senha = document.getElementById("senha").value;

        vazios = validarFormVazio('#Frmlogin');

        if (vazios > 0) {
            document.getElementById("alert_error").classList.remove("oculto"); //Remove o oculto da classe pra ser exibido!
            document.getElementById("alert_error").innerHTML = (
                '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Atenção! Campos em Branco!</strong>'
            ); //Msg de Campos em Branco
            return false;
        }

        //dados=$('#registroUsuario').serialize();
        $.ajax({
            url: "classes/conect.php",
            method: "POST",
            data: {
                email: email,
                senha: senha,
                paramTela: 'Login',
            },
            success: function(r) {
                //alert(r);

                if (r == 1) {
                    document.getElementById("alert_error").classList.add("oculto");
                    window.location = "home.php";
                } else if (r == 0) {
                    document.getElementById("alert_error").classList.remove(
                        "oculto"); //Remove o oculto da classe pra ser exibido!
                    document.getElementById("alert_error").innerHTML = (
                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong> E-mail ou Senha incorretos, tente novamente!</strong>'
                    ); //Msg de Campos em Branco
                    document.getElementById('email').value = "";
                    document.getElementById('senha').value = "";
                    $("#email").text("").focus();
                    return false;
                } else if (r == 2) {
                    document.getElementById("alert_error").classList.remove(
                        "oculto"); //Remove o oculto da classe pra ser exibido!
                    document.getElementById("alert_error").innerHTML = (
                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Atenção! E-mail de acesso bloqueado!</strong>'
                    ); //Msg de Campos em Branco
                    return false;
                }
            }
        });
    };
</script>