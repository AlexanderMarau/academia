<?php

require '../_app/Config.inc.php';

$idvendas = $_GET['idvendas'];

$RelatorioVenda = new Read;
$RelatorioVenda->FullRead("SELECT vendas.idvendas, vendas.data_venda, vendas.valor_vendas, vendas.qt_vendas, produtos.nome_prod, alunos_cliente.nome_aluno
FROM vendas
INNER JOIN produtos ON vendas.idprodutos = produtos.idprodutos
INNER JOIN alunos_cliente ON vendas.idalunos_cliente = alunos_cliente.idalunos_cliente 
WHERE vendas.idvendas = {$idvendas}");

require 'Relatorios/autoload.inc.php';

use Dompdf\Dompdf;

$html = "        <head>    
                <meta charset='UTF-8'>
                <title>Relátorio de Venda</title>
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

            <h2>Relátorio de Venda</h2>
            
            <table  style='width:100%'>";

foreach ($RelatorioVenda->getResult() as $e):
    extract($e);

    $html .= "<tr>"
            . "<th>ID</th>"
            . "<td>{$idvendas}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Produto</th>"
            . "<td>{$nome_prod}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Cliente</th>"
            . "<td>{$nome_aluno}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Data da Venda</th>"
            . "<td>{$data_venda}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Quantidade</th>"
            . "<td>{$qt_vendas}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Valor da Venda</th>"
            . "<td>R$ {$valor_vendas}</td>"
            . "</tr>";

endforeach;

$html .= "</table>";

$dompdf = new Dompdf();

$dompdf->loadHtml($html);

$dompdf->set_paper('a4');

$dompdf->render();

$dompdf->stream("
relatorioVenda.pdf
", array(
    "Attachment" => false)
);
?>