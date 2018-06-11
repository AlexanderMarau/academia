<?php

require '../_app/Config.inc.php';

$idhist_pag = $_GET['idhist_pag'];

$ReadHist = new Read;
$ReadHist->FullRead("SELECT historicos_mensalidades.idhist_pag, alunos_cliente.cpf_aluno, alunos_cliente.nome_aluno, planos.nome_plano, historicos_mensalidades.data_mens_pag, historicos_mensalidades.valor_pag " .
        "FROM historicos_mensalidades " .
        "INNER JOIN alunos_cliente ON historicos_mensalidades.idalunos_cliente = alunos_cliente.idalunos_cliente " .
        "INNER JOIN planos ON historicos_mensalidades.idplano = planos.idplano " .
        "WHERE historicos_mensalidades.idhist_pag = $idhist_pag");

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
                        <p align='center'><b>COMPROVANTE DE PAGAMENTO DE MENSALIDADE</b></p>
                    </td>
                    <td class='table-nota' width='30%'>
                        <p>Número do documento: <b>{$idhist_pag}</b></p>
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
                    <th align='center' widht='100%'>
                        <p align='center'>DISCRIMINAÇÃO DOS SERVIÇOS</p>
                    </th>
                <tr>
            </table>
            <!--MEIO-->
            <table class='table-itens' width='100%'>
                <tr>
                    <th>CPF</th>
                    <th>Aluno</th>
                    <th>Plano</th>
                    <th>Data de Pagamento</th>
                    <th>Valor Pago</th>
                </tr>";
foreach ($ReadHist->getResult() as $e):
    extract($e);
    $html .= "<tr>
                    <td>{$cpf_aluno}</td>
                    <td>{$nome_aluno}</td>
                    <td>{$nome_plano}</td>
                    <td>R$ {$data_mens_pag}</td>
                    <td>R$ {$valor_pag}</td>
                </tr>";
endforeach;
$html .= "</table>
            <!--FIM-->
            <table width='100%'>
                <tfoot class='fim'>
                    <tr>
                        <td>
                            <p align='center'><b>INFORMAÇÕES ADICIONAIS</b></p>
                            <p></p>
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
                            <p>Acréscimo 0,00</p>
                            <p>Desconto 0,00</p>
                            <p><b>Total R$ {$valor_pag}</b></p>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </body>
    </div>
</html>";


$dompdf = new Dompdf();

$dompdf->loadHtml($html);

$dompdf->set_paper('a4');

$dompdf->render();

$dompdf->stream("
Comprovante de Pagamento.pdf
", array(
    "Attachment" => false)
);
?>