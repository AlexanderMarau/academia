<?php

require '../_app/Config.inc.php';

$RelatorioTreinos = new Read;
$RelatorioTreinos->FullRead("SELECT treinos.idtreino, treinos.nome_treino, treinos.sigla_treino, treinos.grupos_muscular_treino, treinos.series_treino, treinos.obs_treino, exercicios.descricao_exe, equipamentos.nome_equip
FROM treinos 
INNER JOIN exercicios ON treinos.idexercicio = exercicios.idexercicios
INNER JOIN equipamentos ON treinos.idequipamentos = equipamentos.idequipamentos");

require 'Relatorios/autoload.inc.php';

use Dompdf\Dompdf;

$html = "        <head>    
                <meta charset='UTF-8'>
                <title>Relátorio de Treinos</title>
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

            <h2>Relátorio de Treinos</h2>
            
            <table  style='width:100%'>";

foreach ($RelatorioTreinos->getResult() as $e):
    extract($e);

    $html .= "<tr>"
            . "<th>ID</th>"
            . "<td>{$idtreino}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Nome do Treino</th>"
            . "<td>{$nome_treino}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Exercicio</th>"
            . "<td>{$descricao_exe}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Equipamento</th>"
            . "<td>{$nome_equip}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Sigla do Treino</th>"
            . "<td>{$sigla_treino}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Grupo muscular</th>"
            . "<td>{$grupos_muscular_treino}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>número de series</th>"
            . "<td>{$series_treino}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Observações</th>"
            . "<td>{$obs_treino}</td>"
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
relatorioTreinos.pdf
", array(
    "Attachment" => false)
);
?>