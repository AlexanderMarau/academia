<!--MENU:-->
<?php require REQUIRE_PATH . '/menu.php'; ?>

<div class="col-md-10 modals">
    <br>
    <h2>Planos de Mensalidade</h2>
    
    <div class="col-md-12" align='right'>
        <form action="" method="POST">
            <div class="form-group col-md-4">
                <input type="text" placeholder="Pesquisar" class="form-control pesquisar pesquisar-mensalidade">
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
                <th>Nome</th>
                <th>Tipo</th>
                <th>Valor</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td align="right">
                    <button class='btn btn-success btn-xs open-modal-update'><i class='glyphicon glyphicon-edit'></i></button>
                    <button class='btn btn-danger btn-xs open-delete'><i class='glyphicon glyphicon-trash'></i></button>
                </td>
            </tr>
        </tbody>
    </table>
</div>

