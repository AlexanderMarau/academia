<!--MENU:-->
<?php require REQUIRE_PATH . '/menu.php'; ?>
<?php
$ReadEstado = new Read;
$ReadEstado->ExeRead("estado");
$ReadCidade = new Read;
$ReadCidade->ExeRead("cidade", "WHERE idestado = :iestado", "iestado=9");
?>
<!--FIM MENU-->

<div class="col-md-10 modals">
    <br>
    <h2>Alunos</h2>
    <div>
        <div class="col-md-12" align='right'>
            <form action="" method="POST">
                <div class="form-group col-md-4">
                    <input type="text" placeholder="Pesquisar" class="form-control pesquisar pesquisar-aluno">
                </div>
            </form>

            <button class="btn btn-primary open-modal-create"><i class="glyphicon glyphicon-user"></i> Novo Registro</button>
            <button class="btn btn-danger close-modal-create"><i class="glyphicon glyphicon-remove"></i></button>
            <button class="btn btn-danger close-modal-update"><i class="glyphicon glyphicon-remove"></i></button>
            <a href="http://localhost/academia/Views/view.alunos.relatorio.php" target="_blank" class="relatorio-geral"><button class="btn btn-warning"><i class="glyphicon glyphicon-print"></i> Relátorio Geral</button></a>
        </div>

        <div class="form-group col-md-12 mensagens-retorno">
            <div class='alert alert-success'>
                <a href="#" class="close" data-dismiss="alert" arua-label="close">x</a>
                Cadastro realizado com sucesso!
            </div>
        </div>

        <!--Modal create de Aluno-->
        <div class="col-md-12 modal-create">
            <div class="container">
                <h5 class="obrigatorios">* Campos obrigatórios</h5>
            </div>
            <!--Form create de Aluno-->
            <form action="" method="POST" class="form-create j-form-create-aluno">
                <input type="hidden" name="callback" value="create-aluno">
                <div class="form-group col-md-6">
                    <br>
                    <label>* Nome</label>
                    <input type="text" name="nome_aluno" class="form-control" required>
                </div>
                <div class="form-group col-md-3">
                    <br>
                    <label>* CPF</label>
                    <input minlength="14" type="text" name="cpf_aluno" id="cpf_aluno" class="form-control cpf" required>
                </div>
                <div class="form-group col-md-3">
                    <br>
                    <label>* RG</label>
                    <input type="text" name="rg_aluno" class="form-control" maxlength="7" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Nome da Mãe</label>
                    <input type="text" name="nome_mae" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label>Nome do Pai</label>
                    <input type="text" name="nome_pai" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label>* E-mail</label>
                    <input type="email" name="email_aluno" class="form-control" required>
                </div>
                <div class="form-group col-md-3">
                    <label>Telefone Celular</label>
                    <input type="text" name="celular_aluno" class="form-control telefoneC">
                </div>
                <div class="form-group col-md-3">
                    <label>Telefone Residencial</label>
                    <input type="text" name="residencial_aluno" class="form-control telefoneR">
                </div>
                <div class="form-group col-md-2">
                    <label>* Dt. Nascimento</label>
                    <input type="date" name="data_nascimento_aluno" class="form-control" required>
                </div>
                <div class="form-group col-md-2">
                    <label>Status</label>
                    <select name="status_aluno" class="form-control">
                        <option value="Ativo">Ativo</option>
                        <option value="Inativo">Inativo</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Estado</label>
                    <select name="idestado" class="form-control">
                        <?php
                        foreach ($ReadEstado->getResult() as $i):
                            extract($i);
                            echo "<option value='{$idestado}'>{$uf}</option>";
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-5 campo-select">
                    <label>Cidade</label>
                    <select name="idcidade" class="form-control form-control-lg">
                        <?php
                        foreach ($ReadCidade->getResult() as $i):
                            extract($i);
                            echo "<option value='{$idcidade}'>{$desc_cidade}</option>";
                        endforeach;
                        ?>
                        <option></option>
                    </select>
                </div>
                <div class="form-group col-md-12">
                    <label>Complemento</label>
                    <input type="text" name="complementos_aluno" class="form-control">
                </div>

                <div class="form-group col-md-12">
                    <label>Obs.</label>
                    <textarea type="text" name="obs_aluno" class="form-control"></textarea>
                </div>
                <div class="form-group col-md-12">
                    <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i> Cadastrar</button>
                </div>
            </form>
        </div>
        
        <!--Modal update Aluno-->
        <div class="col-md-12 modal-update">
            <div class="container">
                <h5 class="obrigatorios">* Campos obrigatórios</h5>
            </div>
            <!--Form update Aluno-->
            <form action="" method="POST" class="j-form-update-aluno form-update ">
                <input type="hidden" name="callback" value="update-aluno">
                <input type="hidden" name="idalunos_cliente" value="">
                <input type="hidden" name="idendereco_aluno" value="">
                <div class="form-group col-md-6">
                    <br>
                    <label>* Nome</label>
                    <input type="text" name="nome_aluno" class="form-control" required>
                </div>
                <div class="form-group col-md-3">
                    <br>
                    <label>* CPF</label>
                    <input type="text" id="cpf_aluno" name="cpf_aluno" class="form-control cpf" required>
                </div>
                <div class="form-group col-md-3">
                    <br>
                    <label>* RG</label>
                    <input type="text" name="rg_aluno" class="form-control" maxlength="7" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Nome da Mãe</label>
                    <input type="text" name="nome_mae" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label>Nome do Pai</label>
                    <input type="text" name="nome_pai" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label>* E-mail</label>
                    <input type="email" name="email_aluno" class="form-control" required>
                </div>
                <div class="form-group col-md-3">
                    <label>Telefone Celular</label>
                    <input type="text" name="celular_aluno" class="form-control telefoneC">
                </div>
                <div class="form-group col-md-3">
                    <label>Telefone Residencial</label>
                    <input type="text" name="residencial_aluno" class="form-control telefoneR">
                </div>
                <div class="form-group col-md-2">
                    <label>* Dt. Nascimento</label>
                    <input type="date" name="data_nascimento_aluno" class="form-control" required>
                </div>
                <div class="form-group col-md-2">
                    <label>Status</label>
                    <select name="status_aluno" class="form-control">
                        <option value="Ativo">Ativo</option>
                        <option value="Inativo">Inativo</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Estado</label>
                    <select name="idestado" class="form-control">
                        <?php
                        foreach ($ReadEstado->getResult() as $i):
                            extract($i);
                            echo "<option value='{$idestado}'>{$uf}</option>";
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-5">
                    <label>Cidade</label>
                    <select name="idcidade" class="form-control">
                        <?php
                        foreach ($ReadCidade->getResult() as $i):
                            extract($i);
                            echo "<option value='{$idcidade}'>{$desc_cidade}</option>";
                        endforeach;
                        ?>
                        <option></option>
                    </select>
                </div>
                <div class="form-group col-md-12">
                    <label>Complemento</label>
                    <input type="text" name="complementos_aluno" class="form-control">
                </div>

                <div class="form-group col-md-12">
                    <label>Obs.</label>
                    <textarea type="text" name="obs_aluno" class="form-control"></textarea>
                </div>
                <div class="form-group col-md-12">
                    <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i> Atualizar</button>
                </div>
            </form>
        </div>
        
        <!--Tabela com os registros de Alunos no banco de dados-->
        <table class="table table-striped modal-table">
            <thead>
                <tr>
                    <th>Matricula</th>
                    <th>Nome</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="j-result-alunos">
                <?php
                $ReadAlunos = new Read;
                $ReadAlunos->ExeRead("alunos_cliente");
                foreach ($ReadAlunos->getResult() as $e):
                    extract($e);
                    echo "<tr id='{$idalunos_cliente}'>" .
                    "<td>{$idalunos_cliente}</td>" .
                    "<td>{$nome_aluno}</td>" .
                    " <td>{$status_aluno}</td>" .
                    "<td align='right'>".
                        "<button class='btn btn-success btn-xs open-modal-update j-open-modal-update-aluno' idalunos_cliente='{$idalunos_cliente}' idendereco_aluno='{$idendereco_aluno}'><i class='glyphicon glyphicon-edit'></i></button> ".
                        "<a href='http://localhost/academia/Views/view.aluno.relatorio.php?idalunos_cliente={$idalunos_cliente}' target='_blank'><button class='btn btn-warning btn-xs open-imprimir relatorio-aluno'><i class='glyphicon glyphicon-print'></i></button></a> ".
                    "</td>" .
                    "</tr>";
                endforeach;
                ?>
            </tbody>
        </table>
    </div>
</div>

