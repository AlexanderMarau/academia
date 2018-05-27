<?php
session_start();
if (!$_SESSION['logado']):
    session_destroy();
    header('Location: view.login');
endif;

date_default_timezone_set('America/Sao_Paulo');
$data = date("Y/m/d");
$dataBR = date("d/m/Y");
$ano = date("Y");
?>
<!--MENU:-->
<?php require REQUIRE_PATH . '/menu.php'; ?>
<!--FIM MENU-->
<!-- Wrapper for slides -->
<div class="col-md-10 modals">

    <h2 class="tituloAcademia">Academia Performance Fit</h2>
    <hr>
    <div class="panel-group">
        <div class="panel panel-estoque">
            <?php
            //SQL que mostra a quantidade de itens em estoque:
            $qtdEstoque = new Read;
            $qtdEstoque->FullRead("SELECT SUM(quant_estoque) AS 'TotalEstoque' FROM estoq_prod");
            foreach ($qtdEstoque->getResult() as $e):
                extract($e);
            endforeach;
            ?>
            <div class="panel-heading"><b>Quantidade de itens em Estoque</b></div>
            <div class="panel-body"><i class="glyphicon glyphicon-folder-close"></i> <?php echo $TotalEstoque; ?></div>
        </div>
    </div>
    <div class="panel-group">
        <div class="panel panel-alunosP">
            <?php
            $alunosPresentes = new Read;
            $alunosPresentes->FullRead("SELECT hr_entrada_catraca, hr_saida_catraca, data_registro FROM registros_catraca WHERE hr_saida_catraca IS NULL AND data_registro = '{$data}'");
            $alunosPresentes->getResult();
            ?>
            <div class="panel-heading"><b>Total de Alunos Presentes</b></div>
            <div class="panel-body"><i class="glyphicon glyphicon-ok"></i> <?php echo $alunosPresentes->getRowCount(); ?></div>
        </div>
    </div>
    
    <div class="painel">

        <div class="item alunoAI">
            <?php
            //SQL de consulta de alunos Ativos:
            $AlunosAtivos = new Read;
            $AlunosAtivos->FullRead("select idalunos_cliente FROM alunos_cliente WHERE status_aluno = 'Ativo'");
            $AlunosAtivos->getResult();
            //SQL de consulta de alunos Inativos:
            $AlunosInativos = new Read;
            $AlunosInativos->FullRead("select idalunos_cliente FROM alunos_cliente WHERE status_aluno = 'Inativo'");
            $AlunosInativos->getResult();
            ?>
            <input type="hidden" value="<?php echo $AlunosAtivos->getRowCount(); ?>" name="alunosA" id="ativos">
            <input type="hidden" value="<?php echo $AlunosInativos->getRowCount(); ?>" name="alunosI" id="inativos">
            <canvas id="" class="grafico-alunos" width="5" height="5"></canvas>
            <?php
            //SQL do total de Alunos:
            $totalAlunos = new Read;
            $totalAlunos->FullRead("SELECT * FROM alunos_cliente");
            $totalAlunos->getResult();
            ?>
            <h3 class="txtAI"><b>Total de Alunos: <?php echo $totalAlunos->getRowCount(); ?></b></h3>
        </div>

        

        <div class="item vendasMes">         
            <canvas id="" class="qtd-vendas" width="5" height="5"></canvas>
            <?php
            //SQL que conta a quantidade de vendas por mês:
            for ($i = 1; $i <= 12; $i++):
                $receitasV = new Read;
                $receitasV->FullRead("SELECT COUNT(idvendas) AS 'VendasMes{$i}' FROM vendas WHERE extract(month from data_venda) = {$i} AND extract(year from data_venda) = {$ano}");
                foreach ($receitasV->getResult() as $e):
                    extract($e);
                endforeach;
            endfor;

            //SQL que consulta quantidade total de vendas:
            $qtdVendas = new Read;
            $qtdVendas->FullRead("SELECT idvendas FROM vendas WHERE extract(year from data_venda) = {$ano}");
            $qtdVendas->getResult();
            ?>
            <input type='hidden' value="<?php echo $VendasMes1; ?>" name='janM' id='janV'>
            <input type='hidden' value="<?php echo $VendasMes2; ?>" name='fevM' id='fevV'>
            <input type='hidden' value="<?php echo $VendasMes3; ?>" name='marM' id='marV'>
            <input type='hidden' value="<?php echo $VendasMes4; ?>" name='abrM' id='abrV'>
            <input type='hidden' value="<?php echo $VendasMes5; ?>" name='maiM' id='maiV'>
            <input type='hidden' value="<?php echo $VendasMes6; ?>" name='junM' id='junV'>
            <input type='hidden' value="<?php echo $VendasMes7; ?>" name='julM' id='julV'>
            <input type='hidden' value="<?php echo $VendasMes8; ?>" name='agtM' id='agtV'>
            <input type='hidden' value="<?php echo $VendasMes9; ?>" name='setM' id='setV'>
            <input type='hidden' value="<?php echo $VendasMes10; ?>" name='outM' id='outV'>
            <input type='hidden' value="<?php echo $VendasMes11; ?>" name='novM' id='novV'>
            <input type='hidden' value="<?php echo $VendasMes12; ?>" name='dezM' id='dezV'>

            <h4 class="txtVenda"><b>Qtd. Vendas: <?php echo $qtdVendas->getRowCount(); ?></b></h4>
        </div>

        <div class="item receitaVenda">         
            <canvas id="" class="total-vendas" width="5" height="5"></canvas>
            <?php
            //SQL que soma o valor arrecadado de cada mês em vendas:
            for ($i = 1; $i <= 12; $i++):
                $receitaVendaM = new Read;
                $receitaVendaM->FullRead("SELECT SUM(valor_total) AS 'VendasTM{$i}' FROM vendas WHERE extract(month from data_venda) = {$i} AND extract(year from data_venda) = {$ano}");
                foreach ($receitaVendaM->getResult() as $e):
                    extract($e);
                endforeach;
            endfor;
            //SQL que soma valor arrecado do ano em vendas:
            $receitasVendas = new Read;
            $receitasVendas->FullRead("SELECT SUM(valor_total) AS total FROM vendas WHERE extract(year from data_venda) = {$ano}");
            foreach ($receitasVendas->getResult() as $e):
                extract($e);
                echo "<h4 class='txtReceita'><b>Total em Vendas: R$ {$total}</b></h4>";
            endforeach;
            ?>
            <input type='hidden' value="<?php echo $VendasTMM1; ?>" name='janRV' id='janRV'>
            <input type='hidden' value="<?php echo $VendasTM2; ?>" name='fevRM' id='fevRV'>
            <input type='hidden' value="<?php echo $VendasTM3; ?>" name='marRM' id='marRV'>
            <input type='hidden' value="<?php echo $VendasTM4; ?>" name='abrRM' id='abrRV'>
            <input type='hidden' value="<?php echo $VendasTM5; ?>" name='maiRM' id='maiRV'>
            <input type='hidden' value="<?php echo $VendasTM6; ?>" name='junRM' id='junRV'>
            <input type='hidden' value="<?php echo $VendasTM7; ?>" name='julRM' id='julRV'>
            <input type='hidden' value="<?php echo $VendasTM8; ?>" name='agtRM' id='agtRV'>
            <input type='hidden' value="<?php echo $VendasTM9; ?>" name='setRM' id='setRV'>
            <input type='hidden' value="<?php echo $VendasTM10; ?>" name='outRM' id='outRV'>
            <input type='hidden' value="<?php echo $VendasTM11; ?>" name='novRM' id='novRV'>
            <input type='hidden' value="<?php echo $VendasTM12; ?>" name='dezRM' id='dezRV'>
        </div>
        
        <div class="item receitaMensalidade">         
            <canvas id="" class="receita-mensalidades" width="5" height="5"></canvas>
            <?php
            //Laço que pega consulta de todos os meses:
            for ($i = 1; $i <= 12; $i++):
                $receitas = new Read;
                $receitas->FullRead("SELECT SUM(valor_pag) AS 'TotalMes{$i}' FROM historicos_mensalidades WHERE extract(month from data_mens_pag) = {$i} AND extract(year from data_mens_pag) = {$ano}");
                foreach ($receitas->getResult() as $e):
                    extract($e);
                endforeach;
            endfor;

            //SQL do Total arrecadado de mensalidades:
            $valorReceitas = new Read;
            $valorReceitas->FullRead("SELECT SUM(valor_pag) AS total FROM historicos_mensalidades WHERE extract(year from data_mens_pag) = {$ano}");
            foreach ($valorReceitas->getResult() as $e):
                extract($e);
                echo "<h4 class='txtReceita'><b>Total em Receitas R$ {$total}</b></h4>";
            endforeach;
            ?>
            <input type='hidden' value="<?php echo $TotalMes1; ?>" name='janM' id='janM'>
            <input type='hidden' value="<?php echo $TotalMes2; ?>" name='fevM' id='fevM'>
            <input type='hidden' value="<?php echo $TotalMes3; ?>" name='marM' id='marM'>
            <input type='hidden' value="<?php echo $TotalMes4; ?>" name='abrM' id='abrM'>
            <input type='hidden' value="<?php echo $TotalMes5; ?>" name='maiM' id='maiM'>
            <input type='hidden' value="<?php echo $TotalMes6; ?>" name='junM' id='junM'>
            <input type='hidden' value="<?php echo $TotalMes7; ?>" name='julM' id='julM'>
            <input type='hidden' value="<?php echo $TotalMes8; ?>" name='agtM' id='agtM'>
            <input type='hidden' value="<?php echo $TotalMes9; ?>" name='setM' id='setM'>
            <input type='hidden' value="<?php echo $TotalMes10; ?>" name='outM' id='outM'>
            <input type='hidden' value="<?php echo $TotalMes11; ?>" name='novM' id='novM'>
            <input type='hidden' value="<?php echo $TotalMes12; ?>" name='dezM' id='dezM'>
        </div>

    </div>

</div>