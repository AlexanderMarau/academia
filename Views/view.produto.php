<!--MENU:-->
<?php require REQUIRE_PATH . '/menu.php'; ?>
<!--FIM-->
<div class="col-md-10 modals">
    <br>
    <h2>Produtos</h2>
    <div>
        <div class="col-md-12" align="right">
            <form action="" method="POST">
                <div class="form-group col-md-4">
                    <input type="text" class="form-control pesquisar pesquisar-produto" placeholder="Pesquisar">
                </div>
            </form>
            <button class="btn btn-primary open-modal-create"><i class="glyphicon glyphicon-plus"></i> Novo Produto</button>
            <button class="btn btn-danger close-modal-create"><i class="glyphicon glyphicon-remove"></i></button>
            <button class="btn btn-danger close-modal-update"><i class="glyphicon glyphicon-remove"></i></button>
            <a class="relatorio-geral" href="http://localhost/academia/Views/view.produtos.relatorio.php" target="_blank"><button class="btn btn-warning"><i class="glyphicon glyphicon-print"></i> Relatório Geral</button></a>
        </div>

        <!--Modal de Create de Produto-->
        <div class="col-md-12 modal-create">
            <form action="" method="POST" class="form-create j-form-create-produto">
                <input type="hidden" name="callback" value="create-produto" />
                <div class="container">
                    <h5 class="obrigatorios">* Campos obrigatórios</h5>
                </div>
                <div class="form-group col-md-6">
                    <label>* Nome</label>
                    <input type="text" name="nome_prod" class="form-control" required>
                </div>
                <div class="form-group col-md-3">
                    <label>* Categoria</label>
                    <?php
                    $ReadCatProd = new Read;
                    $ReadCatProd->FullRead("SELECT idcate_produto, descricao FROM cat_produto");
                    ?>
                    <select class="form-control" name="idcate_produto">
                        <option>SELECIONE</option>
                        <?php
                        foreach ($ReadCatProd->getResult() as $e):
                            extract($e);
                            echo "<option value='{$idcate_produto}'>{$idcate_produto} - {$descricao}</option>";
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>* Fornecedor</label>
                    <?php
                    $ReadForn = new Read;
                    $ReadForn->FullRead("SELECT idfornecedores, nome_forn FROM fornecedores");
                    ?>
                    <select class="form-control" name="idfornecedores">
                        <option>SELECIONE</option>
                        <?php
                        foreach ($ReadForn->getResult() as $e):
                            extract($e);
                            echo "<option value='{$idfornecedores}'>{$idfornecedores} - {$nome_forn}</option>";
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>* Marca</label>
                    <input type="text" name="marca_prod" class="form-control">
                </div>
                <div class="form-group col-md-3">
                    <label>Fabricante</label>
                    <input type="text" name="fabricante_prod" class="form-control">
                </div>
                <div class="form-group col-md-2">
                    <label>Peso</label>
                    <input type="text" name="peso_prod" class="form-control peso">
                </div>
                <div class="form-group col-md-2">
                    <label>Cor</label>
                    <input type="text" name="cor_prod" class="form-control">
                </div>
                <div class="form-group col-md-2">
                    <label>Tamanho</label>
                    <select class="form-control" name="tamanho_prod">
                        <option></option>
                        <option>PP</option>
                        <option>P</option>
                        <option>M</option>
                        <option>G</option>
                        <option>GG</option>
                        <option>EG</option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label>Número</label>
                    <input type="text" name="numero_prod" class="form-control" maxlength="3">
                </div>
                <div class="form-group col-md-2">
                    <label>Data Entrada</label>
                    <input type="date" name="dt_entr_prod" class="form-control">
                </div>
                <div class="form-group col-md-2">
                    <label>Data de Validade</label>
                    <input type="date" name="validade_prod" class="form-control">
                </div>
                <div class="form-group col-md-4">
                    <label>Contra indicações</label>
                    <input type="text" name="con_indicacao_prod" class="form-control">
                </div>
                <div class="form-group col-md-2">
                    <label>* Qtd. Estoque</label>
                    <input type="number" name="quant_estoque" class="form-control" onkeypress="if (!isNaN(String.fromCharCode(window.event.keyCode))) return true; else return false;" required>
                </div>
                <div class="form-group col-md-3">
                    <label>* Valor</label>
                    <input type="text" name="valor_prod" class="form-control moeda" placeholder="R$" required>
                </div>

                <div class="form-group col-md-12">
                    <label>Observações</label>
                    <textarea name="obs_prod" class="form-control"></textarea>
                </div>
                <div class="form-group col-md-12">
                    <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i> Cadastrar</button>
                </div>
            </form>
        </div>

        <!--Modal de UPDATE de Produto-->
        <div class="col-md-12 modal-update">
            <form action="" method="POST" class="j-form-update-produto">
                <input type="hidden" name="callback" value="update-produto" />
                <input type="hidden" name="idprodutos" value="">
                <div class="container">
                    <h5 class="obrigatorios">* Campos obrigatórios</h5>
                </div>
                <div class="form-group col-md-6">
                    <label>* Nome</label>
                    <input type="text" name="nome_prod" class="form-control" required>
                </div>
                <div class="form-group col-md-3">
                    <label>* Categoria</label>
                    <?php
                    $ReadCatProd = new Read;
                    $ReadCatProd->FullRead("SELECT idcate_produto, descricao FROM cat_produto");
                    ?>
                    <select class="form-control" name="idcate_produto">
                        <option>SELECIONE</option>
                        <?php
                        foreach ($ReadCatProd->getResult() as $e):
                            extract($e);
                            echo "<option value='{$idcate_produto}'>{$idcate_produto} - {$descricao}</option>";
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>* Fornecedor</label>
                    <?php
                    $ReadForn = new Read;
                    $ReadForn->FullRead("SELECT idfornecedores, nome_forn FROM fornecedores");
                    ?>
                    <select class="form-control" name="idfornecedores">
                        <option>SELECIONE</option>
                        <?php
                        foreach ($ReadForn->getResult() as $e):
                            extract($e);
                            echo "<option value='{$idfornecedores}'>{$idfornecedores} - {$nome_forn}</option>";
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>* Marca</label>
                    <input type="text" name="marca_prod" class="form-control">
                </div>
                <div class="form-group col-md-3">
                    <label>Fabricante</label>
                    <input type="text" name="fabricante_prod" class="form-control">
                </div>
                <div class="form-group col-md-2">
                    <label>Peso</label>
                    <input type="text" name="peso_prod" class="form-control peso">
                </div>
                <div class="form-group col-md-2">
                    <label>Cor</label>
                    <input type="text" name="cor_prod" class="form-control">
                </div>
                <div class="form-group col-md-2">
                    <label>Tamanho</label>
                    <select class="form-control" name="tamanho_prod">
                        <option></option>
                        <option>PP</option>
                        <option>P</option>
                        <option>M</option>
                        <option>G</option>
                        <option>GG</option>
                        <option>EG</option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label>Número</label>
                    <input type="text" name="numero_prod" class="form-control" maxlength="3">
                </div>
                <div class="form-group col-md-2">
                    <label>Data Entrada</label>
                    <input type="date" name="dt_entr_prod" class="form-control">
                </div>
                <div class="form-group col-md-2">
                    <label>Data de Validade</label>
                    <input type="date" name="validade_prod" class="form-control">
                </div>
                <div class="form-group col-md-4">
                    <label>Contra indicações</label>
                    <input type="text" name="con_indicacao_prod" class="form-control">
                </div>
                <div class="form-group col-md-2">
                    <label>* Qtd. Estoque</label>
                    <input type="number" name="quant_estoque" class="form-control" onkeypress="if (!isNaN(String.fromCharCode(window.event.keyCode))) return true; else return false;" required>
                </div>
                <div class="form-group col-md-3">
                    <label>* Valor</label>
                    <input type="text" name="valor_prod" class="form-control moeda" placeholder="R$" required>
                </div>
                <div class="form-group col-md-12">
                    <label>Observações</label>
                    <textarea name="obs_prod" class="form-control"></textarea>
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
                    <th>Qtd. Estoque</th>
                    <th>Categoria</th>
                    <th>Fornecedor</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="j-result-produtos">
                <?php
                $ReadProd = new Read;
                $ReadProd->FullRead("SELECT produtos.idprodutos, cat_produto.descricao, fornecedores.nome_forn, produtos.nome_prod, estoq_prod.quant_estoque "
                        . "FROM produtos "
                        . "INNER JOIN cat_produto ON cat_produto.idcate_produto = produtos.idcate_produto "
                        . "INNER JOIN fornecedores ON fornecedores.idfornecedores = produtos.idfornecedores "
                        . "INNER JOIN estoq_prod ON estoq_prod.idprodutos = produtos.idprodutos");
                foreach ($ReadProd->getResult() as $e):
//                    var_dump($ReadProd->getResult()); die;
                    extract($e);
                    echo
                    "<tr id='{$idprodutos}'>" .
                    "<td>{$idprodutos}</td>" .
                    "<td>{$nome_prod}</td>" .
                    "<td>{$quant_estoque}</td>" .
                    "<td>{$descricao}</td>" .
                    "<td>{$nome_forn}</td>" .
                    "<td align='right'>" .
                    "<button class='btn btn-success btn-xs open-modal-update j-open-modal-update-produto' idprodutos='{$idprodutos}'><i class='glyphicon glyphicon-edit'></i></button> " .
                    "</td>" .
                    "</tr>";
                endforeach;
                ?>
            </tbody>
        </table>
    </div>
</div>


