<!--MENU:-->
<?php require REQUIRE_PATH . '/menu.php'; ?>

<a href="#abrirModal">Abrir</a>

<div id="abrirModal" class="modalDialog">
	<div class="formulario-modal">
		<a href="#close" title="Close" class="close">x</a>
		<h2>Modal</h2>
            <form action="" method="POST" class="form_aluno">
                <input type="hidden" name="callback" value="aluno">
                <div class="">
                    <br>
                    <label>* Nome</label>
                    <input type="text" name="nome_aluno" class="" required>
                </div>
                <div class="">
                    <br>
                    <label>* CPF</label>
                    <input type="text" name="cpf_aluno" class="" id="cpf" required>
                </div>
                <div class="form-group">
                    <br>
                    <label>* RG</label>
                    <input type="text" name="rg_aluno" class="form-control" maxlength="7" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Nome da Mãe</label>
                    <input type="text" name="nome_mae" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label>Nome do Pai</label>
                    <input type="text" name="nome_pai" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label>* E-mail</label>
                    <input type="email" name="email_aluno" class="form-control" required>
                </div>
                <div class="form-group col-md-3">
                    <label>Telefone Celular</label>
                    <input type="text" name="celular_aluno" class="form-control" id="telefoneC">
                </div>
                <div class="form-group col-md-3">
                    <label>Telefone Residencial</label>
                    <input type="text" name="residencial_aluno" class="form-control" id="telefoneR">
                </div>
                <div class="form-group col-md-2">
                    <label>* Dt. Nascimento</label>
                    <input type="date" name="data_nascimento_aluno" class="form-control" required>
                </div>
                <div class="form-group col-md-2">
                    <label>Status</label>
                    <select name="status_aluno" class="form-control">
                        <option value="Ativo">Ativo</option>
                        <option value="Inativo">Inativo</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Estado</label>
                    <select name="idestado" class="form-control">
                        <?php
                        foreach ($ReadEstado->getResult() as $i):
                            extract($i);
                            echo "<option value='{$idestado}'>{$uf}</option>";
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-5">
                    <label>Cidade</label>
                    <select name="idcidade" class="form-control">
                        <?php
                        foreach ($ReadCidade->getResult() as $i):
                            extract($i);
                            echo "<option value='{$idcidade}'>{$desc_cidade}</option>";
                        endforeach;
                        ?>
                        <option></option>
                    </select>
                </div>
                <div class="form-group col-md-12">
                    <label>Complemento</label>
                    <input type="text" name="complementos_aluno" class="form-control">
                </div>

                <div class="form-group col-md-12">
                    <label>Obs.</label>
                    <textarea type="text" name="obs_aluno" class="form-control"></textarea>
                </div>
                <div class="form-group col-md-12">
                    <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-disk"></i> Cadastrar</button>
                </div>
            </form>
        </div>		
	</div>
</div>