<!--MENU:-->
<?php require REQUIRE_PATH . '/menu.php'; ?>

<div class="col-md-10 modals">
    <br>
    <h2>Planos de Mensalidade</h2>

    <div class="col-md-12" align='right'>
        <form action="" method="POST">
            <div class="form-group col-md-4">
                <input type="text" placeholder="Pesquisar" class="form-control pesquisar pesquisar-plano">
            </div>
        </form>
        <button type="button" class="btn btn-primary open-modal-create"><i class="glyphicon glyphicon-plus"></i> Novo Registro</button>
        <button type="button" class="btn btn-danger close-modal-create"><i class="glyphicon glyphicon-remove"></i></button>
        <button type="button" class="btn btn-danger close-modal-update"><i class="glyphicon glyphicon-remove"></i></button>
    </div>

    <div class="form-group col-md-12 mensagens-retorno">
        <br>
        <div class='alert alert-success'>
            <a href="#" class="close" data-dismiss="alert" arua-label="close">x</a>
            Cadastro realizado com sucesso!
        </div>
    </div>
    <!--MODAL DE CREATE-->
    <div class="col-md-12 modal-create">
        <div class="container"><h5 class="obrigatorios">* Campos obrigatórios</h5></div>
        <form action="" method="POST" class="form_plano j-form-create-plano">
            <input type="hidden" name="callback" value="create-plano">
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
                <button name="Cadastrar" type="submit" class="btn btn-primary form-enviar"><i class="glyphicon glyphicon-floppy-disk"></i> Cadastrar</button>
            </div>
        </form>
    </div>
    <!--MODAL DE UPDATE-->
    <div class="col-md-12 modal-update">
        <div class="container"><h5 class="obrigatorios">* Campos obrigatórios</h5></div>
        <form action="" method="POST" class="j-form-update-plano" name="form_plano">
            <input type="hidden" name="callback" value="update-plano">
            <input type="hidden" name="idplano" value="">
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
                <button type="submit" name="Cadastrar" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i> Atualizar</button>
            </div>
        </form>
    </div>
    <!--TABELA DE RESULTADOS-->
    <table class="table table-striped modal-table">
        <thead>
            <tr>
                <th>id</th>
                <th>Nome</th>
                <th>Tipo em dias</th>
                <th>Valor</th>
                <th></th>
            </tr>
        </thead>
        <tbody class="j-result-planos">
            <?php
            $ReadPlanos = new Read;
            $ReadPlanos->FullRead("SELECT * FROM planos");
            foreach ($ReadPlanos->getResult() as $e):
                extract($e);
                echo "<tr id='{$idplano}'>
                        <td>{$idplano}</td>
                        <td>{$nome_plano}</td>
                        <td>{$tipo_plano}</td>
                        <td>{$valor_plano}</td>
                        <td align='right'>
                            <button class='btn btn-success btn-xs open-modal-update' idplano='{$idplano}'><i class='glyphicon glyphicon-edit'></i></button>
                            <button class='btn btn-danger btn-xs open-delete' idplano='{$idplano}'><i class='glyphicon glyphicon-trash'></i></button>
                        </td>
                    </tr>";
            endforeach;
            ?>
        </tbody>
    </table>
</div>

