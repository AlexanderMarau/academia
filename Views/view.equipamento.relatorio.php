<?php

require '../_app/Config.inc.php';

$RelatorioEquip = new Read;
$RelatorioEquip->FullRead("SELECT equipamentos.idequipamentos, equipamentos.nome_equip, equipamentos.data_equip_entr, equipamentos.data_equip_saida, equipamentos.preco_equip_entr, equipamentos.marca_equip, equipamentos.funcionalidade_equip, equipamentos.data_manutencao_equip, fornecedores.nome_forn
FROM equipamentos
INNER JOIN fornecedores ON equipamentos.idfornecedores = fornecedores.idfornecedores");

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
					<label>Relatório de Equipamentos</label>
				</div>			
			</th>
		</tr>
	</table>
        <table style=' font-size: 10px;' class='table table-striped'>
		<thead style='background-color: black; font-size: 12px;'>
			<tr style='color: white;'>
				<th>ID</th>
				<th>Nome do equiapamento</th>
				<th>Fornecedor</th>
				<th>Data de entrada</th>
				<th>Data de saida</th>
                                <th>Preço de entrada</th>
                                <th>Marca</th>
                                <th>Funcionalidade</th>
                                <th>Data de manutenção</th>
			</tr>
		</thead>
";

foreach ($RelatorioEquip->getResult() as $e):

    extract($e);

    $html .= "<tbody>
			<tr>
				<td>{$idequipamentos}</td>
				<td>{$nome_equip}</td>
				<td>{$nome_forn}</td>
				<td>{$data_equip_entr}</td>
				<td>{$data_equip_saida}</td>
                                <td>{$preco_equip_entr}</td>
                                <td>{$marca_equip}</td>
                                <td>{$funcionalidade_equip}</td>
                                <td>{$data_manutencao_equip}</td>
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

$dompdf->stream("
relatorioEquipamento.pdf
", array(
    "Attachment" => false)
);
?>