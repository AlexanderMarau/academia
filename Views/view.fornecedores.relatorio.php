<?php

require '../_app/Config.inc.php';

$RelatorioFornecedores = new Read;
$RelatorioFornecedores->FullRead("SELECT fornecedores.idfornecedores, fornecedores.nome_forn, fornecedores.cnpj_cpf_forn, fornecedores.nome_fantasia_forn, fornecedores.email_forn, fornecedores.telefone_forn, estado.desc_estado, cidade.desc_cidade, endereco_fornecedor.complementos_forn
FROM fornecedores
INNER JOIN endereco_fornecedor ON fornecedores.idendereco_forn = endereco_fornecedor.idendereco_forn
INNER JOIN cidade ON endereco_fornecedor.idcidade = cidade.idcidade
INNER JOIN estado ON endereco_fornecedor.idestado = estado.idestado");

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
					<label>Relatório de Fornecedores</label>
				</div>			
			</th>
		</tr>
	</table>
        <table style=' font-size: 10px;' class='table table-striped'>
		<thead style='background-color: black; font-size: 12px;'>
			<tr style='color: white;'>
				<th>ID</th>
				<th>Nome</th>
				<th>CNPJ/CPF</th>
				<th>Nome fantasia</th>
				<th>E-mail</th>
                                <th>Telefone</th>
                                <th>Estado</th>
                                <th>Cidade</th>
                                <th>Complemento do endereço</th>
			</tr>
		</thead>
";

foreach ($RelatorioFornecedores->getResult() as $e):

    extract($e);
    $html .= "<tbody>
			<tr>
				<td>{$idfornecedores}</td>
				<td>{$nome_forn}</td>
				<td>{$cnpj_cpf_forn}</td>
				<td>{$nome_fantasia_forn}</td>
				<td>{$email_forn}</td>
                                <td>{$telefone_forn}</td>
                                <td>{$desc_estado}</td>
                                <td>{$desc_cidade}</td>
                                <td>{$complementos_forn}</td>
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
relatorioAnamnese.pdf
", array(
    "Attachment" => false)
);
?>