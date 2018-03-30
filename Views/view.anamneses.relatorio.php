<?php

require '../_app/Config.inc.php';

$RelatorioAnamneses = new Read;
$RelatorioAnamneses->FullRead("SELECT anamneses.idanamneses, anamneses.peso_anamnese, anamneses.altura_anamnese, anamneses.imc_anamnese, 
anamneses.pescoco_anamnese, anamneses.ombro_anamnese, anamneses.torax_anamnese, anamneses.abdome_anamnese, anamneses.cintura_anamnese, 
anamneses.quadril_anamnese, anamneses.bd_anamnese, anamneses.be_anamnese, anamneses.bec_anamnese, anamneses.bdc_anamnese, anamneses.aec_anamnese, 
anamneses.adc_anamnese, anamneses.ce_anamnese, anamneses.cd_anamnese, anamneses.pe_anamnese, anamneses.pd_anamnese, anamneses.obs_anamnese, alunos_cliente.nome_aluno
FROM anamneses
INNER JOIN alunos_cliente ON anamneses.idalunos_cliente = alunos_cliente.idalunos_cliente");

require 'Relatorios/autoload.inc.php';

use Dompdf\Dompdf;

$html = "        <head>    
                <meta charset='UTF-8'>
                <title>Relátorio de Anamneses</title>
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

            <h2>Relátorio de Anamneses</h2>
            
            <table  style='width:100%'>";

foreach ($RelatorioAnamneses->getResult() as $e):
    extract($e);

    $html .= "<tr>"
            . "<th>ID</th>"
            . "<td>{$idanamneses}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Aluno</th>"
            . "<td>{$nome_aluno}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Peso</th>"
            . "<td>{$peso_anamnese}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Altura</th>"
            . "<td>{$altura_anamnese}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>IMC</th>"
            . "<td>{$imc_anamnese}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Medida do Pescoço</th>"
            . "<td>{$pescoco_anamnese}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Largura dos Ombros</th>"
            . "<td>{$ombro_anamnese}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Largura do Torax</th>"
            . "<td>{$torax_anamnese}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Largura do Addome</th>"
            . "<td>{$abdome_anamnese}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Largura da Cintura</th>"
            . "<td>{$cintura_anamnese}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Largura do Quadril</th>"
            . "<td>{$quadril_anamnese}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Braço direito</th>"
            . "<td>{$bd_anamnese}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Braço esquerdo</th>"
            . "<td>{$be_anamnese}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Braço direito contraido</th>"
            . "<td>{$bdc_anamnese}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Braço esquerdo contraido</th>"
            . "<td>{$bec_anamnese}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Antebraço esquerdo contraido</th>"
            . "<td>{$aec_anamnese}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Antebraço direito contraido</th>"
            . "<td>{$adc_anamnese}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Coxa esquerda</th>"
            . "<td>{$ce_anamnese}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Coxa direita</th>"
            . "<td>{$cd_anamnese}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Panturilha esquerda</th>"
            . "<td>{$pe_anamnese}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Panturilha direita</th>"
            . "<td>{$pd_anamnese}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Observações</th>"
            . "<td>{$obs_anamnese}</td>"
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
relatorioAnamneses.pdf
", array(
    "Attachment" => false)
);
?>