<?php

require '../_app/Config.inc.php';

$idfuncionarios = $_GET['idfuncionarios'];

$RelatorioFuncionario = new Read;
$RelatorioFuncionario->FullRead("SELECT funcionarios.idfuncionarios, funcionarios.nome_func, funcionarios.nome_pai_func, 
    funcionarios.nome_mae_func, funcionarios.dt_nasc_func, funcionarios.tipo_san_func, funcionarios.rg_func, 
    funcionarios.cpf_func, funcionarios.cpts_func, funcionarios.pis_func, funcionarios.estado_civil_func, 
    funcionarios.nacionalidade_func, funcionarios.naturalidade_func, funcionarios.cargo_func, funcionarios.funcao_func, 
    funcionarios.salario_func, funcionarios.entrada_func, funcionarios.saida_func, funcionarios.email_func, 
    funcionarios.celular_func, funcionarios.residencial_func, funcionarios.status_func, funcionarios.obs_func, 
    estado.desc_estado, cidade.desc_cidade, endereco_fun.complementos_fun
FROM funcionarios
INNER JOIN endereco_fun ON funcionarios.idendereco_func = endereco_fun.idendereco_fun
INNER JOIN cidade ON endereco_fun.idcidade = cidade.idcidade
INNER JOIN estado ON cidade.idestado = estado.idestado 
WHERE funcionarios.idfuncionarios = {$idfuncionarios}");

require 'Relatorios/autoload.inc.php';

use Dompdf\Dompdf;

$html = "        <head>    
                <meta charset='UTF-8'>
                <title>Relátorio do Funcionário</title>
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

            <h2>Relátorio do Funcionário</h2>
            
            <table  style='width:100%'>";

foreach ($RelatorioFuncionario->getResult() as $e):

    extract($e);
    $html .= "<tr>"
            . "<th>ID</th>"
            . "<td>{$idfuncionarios}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Nome</th>"
            . "<td>{$nome_func}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Nome do Pai</th>"
            . "<td>{$nome_pai_func}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Nome da Mãe</th>"
            . "<td>{$nome_mae_func}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Data de Nascimento</th>"
            . "<td>{$dt_nasc_func}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Tipo de Sangue</th>"
            . "<td>{$tipo_san_func}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>RG</th>"
            . "<td>{$rg_func}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>CPF</th>"
            . "<td>{$cpf_func}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>CPTS</th>"
            . "<td>{$cpts_func}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>PIS</th>"
            . "<td>{$pis_func}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Estado Civil</th>"
            . "<td>{$estado_civil_func}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Nacionalidade</th>"
            . "<td>{$nacionalidade_func}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Naturalidade</th>"
            . "<td>{$naturalidade_func}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Cargo</th>"
            . "<td>{$cargo_func}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Função</th>"
            . "<td>{$funcao_func}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Salario</th>"
            . "<td>{$salario_func}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Hora de entrada</th>"
            . "<td>{$entrada_func}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Hora de saída</th>"
            . "<td>{$saida_func}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>E-mail</th>"
            . "<td>{$email_func}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Telefone Celular</th>"
            . "<td>{$celular_func}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Telefone Residencial</th>"
            . "<td>{$residencial_func}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Status</th>"
            . "<td>{$status_func}</td>"
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
            . "<td>{$complementos_fun}</td>"
            . "</tr>"
            . "<tr>"
            . "<th>Observações</th>"
            . "<td>{$obs_func}</td>"
            . "</tr>";

endforeach;

$html .= "</table>";

$dompdf = new Dompdf();

$dompdf->loadHtml($html);

$dompdf->set_paper('a4');

$dompdf->render();

$dompdf->stream("
relatorioFuncionario.pdf
", array(
    "Attachment" => false)
);
?>