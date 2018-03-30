<?php
require 'Relatorios/autoload.inc.php';

use Dompdf\Dompdf;

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
                        <p align='center'><b>COMPROVANTE FISCAL</b></p>
                        <p>Natureza VENDA</p>
                        <p>CFOP VENDA DENTRO DO ESTADO</p>
                    </td>
                    <td class='table-nota' width='30%'>
                        <p>Número da Nota: <b>0001</b></p>
                        <p>Data de Emissão: <b>25/11/2017</b></p>
                        <p>Data de Vencimento: <b>10/12/2017</b></p>
                    </td>
                </tr>
            </table>
            <table  width='100%'>
                <tr>
                    <td>
                        <p align='center'><b>PRESTADOR DOS SERVIÇOS</b></p>
                        <p><b>CPF/CNPJ</b> 702.638.511-92</p>
                        <p><b>Nome/Razão Social</b> Diego Humberto da Costa Oliveira</p>
                        <p><b>Endereço</b> Rua Dr. Juares Tavares de Azevedo QD. 09, LT.30</p>
                        <p><b>Bairro</b> Terra Prometida</p>
                        <p><b>Município</b> Aparecida de Goiânia GO CEP 00000-000</p>
                        <p><b>Inscrição Estadual</b> ISENTO</p>
                    </td>
                </tr>
            </table>
            <table width='100%'>
                <tr>
                    <td>
                        <p align='center'><b>TOMADOR DOS SERVIÇOS</b></p>
                        <p><b>CPF</b> 000.000.000-00</p>
                        <p><b>Nome do Cliente</b> Renato Jose da Silva</p>
                        <p><b>Endereço</b> Rua tal tal tal 120 QD.20, LT.40</p>
                        <p><b>Bairro</b> Jardim Europa</p>
                        <p><b>Municipio</b> GOIÂNIA GO CEP 00000-000</p>
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
                    <th>Valor</th>
                    <th>Total</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>7</td>
                    <td>Camiseta Regata</td>
                    <td>R$ 15,00</td>
                    <td>R$ 105,00</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>10</td>
                    <td>Passoca</td>
                    <td>R$ 1,00</td>
                    <td>R$ 10,00</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>5</td>
                    <td>Coca Cola lata 600ml</td>
                    <td>R$ 6,00</td>
                    <td>R$ 30,00</td>
                </tr>
            </table>
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
                            <p>Valor 145,00</p>
                            <p>Acréscimo 0,00</p>
                            <p>Desconto 0,00</p>
                            <p><b>Total R$ 145,00</b></p>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </body>
    </div>
</html>
";       

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
