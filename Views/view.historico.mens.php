<!--MENU:-->
<?php require REQUIRE_PATH . '/menu.php'; ?>

<div class="col-md-10 modals">
    <br>
    <h2>Histórico de Mensalidades</h2>

    <div class="col-md-12" align='right'>
        <form action="" method="POST">
            <div class="form-group col-md-4">
                <input type="text" placeholder="Pesquisar" class="form-control pesquisar pesquisar-hist">
            </div>
        </form>
        <a href="http://localhost/academia/Views/view.historico-mens.relatorio.php" target="_blank" class="relatorio-geral"><button class="btn btn-warning"><i class="glyphicon glyphicon-print"></i> Relátorio Geral</button></a>
    </div>

    <div class="form-group col-md-12 mensagens-retorno">

    </div>

    <table class="table table-striped modal-table">
        <thead>
            <tr>
                <th>id</th>
                <th>Aluno</th>
                <th>Plano</th>
                <th>Data de Pagamento</th>
                <th>Valor Pago</th>
                <th></th>
            </tr>
        </thead>
        <tbody class="j-result-historico">
            <?php
            $ReadHist = new Read;
            $ReadHist->FullRead("SELECT historicos_mensalidades.idhist_pag, alunos_cliente.nome_aluno, planos.nome_plano, historicos_mensalidades.data_mens_pag, historicos_mensalidades.valor_pag " .
                    "FROM historicos_mensalidades " .
                    "INNER JOIN alunos_cliente ON historicos_mensalidades.idalunos_cliente = alunos_cliente.idalunos_cliente " .
                    "INNER JOIN planos ON historicos_mensalidades.idplano = planos.idplano
                    ORDER BY historicos_mensalidades.data_mens_pag DESC");

            foreach ($ReadHist->getResult() as $historico):
                extract($historico);
                echo "<tr id='{$idhist_pag}'>" .
                "<td>{$idhist_pag}</td>" .
                "<td>{$nome_aluno}</td>" .
                "<td>{$nome_plano}</td>" .
                "<td>" . Check::DataBrasil($data_mens_pag) . "</td>" .
                "<td>{$valor_pag}</td>" .
                "<td>".
                    "<a href='http://localhost/academia/Views/view.mensalidade.comprovante.php?idhist_pag={$idhist_pag}' target='_blank'><button class='btn btn-warning btn-xs open-imprimir'><i class='glyphicon glyphicon-print'></i></button></a>".
                "</td>".
                "</tr>";
            endforeach;
            ?>
        </tbody>
    </table>
</div>

