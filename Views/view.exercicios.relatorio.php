<?php

require '../_app/Config.inc.php';

$RelatorioExercicios = new Read;
$RelatorioExercicios->FullRead("SELECT * FROM exercicios");

require 'Relatorios/autoload.inc.php';

use Dompdf\Dompdf;

$html = "        <head>    
                <meta charset='UTF-8'>
                <title>Relátorio de Exercícios</title>
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

            <h2>Relátorio de Exercícios</h2>
            
            <table  style='width:100%'>
            
            <tr>
            <th>ID</th>
            <th>Descrição</th>
            <th>Grupo Muscular</th>
            </tr>";

foreach ($RelatorioExercicios->getResult() as $e):
    extract($e);
    $html .= "<tr>"
            ."<td>{$idexercicios}</td>"
            ."<td>{$descricao_exe}</td>"
            ."<td>{$grupo_muscular_exe}</td>"
            ."</tr>";
endforeach;

$dompdf = new Dompdf();

$dompdf->loadHtml($html);

$dompdf->set_paper('a4');

$dompdf->render();

$dompdf->stream("
relatorioExercicios.pdf
", array(
    "Attachment" => false)
);
?>