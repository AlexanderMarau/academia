<!--MENU:-->
<?php require REQUIRE_PATH . '/menu.php'; ?>
<!--FIM MENU-->
<div class="col-md-10 modals">
    <br>
    <h2>Mensalidades</h2>
    <div class="col-md-12" align='right'>
        <form action="" method="POST">
            <div class="form-group col-md-4">
                <input type="text" placeholder="Pesquisar" class="form-control pesquisar pesquisar-mensalidade">
            </div>
        </form>
        <button type="button" class="btn btn-primary open-modal-create"><i class="glyphicon glyphicon-plus"></i> Novo Registro</button>
        <a href="#"><button class="btn btn-warning comprovante-mensalidade"><i class="glyphicon glyphicon-print"></i> Comprovante</button></a>
        <button type="button" class="btn btn-danger close-modal-create"><i class="glyphicon glyphicon-remove"></i></button>
        <button type="button" class="btn btn-danger close-modal-update"><i class="glyphicon glyphicon-remove"></i></button>
        <button type="button" class="btn btn-danger close-modal-pagamento"><i class="glyphicon glyphicon-remove"></i></button>
        <a class="relatorio-geral" href="http://localhost/academia/Views/view.mensalidades.relatorio.php" target="_blank"><button class="btn btn-warning"><i class="glyphicon glyphicon-print"></i> Relátorio Geral</button></a>
    </div>

    <div class="form-group col-md-12 mensagens-retorno">
        <br>
        <div class='alert alert-success'>
            <a href="#" class="close" data-dismiss="alert" arua-label="close">x</a>
            Cadastro realizado com sucesso!
        </div>
        <div class="alert alert-info alert-mensalidade">
            Pagamento realizado com sucesso! Realize a impressão do conprovante de pagamento.
            <a href="#" class="close" data-dismiss="alert" arua-label="close">x</a>
        </div>
    </div>

    <!--FORMULÁRIO DE CADASTRO DE MENSALIDADE-->
    <div class="col-md-12 mensalidade-div modal-create">
        <div class="container"><h5 class="obrigatorios">* Campos obrigatórios</h5></div>
        <form class="form-mensalidade form-create j-form-create-mensalidade" action="" method="POST">
            <input type="hidden" name="callback" value="create-mensalidade">
            <div class="form-group col-md-6">
                <label>* Aluno</label>
                <select name="idalunos_cliente" class="form-control" required>
                    <option>SELECIONE</option>
                    <?php
                    $ReadAlunos = new Read;
                    $ReadAlunos->ExeRead("alunos_cliente");
                    foreach ($ReadAlunos->getResult() as $e):
                        extract($e);
                        echo "<option value='{$idalunos_cliente}'>{$idalunos_cliente} - {$nome_aluno}</option>";
                    endforeach;
                    ?>

                </select>
            </div>
            <div class="form-group col-md-3">
                <label>* Data de Pagamento</label>
                <input type="date" name="data_mens_pag" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
                <label>* Plano</label>
                <select name="idplano" class="form-control" required>
                    <option value=0>SELECIONE</option>
                </select>
            </div>
            <div class="form-group col-md-12">
                <button name="Cadastrar" class="btn btn-primary form-enviar"><i class="glyphicon glyphicon-floppy-disk"></i> Cadastrar</button>
            </div>
        </form>
    </div>

    <!--FORMULÁRIO DE UPDATE DE MENSALIDADE-->
    <div class="col-md-12 modal-update">
        <form class="form-mensalidade j-form-update-mensalidade" action="" method="POST">
            <input type="hidden" name="callback" value="update-mensalidade">
            <input type="hidden" name="idmensalidades" value="">
            <div class="container">
                <h5 class="obrigatorios">* Campos obrigatórios</h5>
            </div>
            <div class="form-group col-md-6">
                <label>* Aluno</label>
                <select name="idalunos_cliente" class="form-control" required>
                    <option>SELECIONE</option>
                    <?php
                    $ReadAlunos = new Read;
                    $ReadAlunos->ExeRead("alunos_cliente");
                    foreach ($ReadAlunos->getResult() as $e):
                        extract($e);
                        echo "<option value='{$idalunos_cliente}'>{$idalunos_cliente} - {$nome_aluno}</option>";
                    endforeach;
                    ?>

                </select>
            </div>
            <div class="form-group col-md-3">
                <label>* Data de Pagamento</label>
                <input type="date" name="data_mens_pag" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
                <label>* Plano</label>
                <select name="status_mensalidades" class="form-control">
                    <option value=0>SELECIONE</option>
                </select>
            </div>
            <div class="form-group col-md-12">
                <button name="Cadastrar" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i> Atualizar</button>
            </div>
        </form>
    </div>

    <div class="col-md-12 pagar-mensalidade">
        <form action="" method="POST" class="">
            <div class="container">
                <h5 class="obrigatorios">* Campos obrigatórios</h5>
            </div>
            <div class="form-group col-md-6">
                <label>* Aluno</label>
                <input type="text" name="" class="form-control" disabled>
            </div>
            <div class="form-group col-md-3">
                <label>* Data de Vencimento</label>
                <input type="date" name="" class="form-control" disabled>
            </div>
            <div class="form-group col-md-3">
                <label>* Valor da Mensalidade</label>
                <input type="text" name="" class="form-control moeda" placeholder="R$" disabled>
            </div>
            <div class="form-group col-md-3">
                <label>* Data do Pagamento</label>
                <input type="date" name="" class="form-control">
            </div>
            <div class="form-group col-md-3">
                <label>* Valor da Entrada</label>
                <input type="text" name="" class="form-control moeda" placeholder="R$" required="">
            </div>
            <div class="form-group col-md-3">
                <label>Descontos</label>
                <input type="text" name="" class="form-control moeda" placeholder="R$">
            </div>
            <div class="form-group col-md-3">
                <label>Juros</label>
                <input type="text" name="" class="form-control moeda" placeholder="R$">
            </div>
            <div class="form-group col-md-3">
                <label>Valor Total</label>
                <input type="text" name="" class="form-control moeda" placeholder="R$" disabled>
            </div>
            <div class="form-group col-md-12">
                <button class="btn btn-primary pagamento-mensalidade"><i class="glyphicon glyphicon-shopping-cart"></i> Confirmar</button>
            </div>
        </form>
    </div>

    <table class="table table-striped modal-table">
        <thead>
            <tr>
                <th>Matricula</th>
                <th>Aluno</th>
                <th>Vencimento</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody class="j-result-menssalidades">
            <?php
            $ReadMensalidadePaga = new Read;
            $ReadMensalidadePaga->FullRead("SELECT mensalidades.idmensalidades, alunos_cliente.idalunos_cliente ,alunos_cliente.nome_aluno, mensalidades.data_mens_pag, mensalidades.status_mensalidades "
                    . "FROM mensalidades "
                    . "INNER JOIN alunos_cliente ON mensalidades.idalunos_cliente = alunos_cliente.idalunos_cliente "
                    . "ORDER BY alunos_cliente.idalunos_cliente");
            foreach ($ReadMensalidadePaga->getResult() as $e):
                extract($e);
                echo
                "<tr id='{$idmensalidades}'>" .
                "<td>{$idalunos_cliente}</td>" .
                "<td>{$nome_aluno}</td>" .
                "<td>{$data_mens_pag}</td>" .
                "<td>{$status_mensalidades}</td>" .
                "<td align='right'>" .
                "<button class='btn btn-success btn-xs open-modal-update j-open-modal-update-mensalidade' idmensalidades={$idmensalidades}><i class='glyphicon glyphicon-edit'></i></button></a> " .
                "<button class='btn btn-primary btn-xs open-modal-pagamento'><i class='glyphicon glyphicon-shopping-cart'></i> Gerar Pagamento</button></a>" .
                "</td>" .
                "</tr>";
            endforeach;
            ?>
        </tbody>
    </table>
</div>
