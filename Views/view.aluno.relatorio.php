<?php

require '../_app/Config.inc.php';

$idalunos_cliente = $_GET['idalunos_cliente'];

$RelatorioAluno = new Read;
$RelatorioAluno->FullRead("SELECT alunos_cliente.idalunos_cliente, alunos_cliente.nome_aluno, alunos_cliente.cpf_aluno, alunos_cliente.rg_aluno, alunos_cliente.nome_mae, alunos_cliente.nome_pai, alunos_cliente.email_aluno, alunos_cliente.celular_aluno, alunos_cliente.residencial_aluno, alunos_cliente.data_nascimento_aluno, alunos_cliente.status_aluno, alunos_cliente.obs_aluno, endereco_aluno.complementos_aluno, cidade.desc_cidade,  estado.desc_estado
FROM alunos_cliente
INNER JOIN endereco_aluno ON alunos_cliente.idendereco_aluno = endereco_aluno.idendereco_aluno
INNER JOIN cidade ON endereco_aluno.idendereco_aluno = cidade.idcidade
INNER JOIN estado ON cidade.idestado = estado.idestado
WHERE alunos_cliente.idalunos_cliente = {$idalunos_cliente}");

require 'Relatorios/autoload.inc.php';

use Dompdf\Dompdf;

$html = "
    <link rel='stylesheet' type='text/css' href='../_cdn/bootstrap/css/bootstrap.min.css'>
    <style>
        .relatorio th{
            color: black;
            font-size: 16px;
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
                    <label>Relatório do Aluno</label>
                </div>			
            </th>
        </tr>
    </table>
    <table style='background-color: whitesmoke; font-size: 12px;' class='table'>
";

foreach ($RelatorioAluno->getResult() as $e):
    extract($e);

    $html .= "
        <tr class='relatorio'>
            <th>Matricula</th>
            <td>{$idalunos_cliente}</td>
        </tr>
        <tr class='relatorio'>
            <th>Nome</th>
            <td>{$nome_aluno}</td>
        </tr>
        <tr class='relatorio'>
            <th>CPF</th>
            <td>{$cpf_aluno}</td>
        </tr>
        <tr class='relatorio'>
            <th>RG</th>
            <td>{$rg_aluno}</td>
        </tr>
        <tr class='relatorio'>
            <th>Nome da Mãe</th>
            <td>{$nome_mae}</td>
        </tr>
        <tr class='relatorio'>
            <th>Nome da Pai</th>
            <td>{$nome_pai}</td>
        </tr>
        <tr class='relatorio'>
            <th>E-mail</th>
            <td>{$email_aluno}</td>
        </tr>
        <tr class='relatorio'>
            <th>Celular</th>
            <td>{$celular_aluno}</td>
        </tr>
        <tr class='relatorio'>
            <th>Residencial</th>
            <td>{$residencial_aluno}</td>
        </tr>
        <tr class='relatorio'>
            <th>Data de Nascimento</th>
            <td>{$data_nascimento_aluno}</td>
        </tr>
        <tr class='relatorio'>
            <th>Status</th>
            <td>{$status_aluno}</td>
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
            <td>{$complementos_aluno}</td>
        </tr>
        <tr class='relatorio'>
            <th>Observações</th>
            <td>{$obs_aluno}</td>
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
relatorioAluno.pdf
", array(
    "Attachment" => false)
);
?>