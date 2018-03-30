<?php

require '../_app/Config.inc.php';

$idvendas = $_GET['idvendas'];

$ComprovanteVenda = new Read;
$ComprovanteVenda->FullRead("SELECT vendas.idvendas, vendas.data_venda, vendas.valor_total, alunos_cliente.cpf_aluno, alunos_cliente.nome_aluno
FROM vendas
INNER JOIN alunos_cliente ON vendas.idalunos_cliente = alunos_cliente.idalunos_cliente
WHERE vendas.idvendas = {$idvendas};");

$ItensVenda = new Read;
$ItensVenda->FullRead("SELECT itens_vendas.iditensvendas, itens_vendas.qt_vendas, itens_vendas.valor_prod, itens_vendas.valor_vendas ,vendas.idvendas, produtos.nome_prod
FROM itens_vendas
INNER JOIN vendas ON itens_vendas.idvendas = vendas.idvendas
INNER JOIN produtos ON itens_vendas.idprodutos = produtos.idprodutos
WHERE vendas.idvendas = {$idvendas};");

require 'Relatorios/autoload.inc.php';

use Dompdf\Dompdf;

foreach ($ComprovanteVenda->getResult() as $e):
    extract($e);
    $html = "

<html>
    <head>
        <link rel='stylesheet' type='text/css' href='http://localhost/academia/Views/css/comprovante_venda.css'>
    </head>
    <div>
        <body>
            <table width='100%'>
                <!--INICIO-->
                <tr>
                    <td width='70%'>
                        <p align='center'><b>COMPROVANTE DE VENDA</b></p>
                        <p>Natureza VENDA</p>
                        <p>CFOP VENDA DENTRO DO ESTADO</p>
                    </td>
                    <td class='table-nota' width='30%'>
                        <p>Número do documento: <b>{$idvendas}</b></p>
                        <p>Data de Emissão: <b>{$data_venda}</b></p>
                        <p>Data de Vencimento: </p>
                    </td>
                </tr>
            </table>
            <table  width='100%'>
                <tr>
                    <td>
                        <p align='center'><b>PRESTADOR DOS SERVIÇOS</b></p>
                        <p><b>CPF/CNPJ</b> 000.000.000-00</p>
                        <p><b>Nome/Razão Social</b> Academia Performance Fit</p>
                        <p><b>Endereço</b> Rua Dr. Juares Teste QD. 09, LT.30</p>
                        <p><b>Bairro</b> Colina Azul</p>
                        <p><b>Município</b> Aparecida de Goiânia GO CEP 00000-000</p>
                        <p><b>Inscrição Estadual</b> ISENTO</p>
                    </td>
                </tr>
            </table>
            <table width='100%'>
                <tr>
                    <td>
                        <p align='center'><b>TOMADOR DOS SERVIÇOS</b></p>
                        <p><b>CPF</b> {$cpf_aluno}</p>
                        <p><b>Nome do Cliente</b> {$nome_aluno}</p>
                        <p><b>Inscrição Estadual</b> ISENTO</p>
                    </td>
                </tr>
            </table>
            <table width='100%'>
                <tr>
                    <th align='center' widht='100%'>
                        <p align='center'>DISCRIMINAÇÃO DOS SERVIÇOS</p>
                    </th>
                <tr>
            </table>
            <!--MEIO-->
            <table class='table-itens' width='100%'>
                <tr>
                    <th>Item</th>
                    <th>Qtd</th>
                    <th>Descrição</th>
                    <th>Valor Unitário</th>
                    <th>Total</th>
                </tr>";
    foreach ($ItensVenda->getResult() as $e):  
        extract($e);
            $html.=            
                "<tr>
                    <td>{$iditensvendas}</td>
                    <td>{$qt_vendas}</td>
                    <td>{$nome_prod}</td>
                    <td>R$ {$valor_prod}</td>
                    <td>R$ {$valor_vendas}</td>
                </tr>";
    endforeach;
            $html.=
            "</table>
            <!--FIM-->
            <table width='100%'>
                <tfoot class='fim'>
                    <tr>
                        <td>
                            <p align='center'><b>INFORMAÇÕES ADICIONAIS</b></p>
                            <p>Obeservações adicionais devem ser colocadas aqui...</p>
                        </td>
                    </tr>
                </tfoot>
            </table>
            <table width='100%'>
                <tfoot class='fim'>
                    <tr>
                        <td width='70%'>
                            <p align='center'><b>CONDIÇÕES DE PAGAMENTO</b></p>
                            <p>Apenas em Dinheiro</p>
                        </td>
                        <td class='table-valor' width='30%'>
                            <p>Valor {$valor_total}</p>
                            <p>Acréscimo 0,00</p>
                            <p>Desconto 0,00</p>
                            <p><b>Total R$ {$valor_total}</b></p>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </body>
    </div>
</html>
";
endforeach;

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
