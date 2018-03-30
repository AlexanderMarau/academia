//INICIAR JQUERY:
$(function () {
//A FUNÇÃO ABAIXO EVITA QUE AO TECLAR ENTER O INPUT DE PESQUISA FAÇA UMA NOVA REQUISIÇÃO HTTP
    $('.pesquisar-produto').on('keypress', function (e) {
        return e.which !== 13;
    });
    //FUNÇÃO RESPONSÁVEL POR FAZER CONSULTAS DE ACORDO COM PESQUISAS DO PRODUTO:
    $('.pesquisar-produto').keyup(function () {
        var termo = $('.pesquisar-produto').val();
        if (termo === '') {
            termo = '0';
        }
        $.ajax({
            url: "Controllers/controller.produto.php",
            data: termo,
            type: 'POST',
            dataType: 'json',
            beforeSend: function (xhr) {

            },
            success: function (data) {
                $('.j-result-produtos').html('');
                $(data).each(function (index, value) {
                    $('.j-result-produtos').append(
                            "<tr id='" + value.idprodutos + "'>" +
                            "<td>" + value.idprodutos + "</td>" +
                            "<td>" + value.nome_prod + "</td>" +
                            "<td>" + value.quant_estoque + "</td>" +
                            "<td>" + value.descricao + "</td>" +
                            "<td>" + value.nome_forn + "</td>" +
                            "<td align='right'>" +
                            "<button class='btn btn-success btn-xs open-modal-update j-open-modal-update-produto' idprodutos='" + value.idprodutos + "'><i class='glyphicon glyphicon-edit'></i></button> " +
                            "</td>" +
                            "</tr>"
                            );
                });
            }
        });
    });

    //FUNÇÃO RESPONSÁVEL POR CADASTRAR UM NOVO PRODUTO NO BANCO DE DADOS:
    $(".j-form-create-produto").submit(function () {
//VARIVEL FORM RECEBE O PROPRIO FORMULÁRIO USANDO O METODO DO JQUERY "THIS":
        var Form = $(this);
        //VARIAVEL ACTION RECEBE O VALOR DO CALLBACK QUE É UM INPUT ESCONDIDO NO FORMULÁRIO ESSE CALLBACK SERVE COMO GATILHO PARA CONDIÇÕES:
        var Action = Form.find('input[name="callback"]').val();
        //VARIAVEL DATA RECEBE UMA MATRIZ COM OS DADOS DO FORMULÁRIO (FORM) INDICE E VALOR:
        var Data = Form.serialize();
        //INICIAÇÃO DO AJAX - PARA ENVIAR E RECEBER DADOS:
        $.ajax({
            //URL É O CAMINHO QUE ESTÁ A CONTROLLER, ONDE SERÃO ENVIADOS OS DADOS DO FORMULÁRIO (FORM -> DATA):
            url: "Controllers/controller.produto.php",
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
                if (data.sucesso) {
                    $('.alert-success').fadeIn();
                }
                if (data.clear) {
                    Form.trigger('reset');
                    $('.modal-create').fadeOut(0);
                    $('.close-modal-create').fadeOut(0);
                    $('.open-modal-create').fadeIn(0);
                    $('.relatorio-geral').fadeIn(0);
                    $('.pesquisar').fadeIn(0);
                    $('.modal-table').fadeIn(0);
                }
                if (data.novoproduto) {
                    var novoproduto = data.novoproduto;
                    $('.j-result-produtos').prepend("<tr id='" + novoproduto.idprodutos + "' class='animated zoomInDown'>" +
                            "<td>" + novoproduto.idprodutos + "</td>" +
                            "<td>" + novoproduto.nome_prod + "</td>" +
                            "<td>" + novoproduto.quant_estoque + "</td>" +
                            "<td>" + novoproduto.descricao + "</td>" +
                            "<td>" + novoproduto.nome_forn + "</td>" +
                            "<td align='right'>" +
                            "<button class='btn btn-success btn-xs open-modal-update j-open-modal-update-produto' idprodutos='" + novoproduto.idprodutos + "'><i class='glyphicon glyphicon-edit'></i></button> " +
                            "</td>" +
                            "</tr>"
                            );
                    setTimeout(function () {
                        $("tr[id='" + novoproduto.idprodutos + "']:first").removeClass("animated zoomInDown");
                    }, 1000);
                }
            }
        });
        return false;
    });

    //FUNÇÃO PARA PREENCHER A DIV DE ATUALIZAÇÃO DE CADASTRO COM OS DADOS DE CADA PRODUTO:
    $('html').on('click', '.j-open-modal-update-produto', function () {
        var button = $(this);
        var idprodutos = $(button).attr('idprodutos');
        var dados_edit = {callback: 'povoar-edit-produto', idprodutos: idprodutos};
        $.ajax({
            url: "Controllers/controller.produto.php",
            data: dados_edit,
            type: 'POST',
            dataType: 'json',
            beforeSend: function (xhr) {
            },
            success: function (data) {
                var Form = $('.j-form-update-produto');
                $.each(data, function (key, value) {
                    Form.find("input[name='" + key + "'], select[name='" + key + "'], textarea[name='" + key + "']").val(value);
                });
            }
        });
    });

    //    FUNÇÃO RESPONSÁVEL POR ATUALIZAR UM PRODUTO NO BANCO DE DADOS:
    $('.j-form-update-produto').submit(function () {
        var Form = $(this);
        var Data = Form.serialize();

        $.ajax({
            url: "Controllers/controller.produto.php",
            data: Data,
            type: 'POST',
            dataType: 'json',
            beforeSend: function (xhr) {
            },
            success: function (data) {
                if (data.clear) {
                    Form.trigger('reset');
                }
                if (data.sucesso) {
                    $('.modal-update').fadeOut(0);
                    $('.close-modal-update').fadeOut(0);
                    $('.pesquisar').fadeIn(0);
                    $('.open-modal-create').fadeIn(0);
                    $('.relatorio-geral').fadeIn(0);
                    $('.modal-table').fadeIn(0);
                }
                if (data.content) {
                    var produtoEditado = data.content;
                    //FUNÇÃO RESPONSÁVEL POR OCULTAR DO DOM O REGISTRO QUE FOI EDITADO COM EFEITO ANIMATE E POIS FADEOUT, POIS O EFEITO DO ANIMTE GERA UM CSS COMO 'display: hidden' E NÃO 'display: none', E DEIXA ESPAÇO NO HTML, POR ISSO O USO DA FUNÇÃO 'fadeOut()' POSTERIORMENTE.
                    $('html').find("tr[id='" + produtoEditado.idprodutos + "']").addClass("animated zoomOutDown").fadeOut(720);
                    //FUNÇÃO RESPONSÁVEL POR INSERIR NO DOM O NOVO ALUNO CADASTRADO. *IMPORTANTE USAR O PARÂMETRO ':first' PARA QUE O JQUERY COLOQUE O NOVO ALUNO ACIMA DO ANTIGO REGISTRO, CASO NÃO TENHA O PARÂMETRO O MESMO ALUNO EDITADO PODERÁ SER INSERIDO NO DOM MAIS DE UMA VEZ.
                    $("tr[id='" + produtoEditado.idprodutos + "']:first").before("<tr id='" + produtoEditado.idprodutos + "' class='animated zoomInDown'>" +
                            "<td>" + produtoEditado.idprodutos + "</td>" +
                            "<td>" + produtoEditado.nome_prod + "</td>" +
                            "<td>" + produtoEditado.quant_estoque + "</td>" +
                            "<td>" + produtoEditado.descricao + "</td>" +
                            "<td>" + produtoEditado.nome_forn + "</td>" +
                            "<td align='right'>" +
                            "<button class='btn btn-success btn-xs open-modal-update j-open-modal-update-produto' idprodutos='" + produtoEditado.idprodutos + "'><i class='glyphicon glyphicon-edit'></i></button> " +
                            "</td>" +
                            "</tr>"
                            );
                    //ESSA FUNÇÃO EVITA QUE AO ADICIONAR UM NOVO USUÁRIO DIFERENTE GERE EFEITOS EM ELEMENTOS QUE JÁ FORAM CADASTRADOS ANTES.
                    setTimeout(function () {
                        $("tr[id='" + produtoEditado.idprodutos + "']:first").removeClass("animated zoomInDown");
                    }, 1000);
                }
            }
        });

        return false;
    });

});