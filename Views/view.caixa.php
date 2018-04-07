<!--MENU:-->
<?php require REQUIRE_PATH . '/menu.php'; ?>
<!--FIM MENU-->
<div class="container">
    <h2>Caixa</h2>
    <table class=" table table-striped">
        <thead>
            <tr>
                <th>Registro</th>
                <th>Descrição</th>
                <th>Data da Entrada</th>
                <th>Valor</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>01</td>
                <td>Venda</td>
                <td>08/09/2017</td>
                <td>R$ 100,00</td>
                <td><a href="#"><button class="btn btn-warning btn-xs">Deletar</button></a></td>
            </tr>
        </tbody>
    </table>
    <h4>Resumo do Caixa</h4>
    <table class=" table table-striped">
        <thead>
            <tr>
                <th>Dinheiro</th>
                <th>Cheque</th>
                <th>C. Debito</th>
                <th>C. Crédito</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>R$ 100,00</td>
                <td>R$ 00,00</td>
                <td>R$ 10,00</td>
                <td>R$ 10,00</td>
                <td>R$ 120,00</td>
            </tr>
        </tbody>
    </table>
</div>