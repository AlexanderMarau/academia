<?php

require '../_app/Config.inc.php';

$RelatorioProdutos = new Read;
$RelatorioProdutos->FullRead("SELECT produtos.idprodutos, produtos.nome_prod, produtos.peso_prod, produtos.cor_prod, produtos.tamanho_prod, produtos.numero_prod, produtos.con_indicacao_prod, produtos.dt_entr_prod, produtos.marca_prod, produtos.fabricante_prod, produtos.validade_prod, produtos.obs_prod, cat_produto.descricao, fornecedores.nome_forn, estoq_prod.quant_estoque 
FROM produtos 
INNER JOIN cat_produto ON cat_produto.idcate_produto = produtos.idcate_produto 
INNER JOIN fornecedores ON fornecedores.idfornecedores = produtos.idfornecedores 
INNER JOIN estoq_prod ON estoq_prod.idprodutos = produtos.idprodutos");


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
					<label>Relatório de Produtos</label>
				</div>			
			</th>
		</tr>
	</table>
        <table style=' font-size: 10px;' class='table table-striped'>
		<thead style='background-color: black; font-size: 12px;'>
			<tr style='color: white;'>
				<th>ID</th>
				<th>Produto</th>
				<th>Categoria</th>
				<th>Fornecedor</th>
				<th>Peso</th>
                                <th>Cor</th>
                                <th>Tamanho</th>
                                <th>Número</th>
                                <th>Contra indicações</th>
                                <th>Data de entrada</th>
                                <th>Marca</th>
                                <th>Fabricante</th>
                                <th>Data de validade</th>
                                <th>Qtd. Estoque</th>
                                <th>Obs.</th>
			</tr>
		</thead>
";
foreach ($RelatorioProdutos->getResult() as $e):
    extract($e);

    $html .= "<tbody>
			<tr>
				<td>{$idprodutos}</td>
				<td>{$nome_prod}</td>
				<td>{$descricao}</td>
				<td>{$nome_forn}</td>
                                <td>{$peso_prod}</td>
                                <td>{$cor_prod}</td>
                                <td>{$tamanho_prod}</td>
                                <td>{$numero_prod}</td>
                                <td>{$con_indicacao_prod}</td>
                                <td>{$dt_entr_prod}</td>
                                <td>{$marca_prod}</td>
                                <td>{$fabricante_prod}</td>
                                <td>{$validade_prod}</td>
                                <td>{$quant_estoque}</td>
                                <td>{$obs_prod}</td>
			</tr>
	</tbody>";

endforeach;

$html .= "</table>
        <script type='text/javascript' src='../_cdn/bootstrap/js/bootstrap.min.css'></script>
";

$dompdf = new Dompdf();

$dompdf->loadHtml($html);

$dompdf->set_paper('a4', 'landscape');

$dompdf->render();

$dompdf->stream("
relatorioProdutos.pdf
", array(
    "Attachment" => false)
);
?>