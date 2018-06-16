<?php

require '../_app/Config.inc.php';

$HistCatraca = new Read;
$HistCatraca->FullRead("SELECT registros_catraca.idregistros_catraca, registros_catraca.idaluno_clientes, alunos_cliente.nome_aluno, "
                        . "registros_catraca.hr_entrada_catraca, registros_catraca.hr_saida_catraca, registros_catraca.data_registro "
                        . "FROM registros_catraca "
                        . "INNER JOIN alunos_cliente ON registros_catraca.idaluno_clientes = alunos_cliente.idalunos_cliente");

require 'Relatorios/autoload.inc.php';

use Dompdf\Dompdf;

$html = "<link rel='stylesheet' type='text/css' href='../_cdn/bootstrap/css/bootstrap.min.css'>
        <title>Histórico da Catraca</title>
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
					<label>Histórico da Catraca</label>
				</div>			
			</th>
		</tr>
	</table>
        <table style='background-color: #99ccff; font-size: 10px;' class='table table-striped'>
		<thead style='background-color: black; font-size: 14px;'>
			<tr style='color: white;'>
				<th>ID do Registro</th>
                                <th>Matricula</th>
				<th>Aluno</th>
				<th>Hr. de entrada</th>
				<th>Hr. de saída</th>
				<th>Data do Registro</th>
			</tr>
		</thead>
";
foreach ($HistCatraca->getResult() as $e):
    extract($e);

    $html .= "<tbody>
                    <tr>
                        <td>{$idregistros_catraca}</td>
                        <td>{$idaluno_clientes}</td>
                        <td>{$nome_aluno}</td>
                        <td>{$hr_entrada_catraca}</td>
                        <td>{$hr_saida_catraca}</td>
                        <td>". Check::DataBrasil($data_registro) ."</td>
                    </tr>
	</tbody>
";
endforeach;

$html .= "</table>
        <script type='text/javascript' src='../_cdn/bootstrap/js/bootstrap.min.css'></script>
";

$dompdf = new Dompdf();

$dompdf->loadHtml($html);

$dompdf->set_paper('a4', 'landscape');

$dompdf->render();

$dompdf->stream('Histórico da Catraca.pdf', array('Attachment' => false));
?>
