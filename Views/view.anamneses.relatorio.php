<?php

require '../_app/Config.inc.php';

$RelatorioAnamneses = new Read;
$RelatorioAnamneses->FullRead("SELECT anamneses.idanamneses, anamneses.peso_anamnese, anamneses.altura_anamnese, anamneses.imc_anamnese, anamneses.obs_anamnese, alunos_cliente.nome_aluno
FROM anamneses
INNER JOIN alunos_cliente ON anamneses.idalunos_cliente = alunos_cliente.idalunos_cliente");

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
					<label>Relatório de Anamneses</label>
				</div>			
			</th>
		</tr>
	</table>
        <table style='background-color: #99ccff; font-size: 10px;' class='table table-striped'>
		<thead style='background-color: black; font-size: 14px;'>
			<tr style='color: white;'>
				<th>ID</th>
				<th>Aluno</th>
				<th>Peso</th>
				<th>Altura</th>
				<th>IMC</th>
                                <th>Observações</th>
			</tr>
		</thead>
";

foreach ($RelatorioAnamneses->getResult() as $e):
    extract($e);

    $html .= "<tbody>
                    <tr>
			<td>{$idanamneses}</td>
			<td>{$nome_aluno}</td>
			<td>{$peso_anamnese}</td>
			<td>{$altura_anamnese}</td>
			<td>{$imc_anamnese}</td>
                        <td>{$obs_anamnese}</td>
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

$dompdf->stream("
relatorioAnamneses.pdf
", array(
    "Attachment" => false)
);
?>