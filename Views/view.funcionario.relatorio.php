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

$html = "
    <link rel='stylesheet' type='text/css' href='../_cdn/bootstrap/css/bootstrap.min.css'>
    <style>
        .relatorio th{
            color: black;
            font-size: 14px;
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
                <div style='margin-top: 15px; font-size: 20px; color: black;'> 
                    <label>Relatório do Funcionário</label>
                </div>			
            </th>
        </tr>
    </table>
    <table style='background-color: whitesmoke; font-size: 12px;' class='table'>
";

foreach ($RelatorioFuncionario->getResult() as $e):

    extract($e);
    $html .= "
        <tr class='relatorio'>
            <th>Matricula</th>
            <td>{$idfuncionarios}</td>
        </tr>
        <tr class='relatorio'>
            <th>Nome</th>
            <td>{$nome_func}</td>
        </tr>
        <tr class='relatorio'>
            <th>Pai</th>
            <td>{$nome_pai_func}</td>
        </tr>
        <tr class='relatorio'>
            <th>Mãe</th>
            <td>{$nome_mae_func}</td>
        </tr>
        <tr class='relatorio'>
            <th>Dt. de nascimento</th>
            <td>{$dt_nasc_func}</td>
        </tr>
        <tr class='relatorio'>
            <th>Tipo de Sangue</th>
            <td>{$tipo_san_func}</td>
        </tr>
        <tr class='relatorio'>
            <th>RG</th>
            <td>{$rg_func}</td>
        </tr>
        <tr class='relatorio'>
            <th>CPF</th>
            <td>{$cpf_func}</td>
        </tr>
        <tr class='relatorio'>
            <th>CPTS</th>
            <td>{$cpts_func}</td>
        </tr>
        <tr class='relatorio'>
            <th>PIS</th>
            <td>{$pis_func}</td>
        </tr>
        <tr class='relatorio'>
            <th>Estado Civil</th>
            <td>{$estado_civil_func}</td>
        </tr>
        <tr class='relatorio'>
            <th>Nacionalidade</th>
            <td>{$nacionalidade_func}</td>
        </tr>
        <tr class='relatorio'>
            <th>Naturalidade</th>
            <td>{$naturalidade_func}</td>
        </tr>
        <tr class='relatorio'>
            <th>Cargo</th>
            <td>{$cargo_func}</td>
        </tr>
        <tr class='relatorio'>
            <th>Função</th>
            <td>{$funcao_func}</td>
        </tr>
        <tr class='relatorio'>
            <th>Salario</th>
            <td>{$salario_func}</td>
        </tr>
        <tr class='relatorio'>
            <th>Hr. de entrada</th>
            <td>{$entrada_func}</td>
        </tr>
        <tr class='relatorio'>
            <th>Hr. Saida</th>
            <td>{$saida_func}</td>
        </tr>
        <tr class='relatorio'>
            <th>E-mail</th>
            <td>{$email_func}</td>
        </tr>
        <tr class='relatorio'>
            <th>Tel. Celular</th>
            <td>{$celular_func}</td>
        </tr>
        <tr class='relatorio'>
            <th>Tel. Residencial</th>
            <td>{$residencial_func}</td>
        </tr>
        <tr class='relatorio'>
            <th>Status</th>
            <td>{$status_func}</td>
        </tr>
        <tr class='relatorio'>
            <th>Estado</th>
            <td>{$desc_estado}</td>
        </tr>
        <tr class='relatorio'>
            <th>Cidade</th>
            <td>{$desc_cidade}</td>
        </tr>
        <tr class='relatorio'>
            <th>Complemento do Endereço</th>
            <td>{$complementos_fun}</td>
        </tr>
        <tr class='relatorio'>
            <th>Observações</th>
            <td>{$obs_func}</td>
        </tr>";

endforeach;

$html .= "
    </table>
    <script type='text/javascript' src='../_cdn/bootstrap/js/bootstrap.min.css'></script>
";

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