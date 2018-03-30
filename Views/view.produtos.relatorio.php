<?php

require '../_app/Config.inc.php';

$RelatorioProdutos = new Read;
$RelatorioProdutos->FullRead("SELECT produtos.idprodutos, produtos.nome_prod, produtos.peso_prod, produtos.cor_prod, produtos.tamanho_prod, produtos.numero_prod, produtos.con_indicacao_prod, produtos.dt_entr_prod, produtos.marca_prod, produtos.fabricante_prod, produtos.validade_prod, produtos.obs_prod, cat_produto.descricao, fornecedores.nome_forn, estoq_prod.quant_estoque 
FROM produtos 
INNER JOIN cat_produto ON cat_produto.idcate_produto = produtos.idcate_produto 
INNER JOIN fornecedores ON fornecedores.idfornecedores = produtos.idfornecedores 
INNER JOIN estoq_prod ON estoq_prod.idprodutos = produtos.idprodutos");


require 'Relatorios/autoload.inc.php';

use Dompdf\Dompdf;

$html = "        <head>    
                <meta charset='UTF-8'>
                <title>Relátorio de Produtos</title>
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

            <h2>Relátorio de Produtos</h2>
            
            <table  style='width:100%'>";

foreach ($RelatorioProdutos->getResult() as $e):
    extract($e);

    $html .= "<tr>"
            . "<th>ID</th>"
            . "<td>{$idprodutos}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Nome do produto</th>"
            . "<td>{$nome_prod}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Categoria</th>"
            . "<td>{$descricao}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Fornecedor</th>"
            . "<td>{$nome_forn}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Peso</th>"
            . "<td>{$peso_prod}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Cor</th>"
            . "<td>{$cor_prod}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Tamanho</th>"
            . "<td>{$tamanho_prod}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Número</th>"
            . "<td>{$numero_prod}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Contra indicações</th>"
            . "<td>{$con_indicacao_prod}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Data de entrada</th>"
            . "<td>{$dt_entr_prod}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Marca</th>"
            . "<td>{$marca_prod}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Fabricante</th>"
            . "<td>{$fabricante_prod}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Data de validade</th>"
            . "<td>{$validade_prod}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Quantidade Estoque</th>"
            . "<td>{$quant_estoque}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Observações</th>"
            . "<td>{$obs_prod}</td>"
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
relatorioProdutos.pdf
", array(
    "Attachment" => false)
);
?>