//INICIAR JQUERY:
$(function () {
    //A FUNÇÃO ABAIXO EVITA QUE AO TECLAR ENTER O INPUT DE PESQUISA FAÇA UMA NOVA REQUISIÇÃO HTTP
    $('.pesquisar-funcionario').on('keypress', function (e) {
        return e.which !== 13;
    });
    //FUNÇÃO RESPONSAVEL POR FAZER CONSULTAS DE ACORDO COM A PESQUISA DO USUÁRIO
    $(".pesquisar-funcionario").keyup(function () {
        var termo = $(".pesquisar-funcionario").val();
        if (termo === '') {
            termo = '0';
        }
        $.ajax({
            url: "Controllers/controller.funcionario.php",
            data: termo,
            type: 'POST',
            dataType: 'json',
            beforeSend: function (xhr) {

            },
            success: function (data) {
                $(".j-result-funcionarios").html('');
                $(data).each(function (index, value) {
                    $(".j-result-funcionarios").append(
                            "<tr id='" + value.idfuncionarios + "'>" +
                            "<td>" + value.idfuncionarios + "</td>" +
                            "<td>" + value.nome_func + "</td>" +
                            "<td>" + value.cargo_func + "</td>" +
                            "<td>" + value.status_func + "</td>" +
                            "<td align='right'>" +
                            "<button class='btn btn-success btn-xs open-modal-update j-open-modal-update-funcionario' idfuncionarios='" + value.idfuncionarios + "' idendereco_func='" + value.idendereco_func + "'><i class='glyphicon glyphicon-edit'></i></button> " +
                            "<a href='http://localhost/academia/Views/view.funcionario.relatorio.php' target='_blank'><button class='btn btn-warning btn-xs open-imprimir'><i class='glyphicon glyphicon-print'></i></button></a>" +
                            "</td>" +
                            "</tr>"
                            );
                });
            }
        });
    });

    //Função para validar CPF do funcionário
        $(".j-form-create-funcionario").on("keyup", "#cpf_func", function(){
        var text = $(this).val();
        var tam = text.length;
        if(tam === 14){
            $.ajax({
                url: "Controllers/controller.funcionario.php",
                data: {callback:'validar-cpf', cpf:text},
                type: 'POST',
                dataType: 'json',
                beforeSend: function (xhr) {
                    
                },
                success: function (data) {
                    if(data.trigger){
                        alert('O CPF Digitado não é válido, tente novamente.');
                        $("#cpf_func").val('');
                    }
                }
            });
        }
        
    });

//    SELECIONAR O FORMULARIO AO SER SUBMETIDO USANDO UMA CLASSE PARA IDENTIFICAR O FORMULÁRIO:
    $(".j-form-create-funcionario").submit(function () {
//        VARIAVEL FORM RECEBE O PROPRIO FORMULARIO USANDO O METODO DO JQUERY "THIS":
        var Form = $(this);
//        VARIAVEL ACTION RECEBE O VALOR DO CALLBACK QUE É UM INPUT ESCONDIDO NO FORMULARIO ESSE CALLBACK SERVE COMO GATILHO PARA CONDIÇÕES:
        var Action = Form.find('input[name="callback"]').val();
//        VARIAVEL DATA RECEBE UMA MATRIZ COM OS DADOS DO FORMULARIO (FORM) INDICE E VALOR:
        var Data = Form.serialize();

//        INICIAÇÃO DO AJAX - PARA ENVIAR E RECEBER DADOS:
        $.ajax({
//            URL É O CAMINHO QUE ESTÁ A CONTROLLER, ONDE SERÃO ENVIADOS OS DADOS DO FORMULARIO (FORM -> DATA):
            url: "Controllers/controller.funcionario.php",
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
                }
                $('.modal-create').fadeOut(0);
                $('.close-modal-create').fadeOut(0);
                $('.open-modal-create').fadeIn(0);
                $('.relatorio-geral').fadeIn(0);
                $('.pesquisar').fadeIn(0);
                $('.modal-table').fadeIn(0);

                if (data.novofunc) {
                    var novoFunc = data.novofunc;
                    $(".j-result-funcionarios").prepend(
                            "<tr id='" + novoFunc.idfuncionarios + "' class='animated zoomInDown'>" +
                            "<td>" + novoFunc.idfuncionarios + "</td>" +
                            "<td>" + novoFunc.nome_func + "</td>" +
                            "<td>" + novoFunc.cargo_func + "</td>" +
                            "<td>" + novoFunc.status_func + "</td>" +
                            "<td align='right'>" +
                            "<button class='btn btn-success btn-xs open-modal-update j-open-modal-update-funcionario' idfuncionarios='" + novoFunc.idfuncionarios + "' idendereco_func='"+ novoFunc.idendereco_func +"'><i class='glyphicon glyphicon-edit'></i></button> " +
                            "<a href='http://localhost/academia/Views/view.funcionario.relatorio.php' target='_blank'><button class='btn btn-warning btn-xs open-imprimir'><i class='glyphicon glyphicon-print'></i></button></a>" +
                            "</td>" +
                            "</tr>"
                            );
                    setTimeout(function () {
                        $("tr[id='" + novoFunc.idfuncionarios + "']:first").removeClass("animated zoomInDown");
                    }, 1000);
                }
            }
        });

//        RETURN É A FUNÇÃO PARA NÃO PERMITIR QUE O FORMULÁRIO GERE AÇÃO: 
        return false;
    });

    //FUNÇÃO PARA PREENCHER A DIV DE ATUALIZAÇÃO DE CADASTRO COM OS DADOS DE CADA FUNIONÁRIOS:
    $('html').on('click', '.j-open-modal-update-funcionario', function () {
        var button = $(this);
        var idfuncionarios = $(button).attr('idfuncionarios');
        var idendereco_func = $(button).attr('idendereco_func');
        var dados_edit = {callback: 'povoar-edit', idfuncionarios: idfuncionarios, idendereco_func: idendereco_func};
        $.ajax({
            url: "Controllers/controller.funcionario.php",
            data: dados_edit,
            type: 'POST',
            dataType: 'json',
            beforeSend: function (xhr) {

            },
            success: function (data) {
                var Form = $('.j-form-update-funcionario');
                $.each(data, function (key, value) {
                    Form.find("input[name='" + key + "'], select[name='" + key + "'], textarea[name='" + key + "']").val(value);
                });
            }
        });
    });

});