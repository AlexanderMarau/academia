//INICIAR JQUERY:
$(function () {
    //A FUNÇÃO ABAIXO EVITA QUE AO TECLAR ENTER O INPUT DE PESQUISA FAÇA UMA NOVA REQUISIÇÃO HTTP
    $('.pesquisar-anamnese').on('keypress', function (e) {
        return e.which !== 13;
    });
    //FUNÇÃO RESPONSAVEL POR FAZER CONSULTAS DE ACORDO COM A PESQUISA DO USUÁRIO
    $(".pesquisar-anamnese").keyup(function () {
        var termo = $(".pesquisar-anamnese").val();
        if (termo === '') {
            termo = '0';
        }
        $.ajax({
            url: "Controllers/controller.anamnese.php",
            data: termo,
            type: 'POST',
            dataType: 'json',
            beforeSend: function (xhr) {

            },
            success: function (data) {
                $('.j-result-anamneses').html('');
                $(data).each(function (index, value) {
                    $('.j-result-anamneses').append(
                            "<tr id='" + value.idanamneses + "'>" +
                            "<td>" + value.idanamneses + "</td>" +
                            "<td>" + value.idalunos_cliente + "</td>" +
                            "<td>" + value.nome_aluno + "</td>" +
                            "<td align='right'>" +
                            "<button class='btn btn-success btn-xs open-modal-update j-open-modal-update-anamnese' idanamneses='" + value.idanamneses + "'><i class='glyphicon glyphicon-edit'></i></button> " +
                            "<a href='http://localhost/academia/Views/view.anamnese.relatorio.php' target='_blank'><button class='btn btn-warning btn-xs open-imprimir'><i class='glyphicon glyphicon-print'></i></button></a> " +
                            "<button class='btn btn-danger btn-xs open-delete j-btn-del-anamnese' idanamneses='" + value.idanamneses + "'><i class='glyphicon glyphicon-trash'></i></button>" +
                            "</td>" +
                            "</tr>"
                            );
                });
            }
        });
    });


    //FUNÇÃO RESPONSÁVEL POR CADASTRAR UMA NOVA ANAMNESE NO BANCO DE DADOS:
    $(".j-form-create-anamnese").submit(function () {
        //VARIVEL FORM RECEBE O PROPRIO FORMULÁRIO USANDO O METODO DO JQUERY "THIS":
        var Form = $(this);
        //VARIAVEL ACTION RECEBE O VALOR DO CALLBACK QUE É UM INPUT ESCONDIDO NO FORMULÁRIO ESSE CALLBACK SERVE COMO GATILHO PARA CONDIÇÕES:
        var Action = Form.find('input[name="callback"]').val();
        //VARIAVEL DATA RECEBE UMA MATRIZ COM OS DADOS DO FORMULÁRIO (FORM) INDICE E VALOR:
        var Data = Form.serialize();

        //INICIAÇÃO DO AJAX - PARA ENVIAR E RECEBER DADOS:
        $.ajax({
            //URL É O CAMINHO QUE ESTÁ A CONTROLLER, ONDE SERÃO ENVIADOS OS DADOS DO FORMULÁRIO (FORM -> DATA):
            url: "Controllers/controller.anamnese.php",
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
                if (data.novaanamnese) {
                    var novaAnamnese = data.novaanamnese;
                    $('.j-result-anamneses').prepend(
                            "<tr id='" + novaAnamnese.idanamneses + "' class='animated zoomInDown'>" +
                            "<td>" + novaAnamnese.idanamneses + "</td>" +
                            "<td>" + novaAnamnese.idalunos_cliente + "</td>" +
                            "<td>" + novaAnamnese.nome_aluno + "</td>" +
                            "<td align='right'>" +
                            "<button class='btn btn-success btn-xs open-modal-update j-update-anamnese j-open-modal-update-anamnese' idanamneses='" + novaAnamnese.idanamneses + "'><i class='glyphicon glyphicon-edit'></i></button> " +
                            "<a href='http://localhost/academia/Views/view.anamnese.relatorio.php' target='_blank'><button class='btn btn-warning btn-xs open-imprimir'><i class='glyphicon glyphicon-print'></i></button></a> " +
                            "<button class='btn btn-danger btn-xs open-delete j-btn-del-anamnese' idanamneses='" + novaAnamnese.idanamneses + "'><i class='glyphicon glyphicon-trash'></i></button>" +
                            "</td>" +
                            "</tr>"
                            );
                    setTimeout(function () {
                        $("tr[id='" + novaAnamnese.idanamneses + "']:first").removeClass("animated zoomInDown");
                    }, 1000);
                }
            }
        });

        //RETURN É A FUNÇÃO PARA NÃO PERMITIR QUE O FORMULÁRIO GERE AÇÃO:
        return false;
    });

    //    FUNÇÃO RESPONSÁVEL POR ATUALIZAR OS DADOS DE UMA ANAMNESE NO BANCO DE DADOS:
    $('.j-form-update-anamnese').submit(function () {
        var Form = $(this);
        var Data = Form.serialize();

        $.ajax({
            url: "Controllers/controller.anamnese.php",
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
                    var anamneseEditada = data.content;
                    //FUNÇÃO RESPONSÁVEL POR OCULTAR DO DOM O REGISTRO QUE FOI EDITADO COM EFEITO ANIMATE E POIS FADEOUT, POIS O EFEITO DO ANIMTE GERA UM CSS COMO 'display: hidden' E NÃO 'display: none', E DEIXA ESPAÇO NO HTML, POR ISSO O USO DA FUNÇÃO 'fadeOut()' POSTERIORMENTE.
                    $('html').find("tr[id='" + anamneseEditada.idanamneses + "']").addClass("animated zoomOutDown").fadeOut(720);
                    //FUNÇÃO RESPONSÁVEL POR INSERIR NO DOM O NOVO ALUNO CADASTRADO. *IMPORTANTE USAR O PARÂMETRO ':first' PARA QUE O JQUERY COLOQUE O NOVO ALUNO ACIMA DO ANTIGO REGISTRO, CASO NÃO TENHA O PARÂMETRO O MESMO ALUNO EDITADO PODERÁ SER INSERIDO NO DOM MAIS DE UMA VEZ.
                    $("tr[id='" + anamneseEditada.idanamneses + "']:first").before(
                            "<tr id='" + anamneseEditada.idanamneses + "' class='animated zoomInDown'>" +
                            "<td>" + anamneseEditada.idanamneses + "</td>" +
                            "<td>" + anamneseEditada.idalunos_cliente + "</td>" +
                            "<td>" + anamneseEditada.nome_aluno + "</td>" +
                            "<td align='right'>" +
                            "<button class='btn btn-success btn-xs open-modal-update j-update-anamnese j-open-modal-update-anamnese' idanamneses='" + anamneseEditada.idanamneses + "'><i class='glyphicon glyphicon-edit'></i></button> " +
                            "<a href='http://localhost/academia/Views/view.anamnese.relatorio.php' target='_blank'><button class='btn btn-warning btn-xs open-imprimir'><i class='glyphicon glyphicon-print'></i></button></a> " +
                            "<button class='btn btn-danger btn-xs open-delete j-btn-del-anamnese' idanamneses='" + anamneseEditada.idanamneses + "'><i class='glyphicon glyphicon-trash'></i></button>" +
                            "</td>" +
                            "</tr>"
                            );
                    //ESSA FUNÇÃO EVITA QUE AO ADICIONAR UM NOVO USUÁRIO DIFERENTE GERE EFEITOS EM ELEMENTOS QUE JÁ FORAM CADASTRADOS ANTES.
                    setTimeout(function () {
                        $("tr[id='" + anamneseEditada.idanamneses + "']:first").removeClass("animated zoomInDown");
                    }, 1000);
                }
            }
        });

        return false;
    });

    //FUNÇÃO RESPONSÁVEL POR DELETAR REGISTROS DE ANAMNESES NO BANCO DE DADOS.
    $('html').on('click', '.j-btn-del-anamnese', function () {
        var delButton = $(this);
        var idanamneses = $(delButton).attr('idanamneses');
        var Dados = {callback: 'delete-anamnese', idanamneses: idanamneses};
        $.ajax({
            url: "Controllers/controller.anamnese.php",
            data: Dados,
            type: 'POST',
            dataType: 'json',
            beforeSend: function (xhr) {
            },
            success: function (data) {
                if (data.delete) {
                    $('html').find("tr[id='" + data.idanamneses + "']").addClass("animated zoomOutDown").fadeOut(720);
                }
            }
        });
    });

//FUNÇÃO PARA PREENCHER A DIV DE ATUALIZAÇÃO DE CADASTRO COM OS DADOS DE CADA ANAMNESE:
    $('html').on('click', '.j-open-modal-update-anamnese', function () {
        var button = $(this);
        var idanamneses = $(button).attr('idanamneses');
        var dados_edit = {callback: 'povoar-edit', idanamneses: idanamneses};
        $.ajax({
            url: "Controllers/controller.anamnese.php",
            data: dados_edit,
            type: 'POST',
            dataType: 'json',
            beforeSend: function (xhr) {

            },
            success: function (data) {
                var Form = $('.j-form-update-anamnese');
                $.each(data, function (key, value) {
                    Form.find("input[name='" + key + "'], select[name='" + key + "'], textarea[name='" + key + "']").val(value);
                });
            }
        });
    });

    //FUNÇÃO PARA CALCULAR IMC NA MODAL CREATE:
    $('.j-form-create-anamnese').on('focus', "#imc_anamnese", function () {
        var peso = $("#peso_anamnese").val();
        var altura = $("#altura_anamnese").val();
        var calculo = peso / (altura * altura);
        var imc = calculo.toFixed(0);
        $("#imc_anamnese").val(imc);
    });
    //FUNÇÃO PARA CALCULAR IMC NA MODAL UPDATE:
    $('.j-form-update-anamnese').on('focus', "#imc_anamnese_edit", function () {
        var peso = $('#peso_anamnese_edit').val();
        var altura = $("#altura_anamnese_edit").val();
        var calculo = peso / (altura * altura);
        var imc = calculo.toFixed(0);
        $("#imc_anamnese_edit").val(imc);
    });

});


