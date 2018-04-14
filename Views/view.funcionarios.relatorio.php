<?php

require '../_app/Config.inc.php';

$RelatorioFuncionarios = new Read;
$RelatorioFuncionarios->FullRead("SELECT funcionarios.idfuncionarios, funcionarios.nome_func, funcionarios.nome_pai_func, 
    funcionarios.nome_mae_func, funcionarios.dt_nasc_func, funcionarios.rg_func, 
    funcionarios.cpf_func, funcionarios.pis_func, funcionarios.estado_civil_func, funcionarios.cargo_func, funcionarios.email_func, 
    funcionarios.celular_func, funcionarios.status_func
FROM funcionarios");

require 'Relatorios/autoload.inc.php';

use Dompdf\Dompdf;

$html = "<link rel='stylesheet' type='text/css' href='../_cdn/bootstrap/css/bootstrap.min.css'>
	<table class='table' style='background-color: #99ccff;'>
		<tr>
			<th>
				<img style='width: 220px; height: 200px;' src='img/logoAcademia.png'>
			</th>
			<th style='width: 100%; background-color: #99ccff;'>
				<div style='color: white;'>
					<p>Academia Performance Fit</p>
					<p>Endereço:Rua Dr. Soares QD. 05, LT. 48</p>
					<p>Bairro: Colina Azul</p>
					<p>Municipio: Aparecida de Goiânia GO CEP 00000-000</p>
				</div>	
				<div style='margin-top: 20px; font-size: 30px; color: black;'> 
					<label>Relatório de Funcionários</label>
				</div>			
			</th>
		</tr>
	</table>
        <table style=' font-size: 10px;' class='table table-striped'>
		<thead style='background-color: black; font-size: 12px;'>
			<tr style='color: white;'>
				<th>ID</th>
				<th>Nome</th>
				<th>Data de nascimento</th>
				<th>RG</th>
				<th>CPF</th>
                                <th>PIS</th>
                                <th>Estado Civil</th>
                                <th>Cargo</th>
                                <th>E-mail</th>
                                <th>Tel. Celular</th>
                                <th>Status</th>
			</tr>
		</thead>
";

foreach ($RelatorioFuncionarios->getResult() as $e):

    extract($e);

    $html .= "<tbody>
			<tr>
				<td>{$idfuncionarios}</td>
				<td>{$nome_func}</td>
				<td>{$dt_nasc_func}</td>
				<td>{$rg_func}</td>
				<td>{$cpf_func}</td>
                                <td>{$pis_func}</td>
                                <td>{$estado_civil_func}</td>
                                <td>{$cargo_func}</td>
                                <td>{$email_func}</td>
                                <td>{$celular_func}</td>
                                <td>{$status_func}</td>
			</tr>
	</tbody>
";

endforeach;

$html .= "</table>
        <script type='text/javascript' src='../_cdn/bootstrap/js/bootstrap.min.css'></script>
";

$dompdf = new Dompdf();

$dompdf->loadHtml($html);

$dompdf->set_paper('a4','landscape');

$dompdf->render();

$dompdf->stream("
relatorioFuncionarios.pdf
", array(
    "Attachment" => false)
);
?>