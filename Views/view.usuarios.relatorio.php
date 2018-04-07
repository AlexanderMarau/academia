<?php

require '../_app/Config.inc.php';

$RelatorioUsuarios = new Read;
$RelatorioUsuarios->FullRead("SELECT usuario.idusuario, usuario.nome_usuario, usuario.email_usuario, usuario.perfil_usuario, funcionarios.nome_func 
FROM usuario
INNER JOIN funcionarios ON usuario.idfuncionarios = funcionarios.idfuncionarios");


require 'Relatorios/autoload.inc.php';

use Dompdf\Dompdf;

$html = "        <head>    
                <meta charset='UTF-8'>
                <title>Relátorio de Usuários</title>
                <style>
                 table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    padding: 5px;
    text-align: left;
}          </style>
            </head>

            <h1>Performance Academia</h1>

            <h2>Relátorio de Usuários</h2>
            
<table  style='width:100%'>";

foreach ($RelatorioUsuarios->getResult() as $e):
    extract($e);

    $html .= "<tr>"
            . "<th>ID</th>"
            . "<td>{$idusuario}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Nome do Usuário</th>"
            . "<td>{$nome_usuario}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Nome do Funcionário</th>"
            . "<td>{$nome_func}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>E-mail</th>"
            . "<td>{$email_usuario}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Perfil</th>"
            . "<td>{$perfil_usuario}</td>"
            . "</tr>"
            . "<tr style='background-color: red;'>"
            . "<th></th>"
            . "<td></td>"
            . "</tr>";
endforeach;

$html .= "</table>";

$dompdf = new Dompdf();

$dompdf->loadHtml($html);

$dompdf->set_paper('a4');

$dompdf->render();

$dompdf->stream("
relatorioUsuarios.pdf
", array(
    "Attachment" => false)
);
?>