<!--MENU:-->
<?php require REQUIRE_PATH . '/menu.php'; ?>
<?php
$ReadPlanos = new Read;
$ReadPlanos->ExeRead("planos");
?>
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
        <button type="button" class="btn btn-danger close-modal-update"><i class="glyphicon glyphicon-remove"></i></button>
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

    <!--FORMULÁRIO DE UPDATE DE MENSALIDADE-->
    <div class="col-md-12 modal-update">
        <form class="form-mensalidade j-form-update-mensalidade" action="" method="POST">
            <input type="hidden" name="callback" value="update-mensalidade">
            <input type="hidden" name="idmensalidade" value="">
            <div class="form-group col-md-3">
                <label>Plano de Mensalidade</label>
                <select name="idplano" class="form-control">
                    <?php
                    foreach ($ReadPlanos->getResult() as $i) :
                        extract($i);
                    echo "<option value='{$idplano}'>{$nome_plano}</option>";
                    endforeach;
                    ?>
                </select>
            </div>
            <div class="form-group col-md-3">
                <label>Data de Pagamento</label>
                <input type="date" name="data_mens_pag" class="form-control" required>
            </div>
            <div class="form-group col-md-12">
                <button name="Cadastrar" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i> Atualizar</button>
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
                <th>Último Pagamento</th>
            </tr>
        </thead>
        <tbody class="j-result-mensalidades">
            <?php
            $ReadMensalidadePaga = new Read;
            $ReadMensalidadePaga->FullRead("SELECT mensalidades.idmensalidade, alunos_cliente.idalunos_cliente ,alunos_cliente.nome_aluno, mensalidades.data_mens_pag, mensalidades.status_mens "
                . "FROM mensalidades "
                . "INNER JOIN alunos_cliente ON mensalidades.idalunos_cliente = alunos_cliente.idalunos_cliente "
                . "ORDER BY mensalidades.data_mens_pag");
            foreach ($ReadMensalidadePaga->getResult() as $e) :
                extract($e);
                // BUSCANDO DATA DO ÚLTIMO PAGAMENTO:
                $histPag = new Read;
                $histPag->FullRead("SELECT historicos_mensalidades.data_mens_pag "
                . "FROM historicos_mensalidades "
                . "INNER JOIN alunos_cliente ON alunos_cliente.idalunos_cliente = historicos_mensalidades.idalunos_cliente "
                . "WHERE alunos_cliente.idalunos_cliente = {$idalunos_cliente} "
                . "ORDER BY historicos_mensalidades.data_mens_pag DESC "
                . "LIMIT 1");
                $dtPago = $histPag->getResult();
                $dtPagoTratada = ($dtPago ? Check::DataBrasil($dtPago[0]['data_mens_pag']) : "Nenhum");
                // INSERINDO CADA LINHA DA TABELA:
                if ($status_mens == 'Em Aberto') :
                    echo "<tr id='{$idmensalidade}'>" .
                    "<td>{$idalunos_cliente}</td>" .
                    "<td>{$nome_aluno}</td>" .
                    "<td id='proximo_pag{$idmensalidade}'>" . Check::DataBrasil($data_mens_pag) . "</td>" .
                    "<td  id='status{$idmensalidade}' class='blue'>{$status_mens}</td>" .
                    "<td id='ultimo_pag{$idmensalidade}'>{$dtPagoTratada}</td>" .
                    "<td align='right'>" .
                    "<button class='btn btn-success btn-xs open-modal-update j-open-modal-update-mensalidade' idmensalidade='{$idmensalidade}'><i class='glyphicon glyphicon-edit'></i></button></a> " .
                    "<button class='btn btn-danger btn-xs estornar-pagamento'><i class='glyphicon glyphicon glyphicon-retweet'></i> Estorno</button></a> " .
                    "<button class='btn btn-primary btn-xs gerar-pagamento' j-id-mensalidade='{$idmensalidade}'><i class='glyphicon glyphicon-shopping-cart'></i> Gerar Pagamento</button></a>" .
                    "</td>" .
                    "</tr>";
                elseif ($status_mens == 'Vencido') :
                    echo "<tr id='{$idmensalidade}'>" .
                    "<td>{$idalunos_cliente}</td>" .
                    "<td>{$nome_aluno}</td>" .
                    "<td id='proximo_pag{$idmensalidade}'>" . Check::DataBrasil($data_mens_pag) . "</td>" .
                    "<td  id='status{$idmensalidade}' class='red'>{$status_mens}</td>" .
                    "<td id='ultimo_pag{$idmensalidade}'>{$dtPagoTratada}</td>" .
                    "<td align='right'>" .
                    "<button class='btn btn-success btn-xs open-modal-update j-open-modal-update-mensalidade' idmensalidade='{$idmensalidade}'><i class='glyphicon glyphicon-edit'></i></button></a> " .
                    "<button class='btn btn-danger btn-xs estornar-pagamento'><i class='glyphicon glyphicon glyphicon-retweet'></i> Estorno</button></a> " .
                    "<button class='btn btn-primary btn-xs gerar-pagamento' j-id-mensalidade='{$idmensalidade}'><i class='glyphicon glyphicon-shopping-cart'></i> Gerar Pagamento</button></a>" .
                    "</td>" .
                    "</tr>";
                else :
                    echo "<tr id='{$idmensalidade}'>" .
                    "<td>{$idalunos_cliente}</td>" .
                    "<td>{$nome_aluno}</td>" .
                    "<td id='proximo_pag{$idmensalidade}'>" . Check::DataBrasil($data_mens_pag) . "</td>" .
                    "<td  id='status{$idmensalidade}' class='orange'>{$status_mens}</td>" .
                    "<td id='ultimo_pag{$idmensalidade}'>{$dtPagoTratada}</td>" .
                    "<td align='right'>" .
                    "<button class='btn btn-success btn-xs open-modal-update j-open-modal-update-mensalidade' idmensalidade='{$idmensalidade}'><i class='glyphicon glyphicon-edit'></i></button></a> " .
                    "<button class='btn btn-danger btn-xs estornar-pagamento'><i class='glyphicon glyphicon glyphicon-retweet'></i> Estorno</button></a> " .
                    "<button class='btn btn-primary btn-xs gerar-pagamento' j-id-mensalidade='{$idmensalidade}'><i class='glyphicon glyphicon-shopping-cart'></i> Gerar Pagamento</button></a>" .
                    "</td>" .
                    "</tr>";
                endif;

            endforeach;
            ?>
        </tbody>
    </table>
</div>