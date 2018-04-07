<?php

require '../_app/Config.inc.php';

$idanamneses = $_GET['idanamneses'];

$RelatorioAnamnese = new Read;
$RelatorioAnamnese->FullRead("SELECT anamneses.idanamneses, anamneses.peso_anamnese, anamneses.altura_anamnese, anamneses.imc_anamnese, 
anamneses.pescoco_anamnese, anamneses.ombro_anamnese, anamneses.torax_anamnese, anamneses.abdome_anamnese, anamneses.cintura_anamnese, 
anamneses.quadril_anamnese, anamneses.bd_anamnese, anamneses.be_anamnese, anamneses.bec_anamnese, anamneses.bdc_anamnese, anamneses.aec_anamnese, 
anamneses.adc_anamnese, anamneses.ce_anamnese, anamneses.cd_anamnese, anamneses.pe_anamnese, anamneses.pd_anamnese, anamneses.obs_anamnese, alunos_cliente.nome_aluno
FROM anamneses
INNER JOIN alunos_cliente ON anamneses.idalunos_cliente = alunos_cliente.idalunos_cliente
WHERE anamneses.idanamneses = {$idanamneses}");

require 'Relatorios/autoload.inc.php';

use Dompdf\Dompdf;

$html = "
    <link rel='stylesheet' type='text/css' href='../_cdn/bootstrap/css/bootstrap.min.css'>
    <style>
        .relatorio th{
            color: black;
            font-size: 12px;
            width: 200px;
            background-color: #99ccff;
        }
        .relatorio td{
            color: black;
            width: 450px;
        }
    </style>
    <table class='table' style='background-color: #99ccff;'>
        <tr class='relatorio'>
            <th>
                <img style='width: 200px; height: 200px;' src='img/logoAcademia.png'>
            </th>
            <th style='width: 400px; background-color: #99ccff;'>
                <div style='color: white;'>
                    <p>Academia Performance Fit</p>
                    <p>Endereço: Rua Dr Soares QD 05, LT 48</p>
                    <p>Bairro: Colina Azul</p>
                    <p>Municipio: Aparecida de Goiânia GO CEP 00000-000</p>
                </div>	
                <div style='margin-top: 15px; font-size: 30px; color: black;'> 
                    <label>Relatório de Anamnese</label>
                </div>			
            </th>
        </tr>
    </table>
    <table style='background-color: whitesmoke; font-size: 12px;' class='table'>
";

foreach ($RelatorioAnamnese->getResult() as $e):
    extract($e);
    $html .= "<tr class='relatorio'>"
            . "<th>ID</th>"
            . "<td>{$idanamneses}</td>"
            . "</tr>"
            . "<tr class='relatorio'>"
            . "<th>Matricula do Aluno</th>"
            . "<td>{$nome_aluno}</td>"
            . "</tr>"
            . "<tr class='relatorio'>"
            . "<th>Peso</th>"
            . "<td>{$peso_anamnese}</td>"
            . "</tr>"
            . "<tr class='relatorio'>"
            . "<th>Altura</th>"
            . "<td>{$altura_anamnese}</td>"
            . "</tr>"
            . "<tr class='relatorio'>"
            . "<th>IMC</th>"
            . "<td>{$imc_anamnese}</td>"
            . "</tr>"
            . "<tr class='relatorio'>"
            . "<th>Medida do Pescoço</th>"
            . "<td>{$pescoco_anamnese}</td>"
            . "</tr>"
            . "<tr class='relatorio'>"
            . "<th>Largura dos Ombros</th>"
            . "<td>{$ombro_anamnese}</td>"
            . "</tr>"
            . "<tr class='relatorio'>"
            . "<th>Largura do Torax</th>"
            . "<td>{$torax_anamnese}</td>"
            . "</tr>"
            . "<tr class='relatorio'>"
            . "<th>Largura do Addome</th>"
            . "<td>{$abdome_anamnese}</td>"
            . "</tr>"
            . "<tr class='relatorio'>"
            . "<th>Largura da Cintura</th>"
            . "<td>{$cintura_anamnese}</td>"
            . "</tr>"
            . "<tr class='relatorio'>"
            . "<th>Largura do Quadril</th>"
            . "<td>{$quadril_anamnese}</td>"
            . "</tr>"
            . "<tr class='relatorio'>"
            . "<th>Braço direito</th>"
            . "<td>{$bd_anamnese}</td>"
            . "</tr>"
            . "<tr class='relatorio'>"
            . "<th>Braço esquerdo</th>"
            . "<td>{$be_anamnese}</td>"
            . "</tr>"
            . "<tr class='relatorio'>"
            . "<th>Braço direito contraido</th>"
            . "<td>{$bdc_anamnese}</td>"
            . "</tr>"
            . "<tr class='relatorio'>"
            . "<th>Braço esquerdo contraido</th>"
            . "<td>{$bec_anamnese}</td>"
            . "</tr>"
            . "<tr class='relatorio'>"
            . "<th>Antebraço esquerdo contraido</th>"
            . "<td>{$aec_anamnese}</td>"
            . "</tr>"
            . "<tr class='relatorio'>"
            . "<th>Antebraço direito contraido</th>"
            . "<td>{$adc_anamnese}</td>"
            . "</tr>"
            . "<tr class='relatorio'>"
            . "<th>Coxa esquerda</th>"
            . "<td>{$ce_anamnese}</td>"
            . "</tr>"
            . "<tr class='relatorio'>"
            . "<th>Coxa direita</th>"
            . "<td>{$cd_anamnese}</td>"
            . "</tr>"
            . "<tr class='relatorio'>"
            . "<th>Panturilha esquerda</th>"
            . "<td>{$pe_anamnese}</td>"
            . "</tr>"
            . "<tr class='relatorio'>"
            . "<th>Panturilha direita</th>"
            . "<td>{$pd_anamnese}</td>"
            . "</tr>"
            . "<tr class='relatorio'>"
            . "<th>Observações</th>"
            . "<td>{$obs_anamnese}</td>"
            . "</tr>";
endforeach;

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