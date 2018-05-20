<?php
session_start();
if (!$_SESSION['logado']):
    session_destroy();
    header('Location: view.login');
endif;
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
            <canvas id="" class="grafico-alunos" width="5" height="5"></canvas>
            <h3>Total: 320</h3>
        </div>
        <div class="item alunos-presentes">         
            <h4>Total de Alunos Presentes</h4>
            <p><b>50</b></p>
            <h2>19/05/2018</h2>        
        </div>
        <div class="item mensalidades">         
            <canvas id="" class="receita-mensalidades" width="5" height="5"></canvas>
            <h3>Media de R$ 800,00</h3>
        </div>
        <div class="item vendas">         
            <canvas id="" class="ranking-vendas" width="5" height="5"></canvas>
        </div>
        <div class="item usuario">         
            <canvas id="" class="vendas-usuario" width="5" height="5"></canvas>
        </div>
        <div class="item novo">         
            
        </div>
    </div>
    
</div>