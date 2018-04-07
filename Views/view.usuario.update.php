<!--MENU:-->
<?php require REQUIRE_PATH . '/menu.php'; ?>
<!--FIM MENU-->
<div class="container">
    <h2>Editar Dados do Usuário</h2>
    <form action="" method="">
        <div class="form-group col-md-2">
            <label>ID</label>
            <input type="text" name="" class="form-control" disabled="" value="102">
        </div>
        <div class="form-group col-md-6">
            <label>Nome</label>
            <input type="text" name="" class="form-control">
        </div>
        <div class="form-group col-md-4">
            <label>E-mail</label>
            <input type="email" name="" class="form-control">
        </div>
        <div class="form-group col-md-3">
            <label>Senha</label>
            <input type="password" name="" class="form-control">
        </div>
        <div class="form-group col-md-3">
            <label>Confirme a Senha</label>
            <input type="password" name="" class="form-control">
        </div>
        <div class="form-group col-md-3">
            <label>Perfil</label>
            <select name="" class="form-control">
                <option></option>
                <option>Administrador</option>
                <option>Professor</option>
            </select>
        </div>
        <div class="form-group col-md-3">
            <label>Funcionário</label>
            <select name="" class="form-control">
                <option></option>
            </select>
        </div>
        <div class="form-group col-md-12">
            <button name="" type="submit" class="btn btn-primary">Salvar</button>
        </div>               
    </form>
</div>

