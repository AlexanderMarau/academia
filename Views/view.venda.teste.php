<?php require REQUIRE_PATH . '/menu.php'; ?>

<div class="container">
    <br>
    <h2>Vendas</h2>
    <div class="well col-md-6">
        <form>
            <div class="form-group col-md-6">
                <label>Cliente</label>
                <select class="form-control" name="">
                    <option>SELECIONE</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label>Produto</label>
                <select class="form-control" name="">
                    <option>SELECIONE</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label>Valor do Produto</label>
                <input type="text" name="" class="form-control" placeholder="R$" disabled>
            </div>
            <div class="form-group col-md-6">
                <label>Descontos</label>
                <input type="text" name="" class="form-control" placeholder="R$">
            </div>
            <div class="form-group col-md-6">
                <label>Juros</label>
                <input type="text" name="" class="form-control" placeholder="R$">
            </div>
            <div class="form-group col-md-6">
                <label>Valor Total do item</label>
                <input type="text" name="" class="form-control" placeholder="R$" disabled>
            </div>
            <div class="form-group col-md-6">
                <button name="" type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Adicionar</button>
            </div>
        </form>
    </div>
    <div class="form-group col-md-1"></div>
    <div class="form-group col-md-5">
        <div class="">
            <table class="table table-striped">
                <tr>
                    <th>ID</th>
                    <th>Descrição</th>
                    <th>Valor</th>
                </tr>
                <tr>
                    <td>01</td>
                    <td>TESTE</td>
                    <td>R$ 99,00</td>
                </tr>
                <tr>
                    <td>01</td>
                    <td>TESTE</td>
                    <td>R$ 99,00</td>
                </tr>
                <tr>
                    <td>01</td>
                    <td>TESTE</td>
                    <td>R$ 99,00</td>
                </tr>
                <tr>
                    <td>01</td>
                    <td>TESTE</td>
                    <td>R$ 99,00</td>
                </tr>
                <tr>
                    <td>01</td>
                    <td>TESTE</td>
                    <td>R$ 99,00</td>
                </tr>
                <tr>
                    <td>01</td>
                    <td>TESTE</td>
                    <td>R$ 99,00</td>
                </tr>
                <tr>
                    <td>01</td>
                    <td>TESTE</td>
                    <td>R$ 99,00</td>
                </tr>
                <tr>
                    <td>01</td>
                    <td>TESTE</td>
                    <td>R$ 99,00</td>
                </tr>
            </table>
            <h2><b>Valor Total:</b> R$ 100,00</h2>
        </div>
        <form>
            <div class="form-group">
                <hr>
                <button name="" type="submit" class="btn btn-success"><i class="glyphicon glyphicon-shopping-cart"></i> Confirmar</button>
                <button class="btn btn-danger"><i class='glyphicon glyphicon-trash'></i> Cancelar Venda</button>
            </div>
        </form>
    </div>
</div>

