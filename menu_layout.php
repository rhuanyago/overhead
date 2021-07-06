<?php
require_once "Connections/conexao.php";
$c = new conectar();
$conexao = $c->conexao();

if ((time() - $_SESSION['last_time']) > 3000) {
    header("location:sair.php");
}

if ($_SESSION['chave_acesso'] == md5('@wew67434$%#@@947@@#$@@!#54798#11a23@@dsa@!')) {

    $idPerfil = $_SESSION['idpermissao'];
    $nomeGrupo = [];
    $sql = "SELECT * FROM tbpermissao_pages where idpermissao = '$idPerfil';";
    $sql = $conexao->query($sql);
    while ($r = $sql->fetch_assoc()) {
        $nomeGrupo[] = $r['permissao_pages'];
        $idGrupo = $r['idpermissao'];
    }
    $nomeGrupo[count($nomeGrupo) + 1] = 'home';

    $_SESSION['nomeGrupo'] = $nomeGrupo;

    $validaGeraGrafico = explode('item', $_SERVER['REQUEST_URI']); // pega tudo da url que vem antes de /
    $ex = explode('/', $validaGeraGrafico[0]);
    $ultima = $ex[count($ex) - 1];
    $variavel = true;

    foreach ($nomeGrupo as $key => $value) {
        $outronome = strpos($ultima, $value);
        if ($outronome !== false) {
            $variavel = false;
        }
    }

    if ($_SESSION['permissao'] == 'SUPER-ADMIN') {
    } else if ($variavel !== false) {
        if (strpos($ultima, 'home') !== false) {
            unset($_SESSION['validaPermissao']);
        } else {
            header('Location: home.php');
            $_SESSION['validaPermissao'] = '<div class="alert alert-danger alert-dismissible"> <a class="close" data-dismiss="alert" aria-label="close">x</a> <span style="font-size: 17px;">Você não tem permissão para acessar esta tela!</span> </div>';
            //unset($_SESSION['validaPermissao']);
        }
    }



?>
    <!doctype html>
    <html class="left-sidebar-panel" data-style-switcher-options="{'sidebarColor': 'dark'}">

    <!-- Mirrored from preview.oklerthemes.com/porto-admin/2.1.1/pages-signup.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 18 Jun 2018 18:56:35 GMT -->

    <head>

        <!-- Basic -->
        <meta charset="UTF-8">
        <title>Sistema</title>
        <meta name="keywords" content="Sistema" />
        <meta name="description" content="Porto Admin - Responsive HTML5 Template">
        <meta name="author" content="okler.net">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

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

        <!-- Specific Page Vendor CSS -->
        <link rel="stylesheet" href="vendor/jquery-ui/jquery-ui.css" />
        <link rel="stylesheet" href="vendor/jquery-ui/jquery-ui.theme.css" />
        <link rel="stylesheet" href="vendor/select2/css/select2.css" />
        <link rel="stylesheet" href="vendor/select2-bootstrap-theme/select2-bootstrap.min.css" />
        <link rel="stylesheet" href="vendor/bootstrap-multiselect/bootstrap-multiselect.css" />
        <link rel="stylesheet" href="vendor/bootstrap-tagsinput/bootstrap-tagsinput.css" />
        <link rel="stylesheet" href="vendor/bootstrap-colorpicker/css/bootstrap-colorpicker.css" />
        <link rel="stylesheet" href="vendor/bootstrap-timepicker/css/bootstrap-timepicker.css" />
        <link rel="stylesheet" href="vendor/dropzone/basic.css" />
        <link rel="stylesheet" href="vendor/dropzone/dropzone.css" />
        <link rel="stylesheet" href="vendor/bootstrap-markdown/css/bootstrap-markdown.min.css" />
        <link rel="stylesheet" href="vendor/summernote/summernote-bs4.css" />
        <link rel="stylesheet" href="vendor/codemirror/lib/codemirror.css" />
        <link rel="stylesheet" href="vendor/codemirror/theme/monokai.css" />
        <link rel="stylesheet" href="vendor/datatables/media/css/dataTables.bootstrap4.css" />
        <link rel="stylesheet" type="text/css" href="js/alertifyjs/css/alertify.css">
        <link rel="stylesheet" type="text/css" href="js/alertifyjs/css/themes/default.css">
        <link rel="stylesheet" href="vendor/bootstrap-fileupload/bootstrap-fileupload.min.css" />
        <!-- Theme CSS -->
        <link rel="stylesheet" href="css/theme.css" />

        <!-- Theme Custom CSS -->
        <link rel="stylesheet" href="css/custom.css">

        <!-- Head Libs -->


        <script src="js/alertifyjs/alertify.js"></script>
        <script src="vendor/modernizr/modernizr.js"></script>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
        <script src="funcoes.js"></script>
    </head>

    <body>

        <section class="body">


            <!-- start: header -->
            <header class="header">
                <div class="logo-container ">
                    <a href="home.php" class="logo"> <img src="img/logo_over.png" width="305" height="45" alt="Vision Lounge" /> </a>
                    <div class="d-md-none toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened"> <i class="fas fa-bars" aria-label="Toggle sidebar"></i> </div>
                </div>

                <!-- start: search & user box -->
                <div class="header-right">

                    <span class="separator"></span>

                    <div id="userbox" class="userbox">
                        <a href="home.php" data-toggle="dropdown">
                            <figure class="profile-picture">
                                <img src="img/user.jpg" class="rounded-circle" data-lock-picture="img/user.jpg" />
                            </figure>
                            <div class="profile-info">
                                <span class="name"><?php echo $_SESSION['nome'] ?></span>
                                <span class="role"><?php echo $_SESSION['permissao'] ?></span>
                            </div>

                            <i class="fa custom-caret"></i>
                        </a>

                        <div class="dropdown-menu">
                            <ul class="list-unstyled mb-2">
                                <li class="divider"></li>
                                <li>
                                    <a role="menuitem" tabindex="-1" href="pages-user-profile.html"><i class="fas fa-user"></i> Meu Perfil</a>
                                </li>
                                <li>
                                    <a role="menuitem" tabindex="-1" href="sair.php"><i class="fas fa-power-off"></i> Deslogar</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- end: search & user box -->
            </header>
            <!-- end: header -->

            <div class="inner-wrapper">

                <!-- start: sidebar -->
                <aside id="sidebar-left" class="sidebar-left">

                    <div class="nano">
                        <div class="nano-content">
                            <nav id="menu" class="nav-main" role="navigation">

                                <ul class="nav nav-main ">

                                    <li>
                                        <a class="nav-link" href="home.php">
                                            <i class="fas fa-home" aria-hidden="true"></i>
                                            <span>Dashboard</span>
                                        </a>
                                    </li>

                                    <li class="nav-parent nav-expanded ">
                                        <a href="#">
                                            <i class="fas fa-user-alt "></i>
                                            <span>Cadastros</span>
                                        </a>
                                        <ul class="nav nav-children">
                                            <li>
                                                <a href="cad_cliente.php">
                                                    <i class="fas fa-user-plus"></i>
                                                    Clientes
                                                </a>
                                            </li>

                                            <li>
                                                <a href="cad_usuarios.php">
                                                    <i class="fas fa-users"></i>
                                                    Usuários
                                                </a>
                                            </li>
                                            <li>
                                                <a href="cad_produtos.php">
                                                    <i class="fas fa-box-open"></i>
                                                    Produtos
                                                </a>
                                            </li>
                                            <li>
                                                <a href="cad_categoria.php">
                                                    <i class="fas fa-boxes"></i>
                                                    Categoria
                                                </a>
                                            </li>

                                            <!-- adicionar mais -->
                                        </ul>
                                    </li>
                                    <!-- Fim menu Cadastros -->

                                    <li class="nav-parent nav-expanded ">
                                        <a href="#">
                                            <i class="fas fa-user-alt "></i>
                                            <span>Consultas</span>
                                        </a>
                                        <ul class="nav nav-children">
                                            <li>
                                                <a href="consulta_cliente.php">
                                                    <i class="fas fa-user-edit"></i>
                                                    Consultar Clientes
                                                </a>
                                            </li>

                                            <li>
                                                <a href="consulta_usuario.php">
                                                    <i class="fas fa-users"></i>
                                                    Consultar Usuários
                                                </a>
                                            </li>

                                            <li>
                                                <a href="consulta_produtos.php">
                                                    <i class="fas fa-clipboard-list"></i>
                                                    Consultar Produtos
                                                </a>
                                            </li>

                                            <!-- adicionar mais -->
                                        </ul>
                                    </li>
                                    <!-- Fim menu Consultas -->

                                    <li class="nav-parent nav-expanded">
                                        <a href="#">
                                            <i class="fas fa-exchange-alt"></i>
                                            <span>Estoque</span>
                                        </a>
                                        <ul class="nav nav-children">
                                            <li>
                                                <a href="#">
                                                    <i class="fas fa-retweet"></i>
                                                    Movimentos
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="far fa-clipboard"></i>
                                                    Relatórios
                                                </a>
                                            </li>
                                            <!-- adicionar mais -->
                                        </ul>
                                    </li>

                                    <!-- Fim menu Estoque -->

                                    <li class="nav-parent nav-expanded">
                                        <a href="#">
                                            <i class="fas fa-dollar-sign"></i>
                                            <span>Financeiro</span>
                                        </a>
                                        <ul class="nav nav-children">
                                            <li>
                                                <a href="caixa.php">
                                                    <i class="fas fa-hand-holding-usd"></i>
                                                    Caixa
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fas fa-file-invoice-dollar"></i>
                                                    Relatórios
                                                </a>
                                            </li>
                                            <!-- adicionar mais -->
                                        </ul>
                                    </li>
                                    <li class="nav-parent nav-expanded">
                                        <a href="#">
                                            <i class="fas fa-dollar-sign"></i>
                                            <span>Útil</span>
                                        </a>
                                        <ul class="nav nav-children">
                                            <li class="nav-parent">
                                                <a href="#">
                                                    <i class="fas fa-ban"></i>
                                                    Permissões
                                                </a>
                                                <ul class="nav nav-children">
                                                    <li>
                                                        <a class="nav-link" href="cad_permissoes.php">
                                                            <i class="fas fa-user-lock"></i>
                                                            Permissões
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="nav-link" href="cad_telas.php">
                                                            <i class="far fa-file-alt"></i>
                                                            Cadastrar Páginas
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li>
                                                <a href="logs.php">
                                                    <i class="fas fa-scroll"></i>
                                                    Logs
                                                </a>
                                            </li>
                                            <li>
                                                <a href="download/VisionPremium.apk" download>
                                                    <i class="fas fa-hand-holding-usd"></i>
                                                    Download Aplicativo
                                                </a>
                                            </li>
                                            <!-- adicionar mais -->
                                        </ul>
                                    </li>
                                </ul>
                            </nav>

                            <hr class="separator" />


                        </div>

                        <script>
                            // Maintain Scroll Position
                            if (typeof localStorage !== 'undefined') {
                                if (localStorage.getItem('sidebar-left-position') !== null) {
                                    var initialPosition = localStorage.getItem('sidebar-left-position'),
                                        sidebarLeft = document.querySelector('#sidebar-left .nano-content');

                                    sidebarLeft.scrollTop = initialPosition;
                                }
                            }
                        </script>


                    </div>

                </aside>
                <!-- end: sidebar -->

            <?php
        } else {
            header("Location: index.php");
        }

            ?>