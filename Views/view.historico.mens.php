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
        <a href="http://localhost/academia/Views/view.historico.relatorio.php" target="_blank" class="relatorio-geral"><button class="btn btn-warning"><i class="glyphicon glyphicon-print"></i> Relátorio Geral</button></a>
    </div>

    <div class="form-group col-md-12 mensagens-retorno">
        <br>
        <div class='alert alert-success'>
            <a href="#" class="close" data-dismiss="alert" arua-label="close">x</a>
            Cadastro realizado com sucesso!
        </div>
    </div>

    <div class="col-md-12 modal-create">
        <div class="container"><h5 class="obrigatorios">* Campos obrigatórios</h5></div>
        <form>
            <div class="form-group col-md-6">
                <label>* Nome</label>
                <input type="text" name="nome_plano" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
                <label>* Tipo</label>
                <input type="text" name="tipo_plano" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
                <label>* Valor</label>
                <input type="text" name="valor_plano" class="form-control moeda" required>
            </div>
            <div class="form-group col-md-12">
                <button name="Cadastrar" class="btn btn-primary form-enviar"><i class="glyphicon glyphicon-floppy-disk"></i> Cadastrar</button>
            </div>
        </form>
    </div>

    <div class="col-md-12 modal-update">
        <div class="container"><h5 class="obrigatorios">* Campos obrigatórios</h5></div>
        <form>
            <div class="form-group col-md-6">
                <label>* Nome</label>
                <input type="text" name="nome_plano" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
                <label>* Tipo</label>
                <input type="text" name="tipo_plano" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
                <label>* Valor</label>
                <input type="text" name="valor_plano" class="form-control moeda" required>
            </div>
            <div class="form-group col-md-12">
                <button name="Cadastrar" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i> Atualizar</button>
            </div>
        </form>
    </div>

    <table class="table table-striped modal-table">
        <thead>
            <tr>
                <th>id</th>
                <th>Aluno</th>
                <th>Plano</th>
                <th>Data de Pagamento</th>
                <th>Valor Pago</th>
            </tr>
        </thead>
        <tbody class="j-result-historico">
            <?php
            $ReadHist = new Read;
            $ReadHist->FullRead("SELECT historicos_mensalidades.idhist_pag, alunos_cliente.nome_aluno, planos.nome_plano, historicos_mensalidades.data_mens_pag, historicos_mensalidades.valor_pag " .
                    "FROM historicos_mensalidades " .
                    "INNER JOIN alunos_cliente ON historicos_mensalidades.idalunos_cliente = alunos_cliente.idalunos_cliente " .
                    "INNER JOIN planos ON historicos_mensalidades.idplano = planos.idplano");

            foreach ($ReadHist->getResult() as $historico):
                extract($historico);
                echo "<tr id='{$idhist_pag}'>" .
                "<td>{$idhist_pag}</td>" .
                "<td>{$nome_aluno}</td>" .
                "<td>{$nome_plano}</td>" .
                "<td>{$data_mens_pag}</td>" .
                "<td>{$valor_pag}</td>" .
                "</tr>";
            endforeach;
            ?>
        </tbody>
    </table>
</div>

