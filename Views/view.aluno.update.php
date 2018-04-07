<!--MENU:-->
<?php require REQUIRE_PATH . '/menu.php';  ?>
<!--FIM MENU-->
<div class="container">
    <!--Mensagens de Alerta-->
    <div class="alert alert-success">Cadastro realizado com sucesso!</div>
    <div class="alert alert-warning">Atenção! exitem campos obrigatórios em branco.</div>
    <div class="alert alert-danger">Erro ao realizar cadastro, consulte o administrador.</div>

    <h2>Editar dados do Aluno</h2>

    <form action="" method="">
        <div class="form-group col-md-6">
            <label>Nome</label>
            <input type="text" name="" class="form-control" value="Diego Humberto">
        </div>
        <div class="form-group col-md-3">
            <label>CPF</label>
            <input type="text" name="" class="form-control" value="898.908.909-80">
        </div>
        <div class="form-group col-md-3">
            <label>RG</label>
            <input type="text" name="" class="form-control" value="099.098-00">
        </div>
        <div class="form-group col-md-6">
            <label>Nome da Mãe</label>
            <input type="text" name="" class="form-control" value="Maria Clara">
        </div>
        <div class="form-group col-md-6">
            <label>Nome do Pai</label>
            <input type="text" name="" class="form-control" value="João Silva">
        </div>
        <div class="form-group col-md-6">
            <label>E-mail</label>
            <input type="email" name="" class="form-control" value="diego@email.com.br">
        </div>
        <div class="form-group col-md-3">
            <label>Telefone Celular</label>
            <input type="text" name="" class="form-control" value="(62)90000-0000">
        </div>
        <div class="form-group col-md-3">
            <label>Telefone Residencial</label>
            <input type="text" name="" class="form-control" value="(62)90000-0000">
        </div>
        <div class="form-group col-md-2">
            <label>Dt. Nascimento</label>
            <input type="date" name="" class="form-control">
        </div>
        <div class="form-group col-md-2">
            <label>Status</label>
            <select name="" class="form-control">
                <option>Ativo</option>
                <option>Inativo</option>
            </select>
        </div>
        <div class="form-group col-md-2">
            <label>País</label>
            <select name="" class="form-control">
                <option>Brasil</option>
            </select>
        </div>
        <div class="form-group col-md-3">
            <label>Estado</label>
            <select name="" class="form-control">
                <option>Goiás</option>
            </select>
        </div>
        <div class="form-group col-md-3">
            <label>Cidade</label>
            <select name="" class="form-control">
                <option>Aparecida de Goiânia</option>
            </select>
        </div>
        <div class="form-group col-md-12">
            <label>Complemento</label>
            <input type="text" name="" class="form-control" value="Rua nº 12, qd-1- lt-20">
        </div>
        <div class="form-group col-md-12">
            <label>Obs.</label>
            <textarea type="text" name="" class="form-control">Aluno matriculado dia 01/09/2017</textarea>
        </div>
        <div class="form-group col-md-12">
            <button type="submit" name="" class="btn btn-primary">Salvar</button>
        </div>
    </form>
</div>