<!--MENU:-->
<?php require REQUIRE_PATH . '/menu.php'; ?>
<!--FIM MENU-->
<?php
$ReadEstado = new Read;
$ReadEstado->ExeRead("estado");
$ReadCidade = new Read;
$ReadCidade->ExeRead("cidade", "WHERE idestado = :iestado", "iestado=9");
?>
<div class="col-md-10 modals">
    <br>
    <h2>Funcionários</h2>
    <div>
        <div class="col-md-12" align="right">
            <form action="" method="POST">
                <div class="form-group col-md-4">
                    <input type="text" placeholder="Pesquisar" class="form-control pesquisar pesquisar-funcionario">
                </div>
            </form>

            <button class="btn btn-primary open-modal-create"><i class="glyphicon glyphicon-user"></i> Novo Registro</button>
            <button class="btn btn-danger close-modal-create"><i class="glyphicon glyphicon-remove"></i></button>
            <button class="btn btn-danger close-modal-update"><i class="glyphicon glyphicon-remove"></i></button>
            <a class="relatorio-geral" href="http://localhost/academia/Views/view.funcionarios.relatorio.php" target="_blank"><button class="btn btn-warning"><i class="glyphicon glyphicon-print"></i> Relátorio Geral</button></a>
        </div>

        <div class="form-group col-md-12 mensagens-retorno">
            <div class='alert alert-success'>
                <a href="#" class="close" data-dismiss="alert" arua-label="close">x</a>
                Cadastro realizado com sucesso!
            </div>
        </div>

        <!--FORMULÁRIO DE CADASTRO DE FUNCIONÁRIOS-->
        <div class="col-md-12 modal-create">
            <div class="container">
                <h5 class="obrigatorios">*Campos obrigatórios</h5>
            </div>
            <form action="" method="POST" class="j-form-create-funcionario">
                <input type="hidden" name="callback" value="create-funcionario">
                <div class="form-group col-md-6">
                    <label>* Nome</label>
                    <input type="text" name="nome_func" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Nome do Pai</label>
                    <input type="text" name="nome_pai_func" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label>Nome da Mãe</label>
                    <input type="text" name="nome_mae_func" class="form-control">
                </div>
                <div class="form-group col-md-3">
                    <label>Data de Nascimento</label>
                    <input type="date" name="dt_nasc_func" class="form-control">
                </div>
                <div class="form-group col-md-3">
                    <label>Tipo de Sangue</label>
                    <input type="text" name="tipo_san_func" class="form-control" maxlength="2">
                </div>
                <div class="form-group col-md-3">
                    <label>* RG</label>
                    <input type="text" name="rg_func" class="form-control" maxlength="7" required>
                </div>
                <div class="form-group col-md-3">
                    <label>* CPF</label>
                    <input type="text" id="cpf_func" name="cpf_func" class="form-control cpf" placeholder="000.000.000-00" required>
                </div>
                <div class="form-group col-md-3">
                    <label>CPTS</label>
                    <input type="text" name="cpts_func" class="form-control" maxlength="7">
                </div>
                <div class="form-group col-md-3">
                    <label>PIS</label>
                    <input type="text" name="pis_func" class="form-control" maxlength="11">
                </div>
                <div class="form-group col-md-3">
                    <label>* Estado Civil</label>
                    <select name="estado_civil_func" class="form-control" required>
                        <option value="0">SELECIONE</option>
                        <option value="Casado">Casado</option>
                        <option value="Divorciado">Divorciado</option>
                        <option value="Separado">Separado</option>
                        <option value="Solteiro">Solteiro</option>
                        <option value="Viúvo">Viúvo</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Nacionalidade</label>
                    <input type="text" name="nacionalidade_func" class="form-control">
                </div>
                <div class="form-group col-md-3">
                    <label>Naturalidade</label>
                    <input type="text" name="naturalidade_func" class="form-control">
                </div>
                <div class="form-group col-md-3">
                    <label>Cargo</label>
                    <select name="cargo_func" class="form-control">
                        <option value="">SELECIONE</option>
                        <option value="Administrador">Administrador</option>
                        <option value="Gerente">Gerente</option>
                        <option value="Professor">Professor</option>
                        <option value="Recepcionista">Recepcionista</option>
                    </select>
                </div>
                <div class="form-group col-md-12">
                    <label>Função</label>
                    <input type="text" name="funcao_func" class="form-control">
                </div>
                <div class="form-group col-md-2">
                    <label>* Salário</label>
                    <input type="text" name="salario_func" class="form-control salario" placeholder="R$" required>
                </div>
                <div class="form-group col-md-2">
                    <label>* Hr. de entrada</label>
                    <input type="time" name="entrada_func" class="form-control" required>
                </div>
                <div class="form-group col-md-2">
                    <label>* Hr. de saída</label>
                    <input type="time" name="saida_func" class="form-control" required>
                </div>
                <div class="form-group col-md-3">
                    <label>* Status</label>
                    <select class="form-control" name="status_func" required>
                        <option value="Ativo">Ativo</option>
                        <option value="Inativo">Inativo</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label>* E-mail</label>
                    <input type="text" name="email_func" class="form-control" placeholder="email@exemplo.com.br" required>
                </div>
                <div class="form-group col-md-3">
                    <label>Telefone Celular</label>
                    <input type="text" name="celular_func" class="form-control telefoneC" placeholder="(00) 0 00000-0000">
                </div>
                <div class="form-group col-md-3">
                    <label>Telefone Residencial</label>
                    <input type="text" name="residencial_func" class="form-control telefoneR" placeholder="(00)00000-0000">
                </div>
                <div class="form-group col-md-3">
                    <label>* Estado</label>
                    <select name="idestado" class="form-control" required>
                        <option>SELECIONE</option>
                        <?php
                        foreach ($ReadEstado->getResult() as $i):
                            extract($i);
                            echo "<option value='{$idestado}'>{$uf}</option>";
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>* Cidade</label>
                    <select name="idcidade" class="form-control" required>
                        <option>SELECIONE</option>
                        <?php
                        foreach ($ReadCidade->getResult() as $i):
                            extract($i);
                            echo "<option value='{$idcidade}'>{$desc_cidade}</option>";
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-12">
                    <label>* Complemento</label>
                    <input type="text" name="complementos_fun" class="form-control" required>
                </div>
                <div class="form-group col-md-12">
                    <label>Obs.</label>
                    <textarea name="obs_func" class="form-control"></textarea>
                </div>
                <div class="form-group col-md-12">
                    <button type="submit" name="" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i> Cadastrar</button>
                </div>
            </form>
        </div>

        <!--FORMULÁRIO DE EDIÇÃO DE FUNCIONÁRIOS-->
        <div class="col-md-12 modal-update">
            <div class="container">
                <h5 class="obrigatorios">* Campos obrigatórios</h5>
            </div>
            <form action="" method="POST" class="j-form-update-funcionario form-update">
                <input type="hidden" name="callback" value="update-funcionario">
                <div class="form-group col-md-6">
                    <label>* Nome</label>
                    <input type="text" name="nome_func" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Nome do Pai</label>
                    <input type="text" name="nome_pai_func" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label>Nome da Mãe</label>
                    <input type="text" name="nome_mae_func" class="form-control">
                </div>
                <div class="form-group col-md-3">
                    <label>Data de Nascimento</label>
                    <input type="date" name="dt_nasc_func" class="form-control">
                </div>
                <div class="form-group col-md-3">
                    <label>Tipo de Sangue</label>
                    <input type="text" name="tipo_san_func" class="form-control" maxlength="2">
                </div>
                <div class="form-group col-md-3">
                    <label>* RG</label>
                    <input type="text" name="rg_func" class="form-control" maxlength="7" required>
                </div>
                <div class="form-group col-md-3">
                    <label>* CPF</label>
                    <input type="text" name="cpf_func" class="form-control cpf" placeholder="000.000.000-00" required>
                </div>
                <div class="form-group col-md-3">
                    <label>CPTS</label>
                    <input type="text" name="cpts_func" class="form-control" maxlength="7">
                </div>
                <div class="form-group col-md-3">
                    <label>PIS</label>
                    <input type="text" name="pis_func" class="form-control" maxlength="11">
                </div>
                <div class="form-group col-md-3">
                    <label>* Estado Civil</label>
                    <select name="estado_civil_func" class="form-control">
                        <option value="Casado">Casado</option>
                        <option value="Divorciado">Divorciado</option>
                        <option value="Separado">Separado</option>
                        <option value="Solteiro">Solteiro</option>
                        <option value="Viuvo">Viúvo</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Nacionalidade</label>
                    <input type="text" name="nacionalidade_func" class="form-control">
                </div>
                <div class="form-group col-md-3">
                    <label>Naturalidade</label>
                    <input type="text" name="naturalidade_func" class="form-control">
                </div>
                <div class="form-group col-md-3">
                    <label>Cargo</label>
                    <select name="cargo_func" class="form-control">
                        <option value="Administrador">Administrador</option>
                        <option value="Gerente">Gerente</option>
                        <option value="Professor">Professor</option>
                        <option value="Recepcionista">Recepcionista</option>
                    </select>
                </div>
                <div class="form-group col-md-12">
                    <label>Função</label>
                    <input type="text" name="funcao_func" class="form-control">
                </div>
                <div class="form-group col-md-2">
                    <label>* Salário</label>
                    <input type="text" name="salario_func" class="form-control salario" placeholder="R$" required>
                </div>
                <div class="form-group col-md-2">
                    <label>* Hr. de entrada</label>
                    <input type="time" name="entrada_func" class="form-control" required>
                </div>
                <div class="form-group col-md-2">
                    <label>* Hr. de saída</label>
                    <input type="time" name="saida_func" class="form-control" required>
                </div>
                <div class="form-group col-md-3">
                    <label>* Status</label>
                    <select class="form-control" name="status_func" required>
                        <option value="Ativo">Ativo</option>
                        <option value="Inativo">Inativo</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label>* E-mail</label>
                    <input type="text" name="email_func" class="form-control" placeholder="email@exemplo.com.br" required>
                </div>
                <div class="form-group col-md-3">
                    <label>Telefone Celular</label>
                    <input type="text" name="celular_func" class="form-control telefoneC" placeholder="(00) 0 00000-0000">
                </div>
                <div class="form-group col-md-3">
                    <label>Telefone Residencial</label>
                    <input type="text" name="residencial_func" class="form-control telefoneR" placeholder="(00)00000-0000">
                </div>
                <div class="form-group col-md-3">
                    <label>* Estado</label>
                    <select name="idestado" class="form-control" required>
                        <?php
                        foreach ($ReadEstado->getResult() as $i):
                            extract($i);
                            echo "<option value='{$idestado}'>{$uf}</option>";
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>* Cidade</label>
                    <select name="idcidade" class="form-control" required>
                        <?php
                        foreach ($ReadCidade->getResult() as $i):
                            extract($i);
                            echo "<option value='{$idcidade}'>{$desc_cidade}</option>";
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-12">
                    <label>* Complemento</label>
                    <input type="text" name="complementos_fun" class="form-control" required>
                </div>
                <div class="form-group col-md-12">
                    <label>Obs.</label>
                    <textarea name="obs_func" class="form-control"></textarea>
                </div>
                <div class="form-group col-md-12">
                    <button type="submit" name="" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i> Atualizar</button>
                </div>
            </form>
        </div>


        <table class="table table-striped modal-table">
            <thead>
                <tr>
                    <th>Matricula</th>
                    <th>Nome</th>
                    <th>Cargo</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="j-result-funcionarios">
                <?php
                $ReadFun = new Read;
                $ReadFun->ExeRead("funcionarios");
                foreach ($ReadFun->getResult() as $e):
                    extract($e);
                    echo
                    "<tr id='{$idfuncionarios}'>" .
                    "<td>{$idfuncionarios}</td>" .
                    "<td>{$nome_func}</td>" .
                    "<td>{$cargo_func}</td>" .
                    "<td>{$status_func}</td>" .
                    "<td align='right'>" .
                    "<button class='btn btn-success btn-xs open-modal-update j-open-modal-update-funcionario' idfuncionarios='{$idfuncionarios}' idendereco_func='{$idendereco_func}'><i class='glyphicon glyphicon-edit'></i></button> " .
                    "<a href='http://localhost/academia/Views/view.funcionario.relatorio.php?idfuncionarios={$idfuncionarios}' target='_blank'><button class='btn btn-warning btn-xs open-imprimir'><i class='glyphicon glyphicon-print'></i></button></a>" .
                    "</td>" .
                    "</tr>";
                endforeach;
                ?>
            </tbody>
        </table>
    </div>
</div>