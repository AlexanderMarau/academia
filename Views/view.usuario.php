<!--MENU:-->
<?php require REQUIRE_PATH . '/menu.php'; ?>
<!--FIM MENU-->
<div class="col-md-10 modals">
    <br>
    <h2>Usuários</h2>
    <div class="col-md-12" align="right">
        <form action="" method="POST">
            <div class="form-group col-md-4">
                <input type="text" class="form-control pesquisar pesquisar-usuario" placeholder="Pesquisar">
            </div>
        </form>
        <button type="button" class="btn btn-primary open-modal-create"><i class="glyphicon glyphicon-user"></i> Novo Registro</button>
        <button type="button" class="btn btn-danger close-modal-create"><i class="glyphicon glyphicon-remove"></i></button>
        <button type="button" class="btn btn-danger close-modal-update"><i class="glyphicon glyphicon-remove"></i></button>
        <a class="relatorio-geral" href="http://localhost/academia/Views/view.usuarios.relatorio.php" target="_blank"><button type="" class="btn btn-warning"><i class="glyphicon glyphicon-print"></i> Relátorio Geral</button></a>
    </div>

    <div class="form-group col-md-12 mensagens-retorno">
        <div class='alert alert-success'>
            <a href="#" class="close" data-dismiss="alert" arua-label="close">x</a>
            Cadastro realizado com sucesso!
        </div>
    </div>

    <!--MODAL DE CREATE DO USUÁRIO-->
    <div class="col-md-12 modal-create">
        <div class="container">
            <h5 class="obrigatorios">* Campos obrigatórios</h5>
        </div>
        <form action="" method="POST" class="form-create j-form-create-usuario">
            <input type="hidden" name="callback" value="create-usuario">
            <div class="form-group col-md-6">
                <br>
                <label>* Nome</label>
                <input type="text" name="nome_usuario" class="form-control" required>
            </div>
            <div class="form-group col-md-6">
                <br>
                <label>* Funcionário</label>
                <select name="idfuncionarios" class="form-control">
                    <option>SELECIONE</option>
                    <?php
                    $ReadFun = new Read;
                    $ReadFun->ExeRead("funcionarios");
                    foreach ($ReadFun->getResult() as $e):
                        extract($e);
                        echo "<option value='{$idfuncionarios}'>{$idfuncionarios} - {$nome_func}</option>";
                    endforeach;
                    ?> 
                </select>
            </div>
            <div class="form-group col-md-6">
                <label>* E-mail</label>
                <input type="email" name="email_usuario" class="form-control" placeholder="email@exemplo.com.br" required>
            </div>
            <div class="form-group col-md-3">
                <label>* Senha</label>
                <input type="password" name="senha_usuario" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
                <label>* Confirme a Senha</label>
                <input type="password" name="senha_usuario" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
                <label>* Perfil</label>
                <select name="perfil_usuario" class="form-control" required>
                    <option value=0>SELECIONE</option>
                    <option value="admin">Administrador</option>
                    <option value="professor">Professor</option>
                </select>
            </div>

            <div class="form-group col-md-12">
                <button name="" type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i> Cadastrar</button>
            </div>               
        </form>
    </div>

    <!--MODAL DE UPDATE DO USUÁRIO-->
    <div class="col-md-12 modal-update">
        <form action="" method="POST" class="form-usuario j-form-update-usuario">
            <input type="hidden" name="callback" value="update-usuario">
            <div class="form-group col-md-6">
                <br>
                <label>* Nome</label>
                <input type="text" name="nome_usuario" class="form-control" required>
            </div>
            <div class="form-group col-md-6">
                <br>
                <label>* Funcionário</label>
                <select name="idfuncionarios" class="form-control">
                    <option>SELECIONE</option>
                    <?php
                    $ReadFun = new Read;
                    $ReadFun->ExeRead("funcionarios");
                    foreach ($ReadFun->getResult() as $e):
                        extract($e);
                        echo "<option value='{$idfuncionarios}'>{$idfuncionarios} - {$nome_func}</option>";
                    endforeach;
                    ?> 
                </select>
            </div>
            <div class="form-group col-md-6">
                <label>* E-mail</label>
                <input type="email" name="email_usuario" class="form-control" placeholder="email@exemplo.com.br" required>
            </div>
            <div class="form-group col-md-3">
                <label>* Senha</label>
                <input type="password" name="senha_usuario" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
                <label>* Confirme a Senha</label>
                <input type="password" name="senha_usuario" class="form-control" required>
            </div>
            <div class="form-group col-md-3">
                <label>* Perfil</label>
                <select name="perfil_usuario" class="form-control" required>
                    <option value=0>SELECIONE</option>
                    <option value="admin">Administrador</option>
                    <option value="professor">Professor</option>
                </select>
            </div>

            <div class="form-group col-md-12">
                <button name="" type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i> Atualizar</button>
            </div>               
        </form>
    </div>

    <table class="table table-striped modal-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Funcionário</th>
                <th>E-mail</th>
                <th>Perfil</th>
                <th></th>
            </tr>
        </thead>
        <tbody class="j-result-usuarios">
            <?php
            $ReadUsuario = new Read;
            $ReadUsuario->FullRead("SELECT usuario.idusuario, usuario.email_usuario, usuario.perfil_usuario, funcionarios.nome_func " .
                    "FROM usuario " .
                    "INNER JOIN funcionarios ON usuario.idfuncionarios = funcionarios.idfuncionarios");
            foreach ($ReadUsuario->getResult() as $e):
                extract($e);
                echo
                "<tr id='{$idusuario}'>" .
                "<td>{$idusuario}</td>" .
                "<td>{$nome_func}</td>" .
                "<td>{$email_usuario}</td>" .
                "<td>{$perfil_usuario}</td>" .
                "<td align='right'>" .
                "<button class='btn btn-success btn-xs open-modal-update j-open-modal-update-usuario' idusuario='{$idusuario}'><i class='glyphicon glyphicon-edit'></i></button> " .
                "<button class='btn btn-danger btn-xs open-delete j-btn-del-usuario' idusuario='{$idusuario}'><i class='glyphicon glyphicon-trash'></i></button>" .
                "</td>" .
                "</tr>";
            endforeach;
            ?>
        </tbody>
    </table>
</div>