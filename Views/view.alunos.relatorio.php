<?php

require '../_app/Config.inc.php';

$RelatorioAlunos = new Read;
$RelatorioAlunos->FullRead("SELECT "
        . "alunos_cliente.idalunos_cliente, "
        . "alunos_cliente.nome_aluno, "
        . "alunos_cliente.cpf_aluno, "
        . "alunos_cliente.email_aluno, "
        . "alunos_cliente.celular_aluno "
        . "FROM alunos_cliente");

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
				<div style='margin-top: 20px; font-size: 40px; color: black;'> 
					<label>Relatório de Alunos</label>
				</div>			
			</th>
		</tr>
	</table>
        <table style='background-color: #99ccff; font-size: 10px;' class='table table-striped'>
		<thead style='background-color: black; font-size: 14px;'>
			<tr style='color: white;'>
				<th>Matricula</th>
				<th>Nome</th>
				<th>CPF</th>
				<th>E-mail</th>
				<th>Celular</th>
			</tr>
		</thead>
";
foreach ($RelatorioAlunos->getResult() as $e):
    extract($e);

    $html .= "<tbody>
			<tr>
				<td>{$idalunos_cliente}</td>
				<td>{$nome_aluno}</td>
				<td>{$cpf_aluno}</td>
				<td>{$email_aluno}</td>
				<td>{$celular_aluno}</td>
			</tr>
	</tbody>
";
endforeach;

$html .= "</table>
        <script type='text/javascript' src='../_cdn/bootstrap/js/bootstrap.min.css'></script>
";

$dompdf = new Dompdf();

$dompdf->loadHtml($html);

$dompdf->set_paper('a4');

$dompdf->render();

$dompdf->stream('Relatorio de Alunos.pdf', array('Attachment' => false));
?>