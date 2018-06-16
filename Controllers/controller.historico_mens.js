//INICIAR JQUERY
$(function () {

    $('.form-data-mens').submit(function () {
        var Form = $(this);

        var Action = Form.find('input[name="callback"]').val();

        var Data = Form.serialize();

        $.ajax({
//            URL É O CAMINHO QUE ESTÁ A CONTROLLER, ONDE SERÃO ENVIADOS OS DADOS DO FORMULARIO (FORM -> DATA):
            url: "Controllers/controller.historico_mens.php",
//            DATA SÃO OS DADOS QUE SERÃO ENVIADOS:
            data: Data,
//            TYPE É O MÉTODO USADO PARA O ENVIO DOS DADOS:
            type: 'POST',
//            DATATYPE É O TIPO DE DADOS TRAFÉGADOS:
            dataType: 'json',
//            BEFORE SEND É A FUNÇÃO QUE PERMITE EXECUTAR UM ALGORITMO DO JQUERY ANTES DOS DADOS SEREM ENVIADOS:
            beforeSend: function (xhr) {
//                PODE-SE NESSA PARTE MOSTRAR E RETIRAR POR EXEMPLO ELEMENTOS DO HTML:
            },
//            SUCCESS É A FUNÇÃO DO AJAX RESPONSÁVEL POR EXECUTAR ALGORITMOS DEPOIS QUE OS DADOS RETORNAM DA CONTROLLER, TAIS DADOS PODEM SER ACESSADOS PELA VARIAVEL "(data)":
            success: function (data) {
                if (data.clear) {
                    Form.trigger('reset');
                }
                $('.j-result-historico').html('');
                $(data).each(function (index, value) {
                    $('.j-result-historico').append(
                            "<tr id='" + value.idhist_pag + "'>" +
                            "<td>" + value.idhist_pag + "</td>" +
                            "<td>" + value.nome_aluno + "</td>" +
                            "<td>" + value.nome_plano + "</td>" +
                            "<td>" + value.data_mens_pag + "</td>" +
                            "<td>" + value.valor_pag + "</td>" +
                            "<td>" +
                            "<a href='http://localhost/academia/Views/view.mensalidade.comprovante.php?idhist_pag=" + value.idhist_pag + "' target='_blank'><button class='btn btn-warning btn-xs open-imprimir'><i class='glyphicon glyphicon-print'></i></button></a>" +
                            "</td>" +
                            "</tr>"
                            );
                });
                if (data.vazio) {
                    $('.alert-danger').fadeIn();
                    $('.j-result-historico').html('');
                }
                setTimeout(function () {
                    $('.alert-danger').fadeOut();
                }, 3000);
            }
        });
        return false;
    });

    //A FUNÇÃO ABAIXO EVITA QUE AO TECLAR ENTER O INPUT DE PESQUISA FAÇA UMA NOVA REQUISIÇÃO HTTP:
    $('.pesquisar-hist-mens').on('keypress', function (e) {
        return e.which !== 13;
    });
    //FUNÇÃO REPONSÁVEL POR FAZER CONSULTAS DE ACORDO COM PESQUISAS DO USUÁRIO:
    $('.pesquisar-hist-mens').keyup(function () {
        var termo = $(".pesquisar-hist-mens").val();
        if (termo === '') {
            termo = '0';
        }
        $.ajax({
            url: "Controllers/controller.historico_mens.php",
            data: termo,
            type: 'POST',
            dataType: 'json',
            beforeSend: function (xhr) {

            },
            success: function (data) {
                $('.j-result-historico').html('');
                $(data).each(function (index, value) {
                    $('.j-result-historico').append(
                            "<tr id='" + value.idhist_pag + "'>" +
                            "<td>" + value.idhist_pag + "</td>" +
                            "<td>" + value.nome_aluno + "</td>" +
                            "<td>" + value.nome_plano + "</td>" +
                            "<td>" + value.data_mens_pag + "</td>" +
                            "<td>" + value.valor_pag + "</td>" +
                            "<td>" +
                            "<a href='http://localhost/academia/Views/view.mensalidade.comprovante.php?idhist_pag=" + value.idhist_pag + "' target='_blank'><button class='btn btn-warning btn-xs open-imprimir'><i class='glyphicon glyphicon-print'></i></button></a>" +
                            "</td>" +
                            "</tr>"
                            );
                });
            }
        });
    });
});


