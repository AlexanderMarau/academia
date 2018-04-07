$(function(){
    
    //A FUNÇÃO ABAIXO EVITA QUE AO TECLAR ENTER O INPUT DE PESQUISA FAÇA UMA NOVA REQUISIÇÃO HTTP
    $('.pesquisar-venda').on('keypress', function (e) {
        return e.which !== 13;
    });
    //FUNÇÃO RESPONSAVEL POR FAZER CONSULTAS DE ACORDO COM A PESQUISA DO USUÁRIO
    $(".pesquisar-venda").keyup(function () {
        var termo = $(".pesquisar-venda").val();
        if (termo === '') {
            termo = '0';
        }
        $.ajax({
            url: "Controllers/controller.venda.php",
            data: termo,
            type: 'POST',
            dataType: 'json',
            beforeSend: function (xhr) {

            },
            success: function (data) {
                $('.j-result-vendas').html('');
                $(data).each(function (index, value) {
                    $('.j-result-vendas').append(
                            "<tr id='" + value.idvendas + "'>" +
                            "<td>" + value.idvendas + "</td>" +
                            "<td>" + value.data_venda + "</td>" +
                            "<td>" + value.nome_usuario + "</td>" +
                            "<td>" + value.nome_aluno + "</td>" +
                            "<td>" + value.itens_total + "</td>" +
                            "<td>" + value.valor_total + "</td>" +
                            "<td align='right'>" +
                           "<a href='http://localhost/academia/Views/view.venda.comprovante.php?idvendas="+ value.idvendas +"' target='_blank'><button class='btn btn-warning btn-xs open-imprimir'><i class='glyphicon glyphicon-print'></i></button></a>"+
                            "</td>" +
                            "</tr>"
                            );
                });
            }
        });
    });
    
    //FUNÇÃO RESPONSÁVEL POR RECONHECER O ID DO ESTOQUE AO QUAL O PRODUTO SELECIONADO FAZ PARTE:
    // ALÉM DISSO TAMBÉM É RESPONSÁVEL POR LIBERAR O INPUT DA QUANTIDADE APENAS DEPOIS DE SELECIONADO UM PRODUTO PARA A VENDA
    $(".j-form-carrinho-venda").on("change", "#idprodutos", function(){
        var idprodutos = $("#idprodutos").val();
        var callback = "buscar-estoque-produto";
        $.post("Controllers/controller.venda.php", {idprodutos: idprodutos, callback: callback}, function(data){
            if(data.trigger){
                alert(data.trigger);
                $("select[name='idprodutos']").val($("select[name='idprodutos'] option:first-child").val());
            }else{
                var idestoques = data.idestoques;
                var quant_estoque = data.quant_estoque;
                var valor_prod = data.valor_prod;
                $(".j-form-carrinho-venda").find("input[name='idestoques']").val(idestoques);
                $(".j-form-carrinho-venda").find("input[name='quant_estoque']").val(quant_estoque);
                $(".j-form-carrinho-venda").find("input[name='valor_prod']").val(valor_prod);
                $(".j-form-carrinho-venda").find("input[name='qt_vendas']").val('');
                $(".j-form-carrinho-venda").find("input[name='valor_vendas']").val('');
                $(".j-form-carrinho-venda").find("input[name='qt_vendas']").prop('readonly', false);
            }
        }, 'json');
    });

    //FUNÇÃO RESPONSÁVEL POR VERIFICAR SE A QUANTIDADE DO PRODUTO A SER VENDIDO É IGUAL OU MENOR A QUANTIDADE EM ESTOQUE. 
    //ESSA FUNÇÃO TAMBÉM ATUALIZA O PREÇO FINAL DA VENDA DE ACORDO COM A QUANTIDADE CONFIGURADA NA VENDA.
    $(".j-form-carrinho-venda").on("keyup change", "input[name='qt_vendas']", function(){
        var form = $(".j-form-carrinho-venda");
        var qt_vendas = form.find("input[name='qt_vendas']").val();
        var quant_estoque = form.find("input[name='quant_estoque']").val();
        var total = quant_estoque - qt_vendas;
        var valor_vendas = parseInt(qt_vendas) * parseFloat(form.find("input[name='valor_prod']").val());
   
        if(total <= -1){
            alert("Você não possui essa quantidade de produtos em Estoque, Atualmente o estoque possui: " + quant_estoque + " unidade(s) desse produto.");
            $(".j-form-carrinho-venda").find("input[name='qt_vendas']").val('');
            form.find("input[name='valor_vendas']").val('');
        }else if(qt_vendas < 1){
            alert("A Quantidade digitada é inválida");
            $(".j-form-carrinho-venda").find("input[name='qt_vendas']").val('');
            form.find("input[name='valor_vendas']").val('');
        }else{
            form.find("input[name='valor_vendas']").val(valor_vendas);
        }  
        
    });
    
    //FUNÇÃO RESPONSÁVEL POR ADICIONAR O ITEM AO CARRINHO:
    $(".j-form-carrinho-venda").submit(function () {
        var form = $(this);
        var Data = form.serialize();
        $.ajax({
            url: "Controllers/controller.venda.php",
            data: Data,
            type: 'POST',
            dataType: 'json',
            beforeSend: function (xhr) {
                
            },
            success: function (data) {
                if(data.trigger){
                    alert(data.trigger);
                }
                if(data.sucesso){
                    form.trigger('reset');
                    $(".j-form-carrinho-venda").find("input[name='qt_vendas']").prop('readonly', true);
                }
                if(data.item_info){
                    var item_info = data.item_info;
                    $('.j-carrinho-lista').prepend("<tr>" + 
                            "<td>" + item_info.idprodutos + "</td>" +
                            "<td>" + item_info.nome_prod + "</td>" +
                            "<td>" + item_info.qt_vendas + "</td>" +
                            "<td>" + item_info.valor_vendas + ",00</td>" +
                            "</tr>"
                            );
                }
                if(data.valor_total){
                    $("#total_carrinho").html("R$ " + data.valor_total + ",00");
                }
            }
        });
        return false;
    });
    
//    FUNÇÃO RESPONSÁVEL POR CANCELAR UMA VENDA:
    $("#cancelar-venda").click(function (){
        var callback = 'cancelar-venda';
        $.post("Controllers/controller.venda.php", {callback: callback, cancelar: true}, function(data){
            console.log(data);
            if(data.trigger){
                alert(data.trigger);
            }
            if(data.sucesso){
                alert(data.content);
                $('.j-carrinho-lista').html('');
                $('#total_carrinho').html('');
                $('.j-form-create-venda').find("select[name='idalunos_cliente']").val($("select[name='idalunos_cliente'] option:first-child").val());
            }
            
        }, 'json');
        return false;
    });
    
    //FUNÇÃO RESPONSÁVEL POR CADASTRAR UMA NOVA VENDA NO BANCO DE DADOS:
    $(".j-form-create-venda").submit(function () {
        //VARIVEL FORM RECEBE O PROPRIO FORMULÁRIO USANDO O METODO DO JQUERY "THIS":
        var Form = $(this);
        var Data = Form.serialize();

        //INICIAÇÃO DO AJAX - PARA ENVIAR E RECEBER DADOS:
        $.ajax({
            //URL É O CAMINHO QUE ESTÁ A CONTROLLER, ONDE SERÃO ENVIADOS OS DADOS DO FORMULÁRIO (FORM -> DATA):
            url: "Controllers/controller.venda.php",
            //DATA SÃO OS DADOS QUE SERÃO ENVIADOS:
            data: Data,
            //TYPE É O TIPO USADO PARA O ENVIO DOS DADOS:
            type: 'POST',
            //DATATYPE É O TIPO DE DADOS TRAFÉGADOS:
            dataType: 'json',
            //BEFORE SEND É A FUNÇÃO QUE PERMITE EXECUTAR UM ALGORITMO DO JQUERY ANTES DOS DADOS SEREM ENVIADOS:
            beforeSend: function (xhr) {
            },
            //SUCCESS É A FUNÇÃO DO AJAX RESPONSÁVEL POR EXECUTAR ALGORITMOS DEPOIS QUE OS DADOS RETORNAM DA CONTROLLER, TAIS DADOS PODEM SER ACESSADOS PELA VARIAVEL "(data)":
            success: function (data) {
                if(data.trigger){
                    alert(data.trigger);
                }
                if(data.sucesso){
                    alert(data.mensagem);
                    $('.j-carrinho-lista').html('');
                    $('#total_carrinho').html('');
                    $('.j-form-create-venda').find("select[name='idalunos_cliente']").val($("select[name='idalunos_cliente'] option:first-child").val());
                    $('#fechar-carrinho-venda').click(function (){
                        window.location.replace("http://localhost/academia/view.venda");
                    });
                }
            }
        });

        //RETURN É A FUNÇÃO PARA NÃO PERMITIR QUE O FORMULÁRIO GERE AÇÃO:
        return false;
    });
});