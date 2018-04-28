<?php
date_default_timezone_set("America/Sao_Paulo");
$data_registro = date("Y-m-d");
$hr_entrada_catraca = date("H:i");
?>
<div class="container">
    <h3 class="catraca-titulo">Sistema de catraca</h3>
    <div class="col-md-12">
        <!--Cadastro de Registro-->
        <div class="catraca-well well well-sm col-md-4">
            <form action="" method="POST" class="j-form-create-registro">
                <input type="hidden" name="callback" value="create-registro">
                <div class=" col-md-12 input-group-sm">
                    <label>Selecione o Aluno</label>
                    <select name="idaluno_clientes" class="form-control">
                        <option selected disabled>SELECIONE</option>
                        <?php
                        $readAlunos = new Read;
                        $readAlunos->ExeRead('alunos_cliente');
                        foreach ($readAlunos->getResult() as $e):
                            extract($e);
                            echo "<option value='{$idalunos_cliente}'>{$idalunos_cliente} - {$nome_aluno}</option>";
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-6 input-group-sm">
                    <label>Data</label>
                    <input type="date" name="data_registro" class="form-control" value="<?php echo $data_registro; ?>" disabled>
                </div>
                <div class="form-group col-md-6 input-group-sm">
                    <label>Hora</label>
                    <input type="time" name="hr_entrada_catraca" class="form-control" disabled value="<?php echo $hr_entrada_catraca; ?>">
                </div>
                <div class="col-md-12 input-group-sm">
                    <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-log-in"></i> Entrar</button>
                </div>
            </form>
        </div>
        <!--Imagem da Catraca-->
        <div class="col-md-4">
            <div class="catraca">
                <img class="img-catraca" src="http://localhost/academia/Views/img/logocatraca.jpg">
            </div>
            <div class="load">
                <img src="http://localhost/academia/Views/img/load.gif">
            </div>

        </div>
        <!--Mensagens de Alerta-->
        <div class="col-md-4 mensagens">
            <div class="alert alert-danger danger">
                <img class="img-bloqueio" src="http://localhost/academia/Views/img/ticket-bloqueado.png">
                <a href="#" class="close" data-dismiss="alert" arua-label="close">x</a>
                <p><b>Aluno com parcelas vencidas, favor efetue o pagamento no caixa para liberar o acesso!</b></p>
            </div>

            <div class="alert alert-warning warning">
                <img class="img-alerta" src="http://localhost/academia/Views/img/ticket-alerta.png">
                <a href="#" class="close" data-dismiss="alert" arua-label="close">x</a>
                <p><b>Aluno com parcelas pendentes, favor efetue o pagamento para evitar o bloqueio!</b></p>
            </div>
            <div class='alert alert-success success'>
                <img class="img-liberado" src="http://localhost/academia/Views/img/ticket-liberado.png">
                <a href="#" class="close" data-dismiss="alert" arua-label="close">x</a>
                <p><b>Aluno com parcelas em dia, bom treino!</b></p>
            </div>
        </div>
    </div>

    <div style="margin-top: 50px;" class="col-md-12">
        <h3>Histórico</h3>
        <form action="" method="POST" class="">
            <div class="form-group-sm col-md-3">
                <input name="" type="text" class="form-control" placeholder="Pesquise pelo Aluno">
            </div>
            <div class="form-group-sm col-md-2">
                <input type="date" name="" class="form-control">
            </div>
            <button type="submit" class="btn-pesquisa btn btn-primary btn-sm">
                <i class="glyphicon glyphicon-search"></i>
            </button>
            <hr>
        </form>
        <div class="tabela-resultado">
            <table class="catraca-table table table-striped">
                <thead class="tabela-titulo">
                    <tr>
                        <th>Aluno</th>
                        <th>Hr. de entrada</th>
                        <th>Hr. de saida</th>
                        <th>Data</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $readRegistros = new Read;
                    $readRegistros->FullRead("SELECT alunos_cliente.nome_aluno, registros_catraca.idregistros_catraca, registros_catraca.hr_entrada_catraca, registros_catraca.hr_saida_catraca, registros_catraca.data_registro " .
                            "FROM registros_catraca " .
                            "INNER JOIN alunos_cliente ON registros_catraca.idaluno_clientes = alunos_cliente.idalunos_cliente " .
                            "ORDER BY registros_catraca.idregistros_catraca");
                    foreach ($readRegistros->getResult() as $e):
                        extract($e);
                        echo "<tr id='{$idregistros_catraca}'>" .
                        "<td>{$nome_aluno}</td>" .
                        "<td>{$hr_entrada_catraca}</td>" .
                        "<td>{$hr_saida_catraca}</td>" .
                        "<td>{$data_registro}</td>" .
                        "<td><button type='submit' class='btn-sair btn btn-xs btn-danger' idregistros_catraca={$idregistros_catraca}><i class='glyphicon glyphicon-log-out'></i> Sair</button></td>" .
                        "</tr>";
                    endforeach;
                    ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

