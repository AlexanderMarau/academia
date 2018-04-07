<!--MENU:-->
<?php require REQUIRE_PATH . '/menu.php'; ?>
<!--FIM MENU-->
<div class="col-md-10 modals">
    <br>
    <h2>Equipamentos</h2>
    <div>
        <div class="col-md-12" align="right">
            <form action="" method="POST">
                <div class="form-group col-md-4">
                    <input type="text" placeholder="Pesquisar" class="form-control pesquisar pesquisar-equipamento">
                </div>
            </form>

            <button class="btn btn-primary open-modal-create"><i class="glyphicon glyphicon-plus"></i> Novo Registro</button>
            <button class="btn btn-danger close-modal-create"><i class="glyphicon glyphicon-remove"></i></button>
            <button class="btn btn-danger close-modal-update"><i class="glyphicon glyphicon-remove"></i></button>
            <a class="relatorio-geral" href="http://localhost/academia/Views/view.equipamento.relatorio.php" target="_blank"><button class="btn btn-warning"><i class="glyphicon glyphicon-print"></i> Relátorio Geral</button></a>
        </div>

        <div class="form-group col-md-12 mensagens-retorno">
            <div class='alert alert-success'>
                <a href="#" class="close" data-dismiss="alert" arua-label="close">x</a>
                Cadastro realizado com sucesso!
            </div>
        </div>

        <!--FORMULÁRIO DE CADASTRO DE TREINOS-->
        <div class="col-md-12 modal-create">
            <div class="container"><h5 class="obrigatorios">* Campos Obrigatórios</h5></div>
            <form class="form_equipamento form-create j-form-create-equipamento" action="" method="POST">
                <input type="hidden" name="callback" value="create-equipamento">
                <div class="form-group col-md-6">
                    <label>* Fornecedor</label>
                    <select class="form-control" name="idfornecedores" required>
                        <option value="0">SELECIONE</option>
                        <?php
                        $ReadFornecedor = new Read;
                        $ReadFornecedor->ExeRead("fornecedores");
                        foreach ($ReadFornecedor->getResult() as $e):
                            extract($e);
                            echo "<option value='{$idfornecedores}'>{$idfornecedores} - {$nome_forn}</option>";
                        endforeach;
                        ?>  
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label>* Nome</label>
                    <input type="text" name="nome_equip" class="form-control" required>
                </div>
                <div class="form-group col-md-2">
                    <label>* Data de entrada</label>
                    <input type="date" name="data_equip_entr" class="form-control" required>
                </div>
                <div class="form-group col-md-2">
                    <label>Data de Saida</label>
                    <input type="date" name="data_equip_saida" class="form-control">
                </div>
                <div class="form-group col-md-2">
                    <label>Preço de entrada</label>
                    <input type="text" name="preco_equip_entr" class="form-control moeda">
                </div>
                <div class="form-group col-md-2">
                    <label>Data de Manutenção</label>
                    <input type="date" name="data_manutencao_equip" class="form-control">
                </div>
                <div class="form-group col-md-4">
                    <label>* Marca</label>
                    <input type="text" name="marca_equip" class="form-control" required>
                </div>
                <div class="form-group col-md-12">
                    <label>Funcionalidade</label>
                    <input type="text" name="funcionalidade_equip" class="form-control">
                </div>
                <div class="form-group col-md-12">
                    <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i> Cadastrar</button>
                </div>
            </form>
        </div>   

        <!--FORMULÁRIO DE UPDATE DE TREINOS-->
        <div class="col-md-12 modal-update">
            <div class="container"><h5 class="obrigatorios">* Campos Obrigatórios</h5></div>
            <form class="j-form-update-equipamento form_equipamento form-update" action="" method="POST">
                <input type="hidden" name="callback" value="update-equipamento">
                <input type="hidden" name="idequipamentos" value="">
                <div class="form-group col-md-6">
                    <label>* Fornecedor</label>
                    <select class="form-control" name="idfornecedores" required>
                        <option>SELECIONE</option>
                        <?php
                        foreach ($ReadFornecedor->getResult() as $e):
                            extract($e);
                            echo "<option value='{$idfornecedores}'>{$idfornecedores} - {$nome_forn}</option>";
                        endforeach;
                        ?>  
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label>* Nome</label>
                    <input type="text" name="nome_equip" class="form-control" required>
                </div>
                <div class="form-group col-md-2">
                    <label>* Data de entrada</label>
                    <input type="date" name="data_equip_entr" class="form-control" required>
                </div>
                <div class="form-group col-md-2">
                    <label>Data de Saida</label>
                    <input type="date" name="data_equip_saida" class="form-control">
                </div>
                <div class="form-group col-md-2">
                    <label>Preço de entrada</label>
                    <input type="text" name="preco_equip_entr" class="form-control moeda">
                </div>
                <div class="form-group col-md-2">
                    <label>Data de Manutenção</label>
                    <input type="date" name="data_manutencao_equip" class="form-control">
                </div>
                <div class="form-group col-md-4">
                    <label>* Marca</label>
                    <input type="text" name="marca_equip" class="form-control" required>
                </div>
                <div class="form-group col-md-12">
                    <label>Funcionalidade</label>
                    <input type="text" name="funcionalidade_equip" class="form-control">
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
                    <th>Marca</th>
                    <th>Fornecedor</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="j-result-equipamentos">
                <?php
                $ReadEquipamento = new Read;
                $ReadEquipamento->FullRead("SELECT equipamentos.idequipamentos, equipamentos.nome_equip, equipamentos.marca_equip, fornecedores.nome_forn "
                        . "FROM equipamentos "
                        . "INNER JOIN fornecedores ON equipamentos.idfornecedores = fornecedores.idfornecedores "
                        . "ORDER BY equipamentos.idequipamentos");
                foreach ($ReadEquipamento->getResult() as $e):
                    extract($e);
                    echo
                    "<tr id='{$idequipamentos}'>" .
                    "<td>{$idequipamentos}</td>" .
                    "<td>{$nome_equip}</td>" .
                    "<td>{$marca_equip}</td>" .
                    "<td>{$nome_forn}</td>" .
                    "<td align='right'>" .
                    "<button class='btn btn-success btn-xs open-modal-update j-open-modal-update-equipamento' idequipamentos={$idequipamentos}><i class='glyphicon glyphicon-edit'></i></button> " .
                    "</td>" .
                    "</tr>";
                endforeach;
                ?>
            </tbody>
        </table>
    </div>
</div>

</div>


