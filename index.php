<?php require './_app/Config.inc.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Academia Performance Fit</title>
        <link rel="shortcut icon" href="Views/img/icon02.png">
        <!--<link rel="stylesheet" type="text/css" href="_cdn/bootstrap-4.0/css/bootstrap.min.css">-->
        <link rel="stylesheet" type="text/css" href="_cdn/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="_cdn/bootstrap/jasny-bootstrap/css/jasny-bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="Views/css/menu.css">
        <link rel="stylesheet" type="text/css" href="Views/css/animate.css">
        <link rel="stylesheet" type="text/css" href="Views/css/style.css">
    </head>
    <body>
        <!--CONTEUDO-->
        <?php
//        var_dump($Url);
        $Url[1] = (empty($Url[1]) ? null : $Url[1]);

        if (file_exists(REQUIRE_PATH . '/' . $Url[0] . '.php')):
            require REQUIRE_PATH . '/' . $Url[0] . '.php';
        elseif (file_exists(REQUIRE_PATH . '/' . $Url[0] . '/' . $Url[1] . '.php')):
            require REQUIRE_PATH . '/' . $Url[0] . '/' . $Url[1] . '.php';
        else:
            require REQUIRE_PATH . '/404.php';
        endif;
        ?>
        <!--FIM CONTEUDO-->

        <!--FIM FORMULÁRIO DE LOGIN-->
        <!--INÍCIO DE SCRIPTS:-->
        <script src="_cdn/jquery.js"></script>
        <script src="_cdn/jquery.min.js"></script>
        <script src="_cdn/jquery.mask.min.js"></script>
        <script src="_cdn/bootstrap/js/bootstrap.min.js"></script>
        <script src="_cdn/mascara.js"></script>
        <script src="_cdn/console.geral.js"></script>
        <script src="Controllers/controller.verificar_login.js"></script> 
        <script src="Controllers/controller.fornecedor.js"></script>
        <script src="Controllers/controller.aluno.js"></script>
        <script src="Controllers/controller.funcionario.js"></script>
        <script src="Controllers/controller.anamnese.js"></script>
        <script src="Controllers/controller.equipamento.js"></script>
        <script src="Controllers/controller.treino.js"></script>
        <script src="Controllers/controller.exercicios.js"></script>
        <script src="Controllers/controller.usuario.js"></script>
        <script src="Controllers/controller.mensalidade.js"></script>
        <script src="Controllers/controller.produto.js"></script>
        <script src="Controllers/controller.venda.js"></script>
        <!--FIM DE SCRIPTS:-->
    </body>
</html>