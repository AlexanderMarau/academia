<?php

require '../_app/Config.inc.php';

$RelatorioMensalidades = new Read;
$RelatorioMensalidades->FullRead("SELECT mensalidades.idmensalidades, alunos_cliente.nome_aluno, mensalidades.data_mens_pag, "
        . "mensalidades.data_mens_pag, mensalidades.valor_mensalidades, mensalidades.status_mensalidades, mensalidades.obs_mensalidades "
        . "FROM mensalidades "
        . "INNER JOIN alunos_cliente "
        . "ON mensalidades.idalunos_cliente = alunos_cliente.idalunos_cliente");

require 'Relatorios/autoload.inc.php';

use Dompdf\Dompdf;

$html = "        <head>    
                <meta charset='UTF-8'>
                <title>Relátorio de Mensalidades</title>
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

            <h2>Relátorio de todas Mensalidades</h2>
            
<table  style='width:100%'>";

foreach ($RelatorioMensalidades->getResult() as $e):
    extract($e);

    $html .= "<tr>"
            . "<th>ID</th>"
            . "<td>{$idmensalidades}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Matricula do Aluno</th>"
            . "<td>{$nome_aluno}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Data de Pagamento</th>"
            . "<td>{$data_mens_pag}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Valor</th>"
            . "<td>{$valor_mensalidades}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Status</th>"
            . "<td>{$status_mensalidades}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Observação</th>"
            . "<td>{$obs_mensalidades}</td>"
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
relatorioMensalidades.pdf
", array(
    "Attachment" => false)
);
?>