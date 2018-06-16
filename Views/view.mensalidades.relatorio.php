<?php

require '../_app/Config.inc.php';

$Mensalidades = new Read;
$Mensalidades->FullRead("SELECT mensalidades.idmensalidade, alunos_cliente.nome_aluno, planos.nome_plano,
        mensalidades.data_mens_pag, mensalidades.status_mens
        FROM mensalidades 
        INNER JOIN alunos_cliente ON mensalidades.idalunos_cliente = alunos_cliente.idalunos_cliente
        INNER JOIN planos ON mensalidades.idplano = planos.idplano
        ORDER BY mensalidades.idmensalidade");

require 'Relatorios/autoload.inc.php';

use Dompdf\Dompdf;

$html = "<link rel='stylesheet' type='text/css' href='../_cdn/bootstrap/css/bootstrap.min.css'>
        <title>Histórico da Mensalidades</title>
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
					<label>Mensalidades</label>
				</div>			
			</th>
		</tr>
	</table>
        <table style='background-color: #99ccff; font-size: 10px;' class='table table-striped'>
		<thead style='background-color: black; font-size: 14px;'>
			<tr style='color: white;'>
				<th>ID do Registro</th>
				<th>Aluno</th>
                                <th>Plano</th>
				<th>Data de Pagamento</th>
				<th>Status</th>				
			</tr>
		</thead>
";
foreach ($Mensalidades->getResult() as $e):
    extract($e);

    $html .= "<tbody>
                    <tr>
                        <td>{$idmensalidade}</td>
                        <td>{$nome_aluno}</td>
                        <td>{$nome_plano}</td>
                        <td>". Check::DataBrasil($data_mens_pag)."</td>
                        <td>{$status_mens}</td>
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

$dompdf->stream('Mensalidades.pdf', array('Attachment' => false));
?>
