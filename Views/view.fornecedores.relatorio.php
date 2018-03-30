<?php

require '../_app/Config.inc.php';

$RelatorioFornecedores = new Read;
$RelatorioFornecedores->FullRead("SELECT fornecedores.idfornecedores, fornecedores.nome_forn, fornecedores.cnpj_cpf_forn, fornecedores.nome_fantasia_forn, fornecedores.email_forn, fornecedores.telefone_forn, estado.desc_estado, cidade.desc_cidade, endereco_fornecedor.complementos_forn
FROM fornecedores
INNER JOIN endereco_fornecedor ON fornecedores.idendereco_forn = endereco_fornecedor.idendereco_forn
INNER JOIN cidade ON endereco_fornecedor.idcidade = cidade.idcidade
INNER JOIN estado ON endereco_fornecedor.idestado = estado.idestado");

require 'Relatorios/autoload.inc.php';

use Dompdf\Dompdf;

$html = "        <head>    
                <meta charset='UTF-8'>
                <title>Relátorio de Fornecedores</title>
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

            <h2>Relátorio de Fornecedores</h2>
            
            <table  style='width:100%'>";

foreach ($RelatorioFornecedores->getResult() as $e):

    extract($e);
    $html .= "<tr>"
            . "<th>ID</th>"
            . "<td>{$idfornecedores}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Nome</th>"
            . "<td>{$nome_forn}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>CNPJ/CPF</th>"
            . "<td>{$cnpj_cpf_forn}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Nome fantasia</th>"
            . "<td>{$nome_fantasia_forn}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>E-mail</th>"
            . "<td>{$email_forn}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Telefone</th>"
            . "<td>{$telefone_forn}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Estado</th>"
            . "<td>{$desc_estado}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Cidade</th>"
            . "<td>{$desc_cidade}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Complemento do Endereço</th>"
            . "<td>{$complementos_forn}</td>"
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
relatorioAnamnese.pdf
", array(
    "Attachment" => false)
);
?>