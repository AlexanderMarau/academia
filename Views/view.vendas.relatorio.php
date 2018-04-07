<?php

require '../_app/Config.inc.php';

$RelatorioVendas = new Read;
$RelatorioVendas->FullRead("SELECT vendas.idvendas, vendas.data_venda, usuario.nome_usuario, alunos_cliente.nome_aluno, vendas.itens_total, vendas.valor_total "
                        . "FROM vendas "
                        . "INNER JOIN usuario ON vendas.idusuario = usuario.idusuario "
                        . "INNER JOIN alunos_cliente ON vendas.idalunos_cliente = alunos_cliente.idalunos_cliente "
                        . "ORDER BY vendas.idvendas DESC");

require 'Relatorios/autoload.inc.php';

use Dompdf\Dompdf;

$html = "        <head>    
                <meta charset='UTF-8'>
                <title>Relátorio de Vendas</title>
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

            <h2>Relátorio de Vendas</h2>
            
            <table  style='width:100%'>";

foreach ($RelatorioVendas->getResult() as $e):
    extract($e);

    $html .= "<tr>"
            . "<th>Número da Venda</th>"
            . "<td>{$idvendas}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Data da Venda</th>"
            . "<td>{$data_venda}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Vendedor</th>"
            . "<td>{$nome_usuario}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Cliente</th>"
            . "<td>{$nome_aluno}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Total de Itens</th>"
            . "<td>{$itens_total}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Valor Total</th>"
            . "<td>R$ {$valor_total}</td>"
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
relatorioVendas.pdf
", array(
    "Attachment" => false)
);
?>