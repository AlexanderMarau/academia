//INICIAR JQUERY:
$(function () {

    //A FUNÇÃO ABAIXO EVITA QUE AO TECLAR ENTER O INPUT DE PESQUISA FAÇA UMA NOVA REQUISIÇÃO HTTP
    $('.pesquisar-plano').on('keypress', function (e) {
        return e.which !== 13;
    });

    //FUNÇÃO RESPONSÁVEL POR FAZER CONSULTAS DE ACORDO COM PESQUISAS DO USUÁRIO:
    $(".pesquisar-plano").keyup(function () {
        var termo = $(".pesquisar-plano").val();
        if (termo === '') {
            termo = '0';
        }
        $.ajax({
            url: "Controllers/controller.plano.php",
            data: termo,
            type: 'POST',
            dataType: 'json',
            beforeSend: function (xhr) {

            },
            success: function (data) {
                $(".j-result-planos").html('');
                $(data).each(function (index, value) {
                    $(".j-result-planos").append(
                            "<tr id='" + value.idplano + "'>" +
                            "<td>" + value.idplano + "</td>" +
                            "<td>" + value.nome_plano + "</td>" +
                            "<td>" + value.tipo_plano + "</td>" +
                            "<td>" + value.valor_plano + "</td>" +
                            "<td align='right'>" +
                            "<button class='btn btn-success btn-xs open-modal-update' idplano='"+ value.idplano +"'><i class='glyphicon glyphicon-edit'></i></button> " +
                            "<button class='btn btn-danger btn-xs open-delete' idplano='"+ value.idplano +"'><i class='glyphicon glyphicon-trash'></i></button>" +
                            "</td>"+
                            "</tr>"
                            );
                });
            }
        });
    });


//    SELECIONAR O FORMULARIO AO SER SUBMETIDO USANDO UMA CLASSE PARA IDENTIFICAR O FORMULÁRIO:
    $(".j-form-create-plano").submit(function () {
//        VARIAVEL FORM RECEBE O PROPRIO FORMULARIO USANDO O METODO DO JQUERY "THIS":
        var Form = $(this);
//        VARIAVEL ACTION RECEBE O VALOR DO CALLBACK QUE É UM INPUT ESCONDIDO NO FORMULARIO ESSE CALLBACK SERVE COMO GATILHO PARA CONDIÇÕES:
        var Action = Form.find('input[name="callback"]').val();
//        VARIAVEL DATA RECEBE UMA MATRIZ COM OS DADOS DO FORMULARIO (FORM) INDICE E VALOR:
        var Data = Form.serialize();

//        INICIAÇÃO DO AJAX - PARA ENVIAR E RECEBER DADOS:
        $.ajax({
//            URL É O CAMINHO QUE ESTÁ A CONTROLLER, ONDE SERÃO ENVIADOS OS DADOS DO FORMULARIO (FORM -> DATA):
            url: "Controllers/controller.plano.php",
//            DATA SÃO OS DADOS QUE SERÃO ENVIADOS:
            data: Data,
//            TYPE É O MÉTODO USADO PARA O ENVIO DOS DADOS:
            type: 'POST',
//            DATATYPE É O TIPO DE DADOS TRAFÉGADOS:
            dataType: 'json',
//            BEFORE SEND É A FUNÇÃO QUE PERMITE EXECUTAR UM ALGORITMO DO JQUERY ANTES DOS DADOS SEREM ENVIADOS:
            beforeSend: function (xhr) {
//                PODE-SE NESSA PARTE MOSTRAR E RETIRAR POR EXEMPLO ELEMENTOS DO HTML:
                //alert('enviou');
            },
//            SUCCESS É A FUNÇÃO DO AJAX RESPONSÁVEL POR EXECUTAR ALGORITMOS DEPOIS QUE OS DADOS RETORNAM DA CONTROLLER, TAIS DADOS PODEM SER ACESSADOS PELA VARIAVEL "(data)":
            success: function (data) {
                if (data.sucesso) {
                    $('.alert-success').fadeIn();
                }
                if (data.clear) {
                    Form.trigger('reset');
                }
                $('.modal-create').fadeOut(0);
                $('.close-modal-create').fadeOut(0);
                $('.open-modal-create').fadeIn(0);
                $('.relatorio-geral').fadeIn(0);
                $('.pesquisar').fadeIn(0);
                $('.modal-table').fadeIn(0);

                if (data.novoplano) {
                    var novoPlano = data.novoplano;
                    $('.j-result-planos').prepend(
                            "<tr id='" + novoPlano.idplano + "'>" +
                            "<td>" + novoPlano.idplano + "</td>" +
                            "<td>" + novoPlano.nome_plano + "</td>" +
                            "<td>" + novoPlano.tipo_plano + "</td>" +
                            "<td>" + novoPlano.valor_plano + "</td>" +
                            "<td align='right'>" +
                            "<button class='btn btn-success btn-xs open-modal-update' idplano='"+ novoPlano.idplano +"'><i class='glyphicon glyphicon-edit'></i></button> " +
                            "<button class='btn btn-danger btn-xs open-delete' idplano='"+ novoPlano.idplano +"'><i class='glyphicon glyphicon-trash'></i></button>" +
                            "</td>"+
                            "</tr>"
                            );
                    setTimeout(function () {
                        $("tr[id='" + novoPlano.idplano + "']:first").removeClass("animated zoomInDown");
                    }, 1000);
                }
            }
        });

//        RETURN É A FUNÇÃO PARA NÃO PERMITIR QUE O FORMULÁRIO GERE AÇÃO: 
        return false;
    });

    //    FUNÇÃO RESPONSÁVEL POR ATUALIZAR OS DADOS DE UMA PLANO NO BANCO DE DADOS:
    $('.j-form-update-plano').submit(function () {
        var Form = $(this);
        var Data = Form.serialize();

        $.ajax({
            url: "Controllers/controller.plano.php",
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
                    var planoEditado = data.content;
                    //FUNÇÃO RESPONSÁVEL POR OCULTAR DO DOM O REGISTRO QUE FOI EDITADO COM EFEITO ANIMATE E POIS FADEOUT, POIS O EFEITO DO ANIMTE GERA UM CSS COMO 'display: hidden' E NÃO 'display: none', E DEIXA ESPAÇO NO HTML, POR ISSO O USO DA FUNÇÃO 'fadeOut()' POSTERIORMENTE.
                    $('html').find("tr[id='" + planoEditado.idplano + "']").addClass("animated zoomOutDown").fadeOut(720);
                    //FUNÇÃO RESPONSÁVEL POR INSERIR NO DOM O NOVO ALUNO CADASTRADO. *IMPORTANTE USAR O PARÂMETRO ':first' PARA QUE O JQUERY COLOQUE O NOVO ALUNO ACIMA DO ANTIGO REGISTRO, CASO NÃO TENHA O PARÂMETRO O MESMO ALUNO EDITADO PODERÁ SER INSERIDO NO DOM MAIS DE UMA VEZ.
                    $("tr[id='" + planoEditado.idplano + "']:first").before(
                            "<tr id='" + planoEditado.idplano + "'>" +
                            "<td>" + planoEditado.idplano + "</td>" +
                            "<td>" + planoEditado.nome_plano + "</td>" +
                            "<td>" + planoEditado.tipo_plano + "</td>" +
                            "<td>" + planoEditado.valor_plano + "</td>" +
                            "<td align='right'>" +
                            "<button class='btn btn-success btn-xs open-modal-update j-open-modal-update-plano' idplano='"+ planoEditado.idplano +"'><i class='glyphicon glyphicon-edit'></i></button> " +
                            "<button class='btn btn-danger btn-xs open-delete' idplano='"+ planoEditado.idplano +"'><i class='glyphicon glyphicon-trash'></i></button>" +
                            "</td>"+
                            "</tr>"
                            );
                    //ESSA FUNÇÃO EVITA QUE AO ADICIONAR UM NOVO USUÁRIO DIFERENTE GERE EFEITOS EM ELEMENTOS QUE JÁ FORAM CADASTRADOS ANTES.
                    setTimeout(function () {
                        $("tr[id='" + planoEditado.idplano + "']:first").removeClass("animated zoomInDown");
                    }, 1000);
                }
            }
        });

        return false;
    });


    //FUNÇÃO PARA PREENCHER A DIV DE ATUALIZAÇÃO DE CADASTRO COM OS DADOS DE CADA PLANO:
    $('html').on('click', '.j-open-modal-update-plano', function () {
        var button = $(this);
        var idplano = $(button).attr('idplano');
        var dados_edit = {callback: 'povoar-edit', idplano: idplano};
        $.ajax({
            url: "Controllers/controller.plano.php",
            data: dados_edit,
            type: 'POST',
            dataType: 'json',
            beforeSend: function (xhr) {

            },
            success: function (data) {
                var Form = $('.j-form-update-plano');
                $.each(data, function (key, value) {
                    Form.find("input[name='" + key + "'], select[name='" + key + "'], textarea[name='" + key + "']").val(value);
                });
            }
        });
    });
    
    //FUNÇÃO RESPONSÁVEL POR DELETAR REGISTROS DE PLANOS NO BANCO DE DADOS.
    $('html').on('click', '.j-btn-del-plano', function () {
        var delButton = $(this);
        var idplano = $(delButton).attr('idplano');
        var Dados = {callback: 'delete-plano', idplano: idplano};
        $.ajax({
            url: "Controllers/controller.plano.php",
            data: Dados,
            type: 'POST',
            dataType: 'json',
            beforeSend: function (xhr) {
            },
            success: function (data) {
                if (data.delete) {
                    $('html').find("tr[id='" + data.idplano + "']").addClass("animated zoomOutDown").fadeOut(720);
                }
            }
        });
    });

});


