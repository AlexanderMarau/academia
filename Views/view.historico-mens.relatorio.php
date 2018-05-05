<?php

require '../_app/Config.inc.php';

$RelatorioHist = new Read;
$RelatorioHist->FullRead("SELECT historicos_mensalidades.idhist_pag, alunos_cliente.nome_aluno, planos.nome_plano, historicos_mensalidades.data_mens_pag, historicos_mensalidades.valor_pag " .
        "FROM historicos_mensalidades " .
        "INNER JOIN alunos_cliente ON historicos_mensalidades.idalunos_cliente = alunos_cliente.idalunos_cliente " .
        "INNER JOIN planos ON historicos_mensalidades.idplano = planos.idplano");

require 'Relatorios/autoload.inc.php';

use Dompdf\Dompdf;

$html = "<link rel='stylesheet' type='text/css' href='../_cdn/bootstrap/css/bootstrap.min.css'>
        <title>Histórico de Mensalidades</title>
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
					<label>Histórico de Mensalidades</label>
				</div>			
			</th>
		</tr>
	</table>
        <table style='background-color: #99ccff; font-size: 10px;' class='table table-striped'>
		<thead style='background-color: black; font-size: 14px;'>
			<tr style='color: white;'>
				<th>ID</th>
				<th>Aluno</th>
				<th>Plano</th>
				<th>Data de Pagamento</th>
				<th>Valor Pago</th>
			</tr>
		</thead>
";
foreach ($RelatorioHist->getResult() as $e):
    extract($e);

    $html .= "<tbody>
                    <tr>
                        <td>{$idhist_pag}</td>
                        <td>{$nome_aluno}</td>
                        <td>{$nome_plano}</td>
                        <td>{$data_mens_pag}</td>
                        <td>{$valor_pag}</td>
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

$dompdf->stream('Histórico de Mensalidades.pdf', array('Attachment' => false));
?>
