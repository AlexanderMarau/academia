<?php

require '../_app/Config.inc.php';

$RelatorioAlunos = new Read;
$RelatorioAlunos->FullRead("SELECT alunos_cliente.idalunos_cliente, alunos_cliente.nome_aluno, alunos_cliente.cpf_aluno, alunos_cliente.rg_aluno, alunos_cliente.nome_mae, alunos_cliente.nome_pai, alunos_cliente.email_aluno, alunos_cliente.celular_aluno, alunos_cliente.residencial_aluno, alunos_cliente.data_nascimento_aluno, alunos_cliente.status_aluno, alunos_cliente.obs_aluno, endereco_aluno.complementos_aluno, cidade.desc_cidade,  estado.desc_estado
FROM alunos_cliente
INNER JOIN endereco_aluno ON alunos_cliente.idendereco_aluno = endereco_aluno.idendereco_aluno
INNER JOIN cidade ON endereco_aluno.idendereco_aluno = cidade.idcidade
INNER JOIN estado ON cidade.idestado = estado.idestado");

require 'Relatorios/autoload.inc.php';

use Dompdf\Dompdf;

$html = "        <head>    
                <meta charset='UTF-8'>
                <title>Relátorio de Alunos</title>
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

            <h2>Relátorio de Alunos</h2>
            
<table  style='width:100%'>";

foreach ($RelatorioAlunos->getResult() as $e):
    extract($e);


    $html.= "<tr>"
            . "<th>Matricula</th>"
            . "<td>{$idalunos_cliente}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Nome</th>"
            . "<td>{$nome_aluno}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>CPF</th>"
            . "<td>{$cpf_aluno}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>RG</th>"
            . "<td>{$rg_aluno}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Nome da Mãe</th>"
            . "<td>{$nome_mae}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Nome da Pai</th>"
            . "<td>{$nome_pai}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>E-mail</th>"
            . "<td>{$email_aluno}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Celular</th>"
            . "<td>{$celular_aluno}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Residencial</th>"
            . "<td>{$residencial_aluno}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Data de Nascimento</th>"
            . "<td>{$data_nascimento_aluno}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Status</th>"
            . "<td>{$status_aluno}</td>"
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
            . "<td>{$complementos_aluno}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Observações</th>"
            . "<td>{$obs_aluno}</td>"
            . "</tr>"
            . "<tr style='background-color: red;'>"
            . "<th></th>"
            . "<td></td>"
            . "</tr>";

endforeach;

$html.= "</table>";

$dompdf = new Dompdf();

$dompdf->loadHtml($html);

$dompdf->set_paper('a4', 'landscape');

$dompdf->render();

$dompdf->stream("
relatorioAlunos.pdf
", array(
    "Attachment" => false)
);
?>