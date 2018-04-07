<!--MENU:-->
<?php
session_start();
if (!$_SESSION['logado']):
    session_destroy();
    header('Location: view.login');
endif;
require REQUIRE_PATH . '/menu.php';
?>
<!--FIM MENU-->

<div class="col-md-10 modals">
    <br>
    <h2>Vendas</h2>
    <div class="col-md-12" align="right">
        <form action="" method="POST">
            <div class="form-group col-md-4">
                <input type="text" class="form-control pesquisar pesquisar-venda" placeholder="Pesquisar por Nº Venda ou Cliente">
            </div>
        </form>
        <button type="button" class="btn btn-primary open-modal-create"><i class="glyphicon glyphicon-plus"></i> Nova Venda</button>
        <button id="fechar-carrinho-venda" type="button" class="btn btn-danger close-modal-create"><i class="glyphicon glyphicon-remove"></i></button>
        <a class="relatorio-geral" href="http://localhost/academia/Views/view.vendas.relatorio.php" target="_blank"><button type="" class="btn btn-warning"><i class="glyphicon glyphicon-print"></i> Relátorio Geral</button></a>
    </div>

    <div class="modal-create">
        <div class="well col-md-3" style="background-color: #f2f2f2;">
            <h5 class="obrigatorios">* Campos Obrigatórios</h5>
            <form class="j-form-carrinho-venda" action="" method="POST">
                <input type="hidden" name="callback" value="adicionar-carrinho">
                <div class="form-group col-md-12">
                    <label>* Produto</label>
                    <select id="idprodutos" name="idprodutos" class="form-control" required>
                        <option selected disabled>SELECIONE</option>
                        <?php
                        $LerProdutos = new Read;
                        $LerProdutos->FullRead("SELECT produtos.idprodutos, produtos.nome_prod FROM produtos");
                        foreach ($LerProdutos->getResult() as $e):
                            extract($e);
                            echo "<option value='{$idprodutos}'>{$idprodutos} - {$nome_prod}</option>";
                        endforeach;
                        ?>
                    </select>
                </div>
                <input type="hidden" id="idestoques" name="idestoques" value=""/>
                <input type="hidden" id="quant_estoque" name="quant_estoque" value="" disabled/>

                <div class="form-group col-md-12">
                    <label>* Quantidade</label>
                    <input type="number" min="1" name="qt_vendas" class="form-control" onkeypress="if (!isNaN(String.fromCharCode(window.event.keyCode)))
                                return true;
                            else
                                return false;" readonly required>
                </div>

                <div class="form-group col-md-12">
                    <label>Valor do Produto</label>
                    <input type="number" name="valor_prod" class="form-control moeda" placeholder="R$" required readonly="readonly">
                </div>

                <div class="form-group col-md-12">
                    <label>Valor Total</label>
                    <input type="number" name="valor_vendas" class="form-control moeda" placeholder="R$" required readonly="readonly">
                </div>

                <div class="form-group col-md-12">
                    <button name="" type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-shopping-cart"></i> Add no Carrinho</button>
                </div>
            </form>
        </div>

        <div class="col-md-5">
            <form class="j-form-create-venda col-md-12" type="POST" action="" >
                <input type="hidden" name="callback" value="cadastrar-venda" class="form-control"/>
                <input type="hidden" name="hora-abertura-venda" value="<?php echo date('Y-m-d H:i:s'); ?>" class="form-control"/>
                <div class="col-md-12">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Produto</th>
                                <th>Qtd</th>
                                <th>Total R$</th>
                            </tr>
                        </thead>
                        <tbody class="j-carrinho-lista">
                            <?php
                            if (array_key_exists("itens_vendas", $_SESSION)):
                                echo "<script>alert('Atenção: Você Possui Itens No Carrinho Que Ainda Não Foram Vendidos')</script>";
                                foreach ($_SESSION['itens_vendas'] as $e):
                                    extract($e);
                                    echo "<tr>"
                                    . "<td>{$idprodutos}</td>"
                                    . "<td>{$nome_prod}</td>"
                                    . "<td>{$qt_vendas}</td>"
                                    . "<td>{$valor_vendas},00</td>"
                                    . "</tr>"
                                    ;
                                endforeach;
                            endif;
                            ?>
                        </tbody>
                    </table>

                </div>
        </div>
        <div class="well col-md-4" style="background-color: #f2f2f2;">
            <div class="form-group col-md-12">
                <h5 class="obrigatorios">* Campos Obrigatórios</h5>
                <label><span style="color: red;">*</span> Cliente</label>
                <select name="idalunos_cliente" class="form-control" required>
                    <option selected disabled>SELECIONE</option>
                    <?php
                    $LerClientes = new Read;
                    $LerClientes->FullRead("SELECT alunos_cliente.idalunos_cliente, alunos_cliente.nome_aluno FROM alunos_cliente");
                    if ($LerClientes->getResult()):
                        foreach ($LerClientes->getResult() as $i):
                            extract($i);
                            echo "<option value='{$idalunos_cliente}'>{$idalunos_cliente} - {$nome_aluno}</option>";
                        endforeach;
                    endif;
                    ?>
                </select>
            </div>
            <div class="form-group col-md-12">
                <a style="width: 140px;" id="cancelar-venda" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i> Cancelar Venda</a> <button style="width: 140px;" name="" type="submit" class="btn btn-success"><i class="glyphicon glyphicon-circle-arrow-right"></i> Finalizar Venda</button>
            </div>
            <h2 align="center">Total: <span id="total_carrinho"><?php
                    if (array_key_exists("valor_total", $_SESSION)): echo "R$ {$_SESSION['valor_total']},00";
                    endif;
                    ?></span>
            </h2>
            </form>
        </div>


    </div>

    <div class="container" style="margin-top: 70px;">
        <div class="row venda-lista">
            <table class="table table-striped modal-table">
                <thead>
                    <tr>
                        <th>Nº Venda</th>
                        <th>Data - Hora</th>
                        <th>Vendedor</th>
                        <th>Cliente</th>
                        <th>Total Itens</th>
                        <th>Valor Total</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="j-result-vendas">
                    <?php
                    $ReadVenda = new Read;
                    $ReadVenda->FullRead("SELECT vendas.idvendas, vendas.data_venda, usuario.nome_usuario, alunos_cliente.nome_aluno, vendas.itens_total, vendas.valor_total "
                            . "FROM vendas "
                            . "INNER JOIN usuario ON vendas.idusuario = usuario.idusuario "
                            . "INNER JOIN alunos_cliente ON vendas.idalunos_cliente = alunos_cliente.idalunos_cliente "
                            . "ORDER BY vendas.idvendas DESC");
                    foreach ($ReadVenda->getResult() as $vendas):
                        extract($vendas);
                        $data_venda = date('d/m/Y - H:i:s', strtotime($data_venda));
                        echo "<tr id={$idvendas}>"
                        . "<td>{$idvendas}</td>"
                        . "<td>{$data_venda}</td>"
                        . "<td>{$nome_usuario}</td>"
                        . "<td>{$nome_aluno}</td>"
                        . "<td>{$itens_total}</td>"
                        . "<td><b>R$ {$valor_total}</b></td>"
                        . "<td>"
                        . "<a href='http://localhost/academia/Views/view.venda.comprovante.php?idvendas={$idvendas}' target='_blank'><button class='btn btn-warning btn-xs open-imprimir'><i class='glyphicon glyphicon-print'></i></button></a>"
                        . "</td>"
                        . "</tr>";
                    endforeach;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>   

