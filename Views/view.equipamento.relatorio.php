<?php

require '../_app/Config.inc.php';

$RelatorioEquip = new Read;
$RelatorioEquip->FullRead("SELECT equipamentos.idequipamentos, equipamentos.nome_equip, equipamentos.data_equip_entr, equipamentos.data_equip_saida, equipamentos.preco_equip_entr, equipamentos.marca_equip, equipamentos.funcionalidade_equip, equipamentos.data_manutencao_equip, fornecedores.nome_forn
FROM equipamentos
INNER JOIN fornecedores ON equipamentos.idfornecedores = fornecedores.idfornecedores");

require 'Relatorios/autoload.inc.php';

use Dompdf\Dompdf;

$html = "        <head>    
                <meta charset='UTF-8'>
                <title>Relátorio de Equipamentos</title>
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

            <h2>Relátorio de Equipamentos</h2>
            
            <table  style='width:100%'>";

foreach ($RelatorioEquip->getResult() as $e):

    extract($e);

    $html .= "<tr>"
            . "<th>ID</th>"
            . "<td>{$idequipamentos}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Nome do equipamento</th>"
            . "<td>{$nome_equip}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Fornecedor</th>"
            . "<td>{$nome_forn}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Data de entrada</th>"
            . "<td>{$data_equip_entr}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Data de Saida</th>"
            . "<td>{$data_equip_saida}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Preço de entrada</th>"
            . "<td>{$preco_equip_entr}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Marca</th>"
            . "<td>{$marca_equip}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Funcionalidade</th>"
            . "<td>{$funcionalidade_equip}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Data de manutenção</th>"
            . "<td>{$data_manutencao_equip}</td>"
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
relatorioEquipamento.pdf
", array(
    "Attachment" => false)
);
?>