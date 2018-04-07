<!--MENU:-->
<?php require REQUIRE_PATH . '/menu.php'; ?>
<!--FIM MENU-->
<div class="col-md-10 modals">
    <br>
    <h2>Exercícios</h2>
    <div>
        <div class="col-md-12" align="right">
            <form action="" method="POST">
                <div class="form-group col-md-4">
                    <input type="text" placeholder="Pesquisar" class="form-control pesquisar pesquisar-exercicio">
                </div>
            </form>
            <button type="button" class="btn btn-primary open-modal-create"><i class="glyphicon glyphicon-plus"></i> Novo Registro</button>
            <button type="button" class="btn btn-danger close-modal-create"><i class="glyphicon glyphicon-remove"></i></button>
            <button type="button" class="btn btn-danger close-modal-update"><i class="glyphicon glyphicon-remove"></i></button>
            <a class="relatorio-geral" href="http://localhost/academia/Views/view.exercicios.relatorio.php" target="_blank"><button class="btn btn-warning"><i class="glyphicon glyphicon-print"></i> Relatório Geral</button></a>
        </div>

        <div class="form-group col-md-12 mensagens-retorno">
            <div class='alert alert-success'>
                <a href="#" class="close" data-dismiss="alert" arua-label="close">x</a>
                Cadastro realizado com sucesso!
            </div>
        </div>

        <!--FORMULÁRIO DE CADASTRO DE EXERCICIOS-->
        <div class="col-md-12 modal-create">
            <form action="" method="POST" class="form_exercicio form-create j-form-create-exercicio">
                <input type="hidden" name="callback" value="create-exercicio">
                <div class="container">
                    <h5 class="obrigatorios">* Campos obrigatórios</h5>
                </div>
                <div class="form-group col-md-6">
                    <label>*Descrição</label>
                    <input type="text" name="descricao_exe" class="form-control" required>
                </div>
                <div class="form-group col-md-3">
                    <label>*Grupo Muscular</label>
                    <input type="text" name="grupo_muscular_exe" class="form-control" required>
                </div>
                <div class="form-group col-md-12">
                    <button type="submit" name="" value="Cadastrar" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i> Atualizar</button>
                </div>
            </form>
        </div>

        <!--FORMULÁRIO DE UPDATE DE EXERCICIOS-->
        <div class="col-md-12 modal-update">
            <form action="" method="POST" name="form_exercicio" class="j-form-update-exercicio">
                <input type="hidden" name="callback" value="update-exercicio">
                <input type="hidden" name="idexercicios" value="">
                <div class="container">
                    <h5 class="obrigatorios">* Campos obrigatórios</h5>
                </div>
                <div class="form-group col-md-6">
                    <label>*Descrição</label>
                    <input type="text" name="descricao_exe" class="form-control" required>
                </div>
                <div class="form-group col-md-3">
                    <label>*Grupo Muscular</label>
                    <input type="text" name="grupo_muscular_exe" class="form-control" required>
                </div>
                <div class="form-group col-md-12">
                    <button type="submit" name="" value="Cadastrar" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i> Atualizar</button>
                </div>
            </form>
        </div>

        <table class="table table-striped modal-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descrição</th>
                    <th>Grupo Muscular</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="j-result-exercicios">
                <?php
                $ReadExercicios = new Read;
                $ReadExercicios->FullRead("SELECT * FROM exercicios");
                foreach ($ReadExercicios->getResult() as $e):
                    extract($e);
                    echo "<tr id='{$idexercicios}'>"
                    . "<td>{$idexercicios}</td>"
                    . "<td>{$descricao_exe}</td>"
                    . "<td>{$grupo_muscular_exe}</td>"
                    . "<td align='right'>"
                    . "<button class='btn btn-success btn-xs open-modal-update j-open-modal-update-exercicio' idexercicios='{$idexercicios}'><i class='glyphicon glyphicon-edit'></i></button> "
                    . "</td>"
                    . "</tr>";
                endforeach;
                ?>
            </tbody>
        </table>
    </div>
</div>
</div>

</div>
