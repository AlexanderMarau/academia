<!--MENU:-->
<?php require REQUIRE_PATH . '/menu.php'; ?>
<!--FIM MENU-->
<div class="col-md-10 modals">
    <br>
    <h2>Anamneses</h2>
    <div>
        <div class="col-md-12" align="right">
            <form action="" method="POST">
                <div class="form-group col-md-4">
                    <input type="text" placeholder="Pesquisar" class="form-control pesquisar pesquisar-anamnese">
                </div>
            </form>

            <button class="btn btn-primary open-modal-create"><i class="glyphicon glyphicon-plus"></i> Novo Registro</button>
            <button class="btn btn-danger close-modal-create" ><i class="glyphicon glyphicon-remove"></i></button>
            <button class="btn btn-danger close-modal-update" ><i class="glyphicon glyphicon-remove"></i></button>
            <a class="relatorio-geral" href="http://localhost/academia/Views/view.anamneses.relatorio.php" target="_blank"><button class="btn btn-warning"><i class="glyphicon glyphicon-print"></i> Relátorio Geral</button></a>
        </div>

        <div class="form-group col-md-12 mensagens-retorno">
            <div class='alert alert-success'>
                <a href="#" class="close" data-dismiss="alert" arua-label="close">x</a>
                Cadastro realizado com sucesso!
            </div>
        </div>

        <!--Modal create de Anamneses-->
        <div class="col-md-12 anamnese-div modal-create">
            <div class="container"><h5 class="obrigatorios">* Campos Obrigatórios</h5></div>
            <!--Form create de Anamneses-->
            <form action="" method="POST" class="form_anamnese form-create j-form-create-anamnese">
                <input type="hidden" name="callback" value="create-anamnese">
                <div class="form-group col-md-6">
                    <br>
                    <label>* Aluno</label>
                    <select name="idalunos_cliente" class="form-control">
                        <option value="0">SELECIONE</option>
                        <?php
                        $ReadAlunos = new Read;
                        $ReadAlunos->ExeRead("alunos_cliente");
                        foreach ($ReadAlunos->getResult() as $e):
                            extract($e);
                            echo "<option value={$idalunos_cliente}>{$idalunos_cliente} - {$nome_aluno}</option>";
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <br>
                    <label>* Peso</label>
                    <input type="number" name="peso_anamnese" id="peso_anamnese" class="form-control input-peso-anamnese" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any">
                </div>
                <div class="form-group col-md-2">
                    <br>
                    <label>* Altura</label>
                    <input type="number" name="altura_anamnese" id="altura_anamnese" class=" form-control input-decimal" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any">
                </div>
                <div class="form-group col-md-2">
                    <br>
                    <label>* IMC</label>
                    <input type="number" name="imc_anamnese" id="imc_anamnese" class="form-control input-decimal" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any">
                </div>
                <div class="form-group col-md-2">
                    <label>Pescoço</label>
                    <input type="number" name="pescoco_anamnese" class="form-control input-decimal" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any">
                </div>
                <div class="form-group col-md-2">
                    <label>Ombro</label>
                    <input type="number" name="ombro_anamnese" class="form-control input-decimal" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any">
                </div>
                <div class="form-group col-md-2">
                    <label>Torax</label>
                    <input type="number" name="torax_anamnese" class="form-control input-decimal" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any">
                </div>
                <div class="form-group col-md-2">
                    <label>Abdome</label>
                    <input type="number" name="abdome_anamnese" class="form-control input-decimal" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any">
                </div>
                <div class="form-group col-md-2">
                    <label>Cintura</label>
                    <input type="number" name="cintura_anamnese" class="form-control input-decimal" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any">
                </div>
                <div class="form-group col-md-2">
                    <label>Quadril</label>
                    <input type="number" name="quadril_anamnese" class="form-control input-decimal" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any">
                </div>
                <div class="form-group col-md-2">
                    <label>Braço D.</label>
                    <input type="number" name="bd_anamnese" class="form-control input-decimal" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any">
                </div>
                <div class="form-group col-md-2">
                    <label>Braço E.</label>
                    <input type="number" name="be_anamnese" class="form-control input-decimal" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any">
                </div>
                <div class="form-group col-md-2">
                    <label>B.E. Contraido</label>
                    <input type="number" name="bec_anamnese" class="form-control input-decimal" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any">
                </div>
                <div class="form-group col-md-2">
                    <label>B.D. Contraido</label>
                    <input type="number" name="bdc_anamnese" class="form-control input-decimal" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any">
                </div>
                <div class="form-group col-md-2">
                    <label>Antebraço E.</label>
                    <input type="number" name="aec_anamnese" class="form-control input-decimal" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any">
                </div>
                <div class="form-group col-md-2">
                    <label>Antebraço D.</label>
                    <input type="number" name="adc_anamnese" class="form-control input-decimal" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any">
                </div>
                <div class="form-group col-md-2">
                    <label>Coxa Esquerda</label>
                    <input type="number" name="ce_anamnese" class="form-control input-decimal" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any">
                </div>
                <div class="form-group col-md-2">
                    <label>Coxa Direita</label>
                    <input type="number" name="cd_anamnese" class="form-control input-decimal" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any">
                </div>
                <div class="form-group col-md-2">
                    <label>Pamturilha E.</label>
                    <input type="number" name="pe_anamnese" class="form-control input-decimal" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any">
                </div>
                <div class="form-group col-md-2">
                    <label>Panturilha D.</label>
                    <input type="number" name="pd_anamnese" class="form-control input-decimal" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any">
                </div>
                <div class="form-group col-md-4">

                </div>
                <div class="form-group col-md-12">
                    <label>Observações</label>
                    <textarea name="obs_anamnese" class="form-control"></textarea>
                </div>
                <div class="form-group col-md-12">
                    <button type="submit" name="cadastrar" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i> Cadastrar</button>
                </div>
            </form>
        </div>

        <!--Modal update de Anamneses-->
        <div class="col-md-12 modal-update">
            <div class="container"><h5 class="obrigatorios">* Campos Obrigatórios</h5></div>
            <!--Form update de Anamneses-->
            <form action="" method="POST" class="j-form-update-anamnese form_anamnese form-update">
                <input type="hidden" name="callback" value="update-anamnese">
                <input type="hidden" name="idanamneses" value="">
                <input type="hidden" name="idalunos_cliente" value="">
                <div class="form-group col-md-6">
                    <br>
                    <label>* Aluno</label>
                    <select name="idalunos_cliente" class="form-control" disabled>
                        <option value="0">SELECIONE</option>
                        <?php
                        $ReadAlunos = new Read;
                        $ReadAlunos->ExeRead("alunos_cliente");
                        foreach ($ReadAlunos->getResult() as $e):
                            extract($e);
                            echo "<option value={$idalunos_cliente}>{$idalunos_cliente} - {$nome_aluno}</option>";
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <br>
                    <label>* Peso</label>
                    <input type="number" name="peso_anamnese" id="peso_anamnese_edit" class="form-control input-peso-anamnese" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any">
                </div>
                <div class="form-group col-md-2">
                    <br>
                    <label>* Altura</label>
                    <input type="number" name="altura_anamnese" id="altura_anamnese_edit" class="form-control input-decimal" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any">
                </div>
                <div class="form-group col-md-2">
                    <br>
                    <label>* IMC</label>
                    <input type="number" name="imc_anamnese" id="imc_anamnese_edit" class="form-control input-decimal" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any">
                </div>
                <div class="form-group col-md-2">
                    <label>Pescoço</label>
                    <input type="number" name="pescoco_anamnese" class="form-control input-decimal" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any">
                </div>
                <div class="form-group col-md-2">
                    <label>Ombro</label>
                    <input type="number" name="ombro_anamnese" class="form-control input-decimal" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any">
                </div>
                <div class="form-group col-md-2">
                    <label>Torax</label>
                    <input type="number" name="torax_anamnese" class="form-control input-decimal" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any">
                </div>
                <div class="form-group col-md-2">
                    <label>Abdome</label>
                    <input type="number" name="abdome_anamnese" class="form-control input-decimal" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any">
                </div>
                <div class="form-group col-md-2">
                    <label>Cintura</label>
                    <input type="number" name="cintura_anamnese" class="form-control input-decimal" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any">
                </div>
                <div class="form-group col-md-2">
                    <label>Quadril</label>
                    <input type="number" name="quadril_anamnese" class="form-control input-decimal" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any">
                </div>
                <div class="form-group col-md-2">
                    <label>Braço D.</label>
                    <input type="number" name="bd_anamnese" class="form-control input-decimal" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any">
                </div>
                <div class="form-group col-md-2">
                    <label>Braço E.</label>
                    <input type="number" name="be_anamnese" class="form-control input-decimal" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any">
                </div>
                <div class="form-group col-md-2">
                    <label>B.E. Contraido</label>
                    <input type="number" name="bec_anamnese" class="form-control input-decimal" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any">
                </div>
                <div class="form-group col-md-2">
                    <label>B.D. Contraido</label>
                    <input type="number" name="bdc_anamnese" class="form-control input-decimal" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any">
                </div>
                <div class="form-group col-md-2">
                    <label>Antebraço E.</label>
                    <input type="number" name="aec_anamnese" class="form-control input-decimal" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any">
                </div>
                <div class="form-group col-md-2">
                    <label>Antebraço D.</label>
                    <input type="number" name="adc_anamnese" class="form-control input-decimal" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any">
                </div>
                <div class="form-group col-md-2">
                    <label>Coxa Esquerda</label>
                    <input type="number" name="ce_anamnese" class="form-control input-decimal" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any">
                </div>
                <div class="form-group col-md-2">
                    <label>Coxa Direita</label>
                    <input type="number" name="cd_anamnese" class="form-control input-decimal" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any">
                </div>
                <div class="form-group col-md-2">
                    <label>Pamturilha E.</label>
                    <input type="number" name="pe_anamnese" class="form-control input-decimal" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any">
                </div>
                <div class="form-group col-md-2">
                    <label>Panturilha D.</label>
                    <input type="number" name="pd_anamnese" class="form-control input-decimal" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any">
                </div>
                <div class="form-group col-md-4">

                </div>
                <div class="form-group col-md-12">
                    <label>Observações</label>
                    <textarea name="obs_anamnese" class="form-control"></textarea>
                </div>
                <div class="form-group col-md-12">
                    <button type="submit" name="cadastrar" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i> Atualizar</button>
                </div>
            </form>
        </div>

        <table class="table table-striped modal-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Matricula</th>
                    <th>Aluno</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="j-result-anamneses">
                <?php
                $ReadAnamnese = new Read;
                $ReadAnamnese->FullRead("SELECT anamneses.idanamneses, anamneses.idalunos_cliente, alunos_cliente.nome_aluno "
                                       . "FROM anamneses "
                                       . "LEFT JOIN alunos_cliente ON anamneses.idalunos_cliente = alunos_cliente.idalunos_cliente");
                foreach ($ReadAnamnese->getResult() as $e):
                    extract($e);
                    echo "<tr id='{$idanamneses}'>" .
                    "<td>{$idanamneses}</td>" .
                    "<td>{$idalunos_cliente}</td>" .
                    "<td>{$nome_aluno}</td>" .
                    "<td align='right'>" .
                    "<button class='btn btn-success btn-xs open-modal-update j-open-modal-update-anamnese' idanamneses={$idanamneses}><i class='glyphicon glyphicon-edit'></i></button> " .
                    "<a href='http://localhost/academia/Views/view.anamnese.relatorio.php?idanamneses={$idanamneses}' target='_blank'><button class='btn btn-warning btn-xs open-imprimir'><i class='glyphicon glyphicon-print'></i></button></a> " .
                    "<button class='btn btn-danger btn-xs open-delete j-btn-del-anamnese' idanamneses={$idanamneses}><i class='glyphicon glyphicon-trash'></i></button>".
                    "</td>" .
                    "</tr>";
                endforeach;
                ?>

            </tbody>
        </table>
    </div>
</div>
