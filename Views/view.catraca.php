<link rel="shortcut icon" href="http://localhost/academia/Views/img/ticket-liberado.png">
<div class="container">
    <h3 class="catraca-titulo">Sistema de catraca</h3>
    <div class="col-md-12">
        <!--Cadastro de Registro-->
        <div class="catraca-well well well-sm col-md-4">
            <form action="" method="POST" class="form-create j-form-create-registro">
                <input type="hidden" name="callback" value="create-registro">
                <div class=" col-md-12 input-group-sm">
                    <label>Insira a matricula para efetuar Entrada</label>
                    <input type="number" name="idaluno_clientes" class="form-control" placeholder="Nº da matricula" required>
                </div>
                <div class="form-group col-md-6 input-group-sm">
                    <input type="hidden" name="data_registro">
                </div>
                <div class="form-group col-md-6 input-group-sm">
                    <input type="hidden" name="hr_entrada_catraca">
                </div>
                <div class="form-group col-md-6 input-group-sm">
                    <input type="hidden" name="hr_saida_catraca">
                </div>
                <div class="col-md-12 input-group-sm">
                    <button type="submit" class="btn-entrar btn btn-success"><i class="glyphicon glyphicon-log-in"></i></button>
                </div>
            </form>
        </div>
        <!--Imagem da Catraca-->
        <div class="col-md-4">
            <div class="catraca">
                <img class="img-catraca" src="http://localhost/academia/Views/img/logocatraca.jpg">
            </div>
            <div class="load-catraca">
                <img src="http://localhost/academia/Views/img/load.gif">
            </div>

        </div>
        <!--Div para Sair-->
        <div class="catraca-well col-md-4 well well-sm">
            <form action="" method="POST" class="j-form-update-registro">
                <input type="hidden" name="callback" value="sair-catraca">
                <div class="form-group col-md-12 input-group-sm">
                    <label>Insira a matricula para efetuar Saida</label>
                    <input type="number" name="idaluno_clientes" class="form-control" placeholder="Nº da matricula" required>
                </div>
                <div class="form-group col-md-6 input-group-sm">
                    <input type="hidden" name="hr_saida_catraca">
                </div>
                <div class="col-md-12 input-group-sm">
                    <button type="submit" class="btn-sair btn btn-danger"><i class="glyphicon glyphicon-log-out"></i></button>
                </div>
            </form>
        </div>
        <!--Mensagens de Alerta-->
        <div class="col-md-4 mensagens-retorno">
            <div class="alert alert-danger">
                <img class="img-bloqueio" src="http://localhost/academia/Views/img/ticket-bloqueado.png">
                <a href="#" class="close" data-dismiss="alert" arua-label="close">x</a>
                <p><b>Aluno com parcelas vencidas, favor efetue o pagamento no caixa para liberar o acesso!</b></p>
            </div>
            <div class="alert alert-warning">
                <img class="img-alerta" src="http://localhost/academia/Views/img/ticket-alerta.png">
                <a href="#" class="close" data-dismiss="alert" arua-label="close">x</a>
                <p><b>Aluno com parcelas pendentes, favor efetue o pagamento para evitar o bloqueio!</b></p>
            </div>
            <div class="alert alert-info">
                <img class="img-alerta" src="http://localhost/academia/Views/img/ticket-alerta.png">
                <a href="#" class="close" data-dismiss="alert" arua-label="close">x</a>
                <p><b>Aluno já está dentro da academia, insira outra matricula!</b></p>
            </div>
            <div class='alert alert-success'>
                <img class="img-liberado" src="http://localhost/academia/Views/img/ticket-liberado.png">
                <a href="#" class="close" data-dismiss="alert" arua-label="close">x</a>
                <p><b>Aluno com parcelas em dia, bom treino!</b></p>
            </div>
            <div class="alert alert-saiu">
                <img class="img-liberado" src="http://localhost/academia/Views/img/icon-sair.png">
                <a href="#" class="close" data-dismiss="alert" arua-label="close">x</a>
                <p><b>Aluno saiu da academia!</b></p>
            </div>
            <div class="alert alert-fora">
                <img class="img-liberado" src="http://localhost/academia/Views/img/proibido.png">
                <a href="#" class="close" data-dismiss="alert" arua-label="close">x</a>
                <p><b>Aluno não está na academia!</b></p>
            </div>
            <div class="alert alert-inesistente">
                <img class="img-liberado" src="http://localhost/academia/Views/img/proibido.png">
                <a href="#" class="close" data-dismiss="alert" arua-label="close">x</a>
                <p><b>Aluno não existe!</b></p>
            </div>
        </div>
    </div>

    <div style="margin-top: 80px;" class="col-md-12">
        <h3>Registros do dia</h3>

        <div class="tabela-resultado">
            <table class="catraca-table table table-striped">
                <thead class="tabela-titulo">
                    <tr>
                        <th>Matricula</th>
                        <th>Aluno</th>
                        <th>Hr. de entrada</th>
                        <th>Hr. de saida</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    date_default_timezone_set('America/Sao_Paulo');
                    $data_registro_dia = date("Y:m:d");
                    
                    $readRegistros = new Read;
                    $readRegistros->FullRead("SELECT alunos_cliente.idalunos_cliente, alunos_cliente.nome_aluno, registros_catraca.idregistros_catraca, registros_catraca.hr_entrada_catraca, registros_catraca.hr_saida_catraca, registros_catraca.data_registro " .
                            "FROM registros_catraca " .
                            "INNER JOIN alunos_cliente ON registros_catraca.idaluno_clientes = alunos_cliente.idalunos_cliente ".
                            "WHERE registros_catraca.data_registro = '{$data_registro_dia}' "
                            );
                    foreach ($readRegistros->getResult() as $e):
                        extract($e);
                        date_default_timezone_set('America/Sao_Paulo');
                        $hr_saida = date("H:i:s");
                        echo "<tr id='{$idregistros_catraca}'>" .
                        "<td>{$idalunos_cliente}</td>".        
                        "<td>{$nome_aluno}</td>" .
                        "<td>{$hr_entrada_catraca}</td>" .
                        "<td>{$hr_saida_catraca}</td>" .
                        "<td>{$data_registro}</td>" .
                        "</tr>";
                    endforeach;
                    ?>
                </tbody>
            </table>
        </div>        
    </div>
</div>

