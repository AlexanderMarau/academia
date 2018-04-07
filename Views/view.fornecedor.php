<!--MENU:-->
<?php require REQUIRE_PATH . '/menu.php'; ?>
<!--FIM MENU-->
<div class="col-md-10 modals">
    <br>
    <h2>Fornecedores</h2>
    <div>
        <div class="col-md-12" align="right">
            <form action="" method="POST">
                <div class="form-group col-md-4">
                    <input type="text" class="form-control pesquisar pesquisar-fornecedor" placeholder="Pesquisar">
                </div>
            </form>
            <button class="btn btn-primary open-modal-create"><i class="glyphicon glyphicon-user"></i> Novo Registro</button>
            <button class="btn btn-danger close-modal-create"><i class="glyphicon glyphicon-remove"></i></button>
            <button class="btn btn-danger close-modal-update"><i class="glyphicon glyphicon-remove"></i></button>
            <a class="relatorio-geral" href="http://localhost/academia/Views/view.fornecedores.relatorio.php" target="_blank"><button class="btn btn-warning"><i class="glyphicon glyphicon-print"></i> Relatório Geral</button></a>
        </div>

        <div class="form-group col-md-12 mensagens-retorno">
            <div class='alert alert-success'>
                <a href="#" class="close" data-dismiss="alert" arua-label="close">x</a>
                Cadastro realizado com sucesso!
            </div>
        </div>
        
        <!--Modal de Create de Fornecedores-->
        <div class="col-md-12 modal-create">
            <div class="container">
                <h5 class="obrigatorios">* Campos obrigatórios</h5>
            </div>
            <form action="" method="POST" class="form_fornecedor form-create j-form-create-fornecedor">
                <input type="hidden" name="callback" value="create-fornecedor">
                <div class="form-group col-md-6">
                    <label>* Nome</label>
                    <input type="text" name="nome_forn" class="form-control" required>
                </div>
                <div class="form-group col-md-3">
                    <label>* CNPJ</label>
                    <input type="text" name="cnpj_cpf_forn" id="cnpj_for" class="form-control cnpj" required minlength="18">
                </div>
                <div class="form-group col-md-3">
                    <label>* Nome Fantasia</label>
                    <input type="text" name="nome_fantasia_forn" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label>* E-mail</label>
                    <input type="email" name="email_forn" class="form-control" required>
                </div>
                <div class="form-group col-md-3">
                    <label>* Telefone</label>
                    <input type="text" name="telefone_forn" class="form-control telefoneC" required>
                </div>
                <div class="form-group col-md-3">
                    <label>* Estado</label>
                    <select name="idestado" class="form-control" required>
                        <option>SELECIONE</option>
                        <?php
                        $ReadEstado = new Read;
                        $ReadEstado->ExeRead("estado");
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
                        $ReadCidade = new Read;
                        $ReadCidade->ExeRead("cidade", "WHERE idestado = :iestado", "iestado=9");
                        foreach ($ReadCidade->getResult() as $i):
                            extract($i);
                            echo "<option value='{$idcidade}'>{$desc_cidade}</option>";
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <!--VAZIO-->
                </div>
                <div class="form-group col-md-12">
                    <label>Complementos</label>
                    <input type="text" name="complementos_forn" class="form-control">
                </div>
                <div class="form-group col-md-12">
                    <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i> Cadastrar</button>
                </div>
            </form>
        </div>
        
        <!--Modal de UPDATE de Fornecedores-->
        <div class="col-md-12 modal-update">
            <div class="container">
                <h5 class="obrigatorios">* Campos obrigatórios</h5>
            </div>
            <form action="" method="POST" class="form-update j-form-update-fornecedor">
                <input type="hidden" name="callback" value="update-fornecedor">
                <input type="hidden" name="idfornecedores" value="">
                <input type="hidden" name="idendereco_forn" value="">
                <div class="form-group col-md-6">
                    <label>* Nome</label>
                    <input type="text" name="nome_forn" class="form-control" required>
                </div>
                <div class="form-group col-md-3">
                    <label>* CNPJ / CPF</label>
                    <input type="text" name="cnpj_cpf_forn" class="form-control" required>
                </div>
                <div class="form-group col-md-3">
                    <label>* Nome Fantasia</label>
                    <input type="text" name="nome_fantasia_forn" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label>* E-mail</label>
                    <input type="email" name="email_forn" class="form-control" required>
                </div>
                <div class="form-group col-md-3">
                    <label>* Telefone</label>
                    <input type="text" name="telefone_forn" class="form-control telefoneC" required>
                </div>
                <div class="form-group col-md-3">
                    <label>* Estado</label>
                    <select name="idestado" class="form-control" required>
                        <option>SELECIONE</option>
                        <?php
                        $ReadEstado = new Read;
                        $ReadEstado->ExeRead("estado");
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
                        $ReadCidade = new Read;
                        $ReadCidade->ExeRead("cidade", "WHERE idestado = :iestado", "iestado=9");
                        foreach ($ReadCidade->getResult() as $i):
                            extract($i);
                            echo "<option value='{$idcidade}'>{$desc_cidade}</option>";
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <!--VAZIO-->
                </div>
                <div class="form-group col-md-12">
                    <label>Complementos</label>
                    <input type="text" name="complementos_forn" class="form-control">
                </div>
                <div class="form-group col-md-12">
                    <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i> Atualizar</button>
                </div>
            </form>
        </div>

        <table class="table table-striped modal-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Nome Fantasia</th>
                    <th>Telefone</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="j-result-fornecedores">
                <?php
                $ReadForn = new Read;
                $ReadForn->ExeRead("fornecedores");
                foreach ($ReadForn->getResult() as $e):
                    extract($e);
                    echo
                    "<tr id='{$idfornecedores}'>" .
                    "<td>{$idfornecedores}</td>" .
                    "<td>{$nome_forn}</td>" .
                    "<td>{$nome_fantasia_forn}</td>" .
                    "<td>{$telefone_forn}</td>" .
                    "<td align='right'>" .
                    "<button class='btn btn-success btn-xs open-modal-update j-open-modal-update-fornecedor' idfornecedores='{$idfornecedores}' idendereco_forn='{$idendereco_forn}'><i class='glyphicon glyphicon-edit'></i></button> " .
                    "</td>" .
                    "</tr>";
                endforeach;
                ?>
            </tbody>
        </table>
    </div>
</div>

