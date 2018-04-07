//INICIAR JQUERY:
$(function () {

    //A FUNÇÃO ABAIXO EVITA QUE AO TECLAR ENTER O INPUT DE PESQUISA FAÇA UMA NOVA REQUISIÇÃO HTTP
    $('.pesquisar-mensalidade').on('keypress', function (e) {
        return e.which !== 13;
    });
    //FUNÇÃO RESPONSÁVEL POR FAZER CONSULTAS DE ACORDO COM PESQUISAS DO USUÁRIO:
    $(".pesquisar-mensalidade").keyup(function () {
        var termo = $(".pesquisar-mensalidade").val();
        if (termo === '') {
            termo = '0';
        }
        $.ajax({
            url: "Controllers/controller.mensalidade.php",
            data: termo,
            type: 'POST',
            dataType: 'json',
            beforeSend: function (xhr) {

            },
            success: function (data) {
                $(".j-result-menssalidades").html("");
                $(data).each(function (index, value) {
                    $(".j-result-menssalidades").append(
                            "<tr id='" + value.idmensalidades + "'>" +
                            "<td>" + value.idalunos_cliente + "</td>" +
                            "<td>" + value.nome_aluno + "</td>" +
                            "<td>R$ " + value.valor_mensalidades + "</td>" +
                            "<td>" + value.data_mens_pag + "</td>" +
                            "<td>" + value.status_mensalidades + "</td>" +
                            "<td align='right'>" +
                            "<button class='btn btn-success btn-xs open-modal-update j-open-modal-update-mensalidade' idmensalidades='" + value.idmensalidades + "'><i class='glyphicon glyphicon-edit'></i></button></a> " +
                            "<button class='btn btn-primary btn-xs open-modal-pagamento' disabled><i class='glyphicon glyphicon-shopping-cart'></i> Gerar Pagamento</button></a>" +
                            "</td>" +
                            "</tr>"
                            );
                });
            }
        });
    });




//    SELECIONAR O FORMULARIO AO SER SUBMETIDO USANDO UMA CLASSE PARA IDENTIFICAR O FORMULÁRIO:
    $(".j-form-create-mensalidade").submit(function () {
//        VARIAVEL FORM RECEBE O PROPRIO FORMULARIO USANDO O METODO DO JQUERY "THIS":
        var Form = $(this);
//        VARIAVEL ACTION RECEBE O VALOR DO CALLBACK QUE É UM INPUT ESCONDIDO NO FORMULARIO ESSE CALLBACK SERVE COMO GATILHO PARA CONDIÇÕES:
        var Action = Form.find('input[name="callback"]').val();
//        VARIAVEL DATA RECEBE UMA MATRIZ COM OS DADOS DO FORMULARIO (FORM) INDICE E VALOR:
        var Data = Form.serialize();

//        INICIAÇÃO DO AJAX - PARA ENVIAR E RECEBER DADOS:
        $.ajax({
//            URL É O CAMINHO QUE ESTÁ A CONTROLLER, ONDE SERÃO ENVIADOS OS DADOS DO FORMULARIO (FORM -> DATA):
            url: "Controllers/controller.mensalidade.php",
//            DATA SÃO OS DADOS QUE SERÃO ENVIADOS:
            data: Data,
//            TYPE É O MÉTODO USADO PARA O ENVIO DOS DADOS:
            type: 'POST',
//            DATATYPE É O TIPO DE DADOS TRAFÉGADOS:
            dataType: 'json',
//            BEFORE SEND É A FUNÇÃO QUE PERMITE EXECUTAR UM ALGORITMO DO JQUERY ANTES DOS DADOS SEREM ENVIADOS:
            beforeSend: function (xhr) {

            },
//            SUCCESS É A FUNÇÃO DO AJAX RESPONSÁVEL POR EXECUTAR ALGORITMOS DEPOIS QUE OS DADOS RETORNAM DA CONTROLLER, TAIS DADOS PODEM SER ACESSADOS PELA VARIAVEL "(data)":
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
                if (data.novamens) {
                    var novaMens = data.novamens;
                    $('.j-result-menssalidades').prepend(
                            "<tr id='" + novaMens.idmensalidades + "' class='animated zoomInDown'>" +
                            "<td>" + novaMens.idmensalidades + "</td>" +
                            "<td>" + novaMens.nome_aluno + "</td>" +
                            "<td>R$ " + novaMens.valor_mensalidades + "</td>" +
                            "<td>" + novaMens.data_mens_pag + "</td>" +
                            "<td>" + novaMens.status_mensalidades + "</td>" +
                            "<td align='right'>" +
                            "<button class='btn btn-success btn-xs open-modal-update j-open-modal-update-mensalidade' idmensalidades='" + novaMens.idmensalidades + "'><i class='glyphicon glyphicon-edit'></i></button> " +
                            "<button class='btn btn-primary btn-xs open-modal-pagamento'><i class='glyphicon glyphicon-shopping-cart'></i> Gerar Pagamento</button>" +
                            "</td>" +
                            "</tr>"
                            );
                    setTimeout(function () {
                        $("tr[id='" + novaMens.idmensalidades + "']:first").removeClass("animated zoomInDown");
                    }, 1000);
                }
            }
        });
//        RETURN É A FUNÇÃO PARA NÃO PERMITIR QUE O FORMULÁRIO GERE AÇÃO: 
        return false;
    });

    //    FUNÇÃO RESPONSÁVEL POR ATUALIZAR OS DADOS DE UMA MENSALIDADE NO BANCO DE DADOS:
    $('.j-form-update-mensalidade').submit(function () {
        var Form = $(this);
        var Data = Form.serialize();

        $.ajax({
            url: "Controllers/controller.mensalidade.php",
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
                    var mensalidadeEditada = data.content;
                    //FUNÇÃO RESPONSÁVEL POR OCULTAR DO DOM O REGISTRO QUE FOI EDITADO COM EFEITO ANIMATE E POIS FADEOUT, POIS O EFEITO DO ANIMTE GERA UM CSS COMO 'display: hidden' E NÃO 'display: none', E DEIXA ESPAÇO NO HTML, POR ISSO O USO DA FUNÇÃO 'fadeOut()' POSTERIORMENTE.
                    $('html').find("tr[id='" + mensalidadeEditada.idmensalidades + "']").addClass("animated zoomOutDown").fadeOut(720);
                    //FUNÇÃO RESPONSÁVEL POR INSERIR NO DOM O NOVO ALUNO CADASTRADO. *IMPORTANTE USAR O PARÂMETRO ':first' PARA QUE O JQUERY COLOQUE O NOVO ALUNO ACIMA DO ANTIGO REGISTRO, CASO NÃO TENHA O PARÂMETRO O MESMO ALUNO EDITADO PODERÁ SER INSERIDO NO DOM MAIS DE UMA VEZ.
                    $("tr[id='" + mensalidadeEditada.idmensalidades + "']:first").before(
                            "<tr id='" + mensalidadeEditada.idmensalidades + "' class='animated zoomInDown'>" +
                            "<td>" + mensalidadeEditada.idmensalidades + "</td>" +
                            "<td>" + mensalidadeEditada.nome_aluno + "</td>" +
                            "<td>R$ " + mensalidadeEditada.valor_mensalidades + "</td>" +
                            "<td>" + mensalidadeEditada.data_mens_pag + "</td>" +
                            "<td>" + mensalidadeEditada.status_mensalidades + "</td>" +
                            "<td align='right'>" +
                            "<button class='btn btn-success btn-xs open-modal-update j-open-modal-update-mensalidade' idmensalidades='" + mensalidadeEditada.idmensalidades + "'><i class='glyphicon glyphicon-edit'></i></button></a> " +
                            "<button class='btn btn-primary btn-xs open-modal-pagamento'><i class='glyphicon glyphicon-shopping-cart'></i> Gerar Pagamento</button></a>" +
                            "</td>" +
                            "</tr>"
                            );
                    //ESSA FUNÇÃO EVITA QUE AO ADICIONAR UM NOVO USUÁRIO DIFERENTE GERE EFEITOS EM ELEMENTOS QUE JÁ FORAM CADASTRADOS ANTES.
                    setTimeout(function () {
                        $("tr[id='" + mensalidadeEditada.idmensalidades + "']:first").removeClass("animated zoomInDown");
                    }, 1000);
                }
            }
        });

        return false;
    });

    //FUNÇÃO PARA PREENCHER A DIV DE ATUALIZAÇÃO DE CADASTRO COM OS DADOS DE CADA MENSALIDADES:
    $('html').on('click', '.j-open-modal-update-mensalidade', function () {
        var button = $(this);
        var idmensalidades = $(button).attr('idmensalidades');
        var dados_edit = {callback: 'povoar-edit', idmensalidades: idmensalidades};
        $.ajax({
            url: "Controllers/controller.mensalidade.php",
            data: dados_edit,
            type: 'POST',
            dataType: 'json',
            beforeSend: function (xhr) {

            },
            success: function (data) {
                var Form = $('.j-form-update-mensalidade');
                $.each(data, function (key, value) {
                    Form.find("input[name='" + key + "'], select[name='" + key + "'], textarea[name='" + key + "']").val(value);
                });
            }
        });
    })

});