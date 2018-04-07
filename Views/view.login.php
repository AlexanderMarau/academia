<?php
session_start();
?>

<!-- <link rel="stylesheet" href="../_cdn/bootstrap/css/bootstrap.min.css"> -->
<!-- <link rel="stylesheet" href="../_cdn/jquery.min.js"> -->
<!-- <link rel="stylesheet" href="../_cdn/bootstrap/js/bootstrap.min.js"> -->

<!--INÍCIO DAS MENSAGENS:-->
<div class="resultado_login animated zoomInRight">
    Resultado
</div>
<!--FIM DAS MENSAGENS-->
<!--FORMULÁRIO DE LOGIN:-->
<body class="login">
    <div class="container fundo-login">
        <h2 align="center">Academia Performance Fit</h2>

        <form class="form-group col-md-12 pf_form" action="" method="POST">
            <input type="hidden" name="callback" value="verificar_login">
            <div class="form-group">
                <label>E-mail</label><br>
                <input type="text" name="email_usuario" class="form-control" placeholder="E-mail">
            </div>
            <div class="form-group">
                <label>Senha</label><br>
                <input type="password" name="senha_usuario" class="form-control" placeholder="Senha">
            </div>
            <div  class="form-group ">
                <button type="submit" class="btn btn-primary btn-lg entrar" value="Entrar" name="Entrar">Entrar</button>
                <div class="pf_load">
                    <img alt="" title="" src="Views/img/load.gif"/>
                </div>
            </div>
        </form>
    </div>
    <div class="container">
        <div class="rodape-login">
        <p><b>Academia Performance Fit</b></p>
        <p><b>CNPJ</b> 30.087.426/0001-95</p>
        <p><b>Endereço</b> Rua Central.. Qd30, lt09 Goiânia GO CEP 72855-239</p>
        <p><b>Telefones</b> (62)3240-0000, (62)9 9900-0099</p>
        <p><b>E-mail</b> academia@performancefit.com</p>
        </div>
    </div>   
</body>
    </div>
</body>
<?php
session_destroy();
?>