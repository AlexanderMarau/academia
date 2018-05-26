<?php
session_start();
if (!$_SESSION['logado']):
    session_destroy();
    header('Location: view.login');
endif;

date_default_timezone_set('America/Sao_Paulo');
$data = date("d/m/Y");
?>
<!--MENU:-->
<?php require REQUIRE_PATH . '/menu.php'; ?>
<!--FIM MENU-->
<!-- Wrapper for slides -->
<div class="col-md-10 modals">

    <h2>Academia Performance Fit</h2>
    <hr>
    <div class="painel">
        <div class="item total-alunos">
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
            <h3>Total de Alunos: <?php echo $totalAlunos->getRowCount(); ?></h3>
        </div>

        <div class="item alunos-presentes">         
            <h4>Total de Alunos Presentes</h4>
            <?php
            //SQL de alunos presentes na academia do dia:
            $alunosPresentes = new Read;
            $alunosPresentes->FullRead("SELECT hr_entrada_catraca, hr_saida_catraca, data_registro FROM registros_catraca WHERE hr_saida_catraca IS NULL AND data_registro = '2018-05-25'");
            $alunosPresentes->getResult();
            echo "<p><b>{$alunosPresentes->getRowCount()}</b></p>";
            echo "<h2>{$data}</h2>";
            ?>  
        </div>

        <div class="item mensalidades">         
            <canvas id="" class="receita-mensalidades" width="5" height="5"></canvas>
            <?php
            //Consulta de Vendas em Janeiro:
            $jan = new Read;
            $jan->FullRead("SELECT SUM(valor_total) AS 'TotalJan' FROM vendas WHERE extract(month from data_venda) = 1");
            foreach ($jan->getResult() as $e):
                extract($e);
            endforeach;
            //Consulta de Vendas em Fevereiro:
            $fev = new Read;
            $fev->FullRead("SELECT SUM(valor_total) AS 'TotalFev' FROM vendas WHERE extract(month from data_venda) = 2");
            foreach ($fev->getResult() as $e):
                extract($e);
            endforeach;
            //Consulta de Vendas em Março:
            $mar = new Read;
            $mar->FullRead("SELECT SUM(valor_total) AS 'TotalMar' FROM vendas WHERE extract(month from data_venda) = 3");
            foreach ($mar->getResult() as $e):
                extract($e);
            endforeach;
            //Consulta de Vendas em Abril:
            $abr = new Read;
            $abr->FullRead("SELECT SUM(valor_total) AS 'TotalAbr' FROM vendas WHERE extract(month from data_venda) = 4");
            foreach ($abr->getResult() as $e):
                extract($e);
            endforeach;
            //Consulta de Vendas em Maio:
            $mai = new Read;
            $mai->FullRead("SELECT SUM(valor_total) AS 'TotalMai' FROM vendas WHERE extract(month from data_venda) = 5");
            foreach ($mai->getResult() as $e):
                extract($e);
            endforeach;
            //Consulta de Vendas em Junho:
            $jun = new Read;
            $jun->FullRead("SELECT SUM(valor_total) AS 'TotalJun' FROM vendas WHERE extract(month from data_venda) = 6");
            foreach ($jun->getResult() as $e):
                extract($e);
            endforeach;
            //SQL do Total arrecadado de mensalidades:
            $valorReceitas = new Read;
            $valorReceitas->FullRead("SELECT SUM(valor_pag) AS total FROM historicos_mensalidades");
            foreach ($valorReceitas->getResult() as $e):
                extract($e);
                echo "<h4>Total em Receitas R$ {$total}</h4>";
            endforeach;
            ?>
            <input type='hidden' value="<?php echo $TotalJan; ?>" name='jan' id='jan'>
            <input type='hidden' value="<?php echo $TotalFev; ?>" name='fev' id='fev'>
            <input type='hidden' value="<?php echo $TotalMar; ?>" name='mar' id='mar'>
            <input type='hidden' value="<?php echo $TotalAbr; ?>" name='abr' id='abr'>
            <input type='hidden' value="<?php echo $TotalMai; ?>" name='mai' id='mai'>
            <input type='hidden' value="<?php echo $TotalJun; ?>" name='jun' id='jun'>
        </div>

        <div class="item vendas">         
            <canvas id="" class="ranking-vendas" width="5" height="5"></canvas>
        </div>

        <div class="item usuario">         
            <canvas id="" class="qtd-vendas" width="5" height="5"></canvas>
            <?php
            //SQL que consulta quantidade total de vendas:
            $qtdVendas = new Read;
            $qtdVendas->FullRead("SELECT idvendas FROM vendas");
            $qtdVendas->getResult();
            //
            $marV = new Read;
            $marV->FullRead("SELECT idvendas FROM vendas WHERE extract(month from data_venda) = 3");
            $marV->getResult();
            ?>
            <input type="hidden" value="" name="janV" id="janV">
            <input type="hidden" value="" name="fevV" id="fevV">
            <input type="hidden" value="<?php echo $marV->getRowCount(); ?>" name="marV" id="marV">
            
            <h4>Quantidade de Vendas: <?php echo $qtdVendas->getRowCount(); ?></h4>
        </div>

        <div class="item novo">         
            <canvas id="" class="total-vendas" width="5" height="5"></canvas>
                <?php
                $receitasVendas = new Read;
                $receitasVendas->FullRead("SELECT SUM(valor_total) AS total FROM vendas");
                foreach ($receitasVendas->getResult() as $e):
                    extract($e);
                    echo "<h4>Total em Vendas: R$ {$total}</h4>";
                endforeach;
                ?>
        </div>
    </div>

</div>