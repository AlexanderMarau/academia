<!--MENU:-->
<?php require REQUIRE_PATH . '/menu.php'; ?>

<div class="col-md-10 modals">
    <br>
    <h2>Histórico da Catraca</h2>

    <div class="col-md-12" align='right'>
        <form action="" method="POST">
            <div class="form-group col-md-4">
                <input type="text" placeholder="Pesquisar" class="form-control pesquisar pesquisar-histC">
            </div>
        </form>
        <a href="http://localhost/academia/Views/view.hist.catraca.relatorio.php" target="_blank" class="relatorio-geral"><button class="btn btn-warning"><i class="glyphicon glyphicon-print"></i> Relátorio Geral</button></a>
    </div>

    <div class="form-group col-md-12 mensagens-retorno">

    </div>

    <table class="table table-striped modal-table">
        <thead>
            <tr>
                <th>ID do Registro</th>
                <th>Matricula</th>
                <th>Aluno</th>
                <th>Hr. de entrada</th>
                <th>Hr. de saída</th>
                <th>Data do Registro</th>
            </tr>
        </thead>
        <tbody class="j-result-historicoC">
            <?php
                $ReadHist = new Read;
                $ReadHist->FullRead("SELECT registros_catraca.idregistros_catraca, registros_catraca.idaluno_clientes, alunos_cliente.nome_aluno, "
                        . "registros_catraca.hr_entrada_catraca, registros_catraca.hr_saida_catraca, registros_catraca.data_registro "
                        . "FROM registros_catraca "
                        . "INNER JOIN alunos_cliente ON registros_catraca.idaluno_clientes = alunos_cliente.idalunos_cliente");
                foreach ($ReadHist->getResult() as $e):
                    extract($e);
                    echo "<tr>".
                            "<td>{$idregistros_catraca}</td>".
                            "<td>{$idaluno_clientes}</td>".
                            "<td>{$nome_aluno}</td>".
                            "<td>{$hr_entrada_catraca}</td>".
                            "<td>{$hr_saida_catraca}</td>".
                            "<td>". Check::DataBrasil($data_registro) ."</td>".
                            "</tr>";
                endforeach;
            ?>
        </tbody>
    </table>
</div>

