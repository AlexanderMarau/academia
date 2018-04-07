//INICIAR JQUERY:
$(function () {

    //A FUNÇÃO ABAIXO EVITA QUE AO TECLAR ENTER O INPUT DE PESQUISA FAÇA UMA NOVA REQUISIÇÃO HTTP
    $('.pesquisar-usuario').on('keypress', function (e) {
        return e.which !== 13;
    });
    //FUNÇÃO RESPONSÁVEL POR FAZER CONSULTAS DE ACORDO COM PESQUISAS DO USUÁRIO:
    $(".pesquisar-usuario").keyup(function () {
        var termo = $(".pesquisar-usuario").val();
        if (termo === '') {
            termo = '0';
        }
        $.ajax({
            url: "Controllers/controller.usuario.php",
            data: termo,
            type: 'POST',
            dataType: 'json',
            beforeSend: function (xhr) {

            },
            success: function (data) {
                $(".j-result-usuarios").html('');
                $(data).each(function (index, value) {
                    $(".j-result-usuarios").append(
                            "<tr id='" + value.idusuario + "'>" +
                            "<td>" + value.idusuario + "</td>" +
                            "<td>" + value.nome_func + "</td>" +
                            "<td>" + value.email_usuario + "</td>" +
                            "<td>" + value.perfil_usuario + "</td>" +
                            "<td align='right'>" +
                            "<button class='btn btn-success btn-xs open-modal-update j-open-modal-update-usuario' idusuario='" + value.idusuario + "'><i class='glyphicon glyphicon-edit'></i></button> " +
                            "<button class='btn btn-danger btn-xs open-delete'><i class='glyphicon glyphicon-trash'></i></button>" +
                            "</td>" +
                            "</tr>"
                            );
                });
            }
        });
    });


//    SELECIONAR O FORMULARIO AO SER SUBMETIDO USANDO UMA CLASSE PARA IDENTIFICAR O FORMULÁRIO:
    $(".j-form-create-usuario").submit(function () {
//        VARIAVEL FORM RECEBE O PROPRIO FORMULARIO USANDO O METODO DO JQUERY "THIS":
        var Form = $(this);
//        VARIAVEL ACTION RECEBE O VALOR DO CALLBACK QUE É UM INPUT ESCONDIDO NO FORMULARIO ESSE CALLBACK SERVE COMO GATILHO PARA CONDIÇÕES:
        var Action = Form.find('input[name="callback"]').val();
//        VARIAVEL DATA RECEBE UMA MATRIZ COM OS DADOS DO FORMULARIO (FORM) INDICE E VALOR:
        var Data = Form.serialize();

//        INICIAÇÃO DO AJAX - PARA ENVIAR E RECEBER DADOS:
        $.ajax({
//            URL É O CAMINHO QUE ESTÁ A CONTROLLER, ONDE SERÃO ENVIADOS OS DADOS DO FORMULARIO (FORM -> DATA):
            url: "Controllers/controller.usuario.php",
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

                if (data.novousuario) {
                    var novoUsuario = data.novousuario;
                    $('.j-result-usuarios').prepend(
                            "<tr id='" + novoUsuario.idusuario + "' class='animated zoomInDown'>" +
                            "<td>" + novoUsuario.idusuario + "</td>" +
                            "<td>" + novoUsuario.nome_func + "</td>" +
                            "<td>" + novoUsuario.email_usuario + "</td>" +
                            "<td>" + novoUsuario.perfil_usuario + "</td>" +
                            "<td align='right'>" +
                            "<button class='btn btn-success btn-xs open-modal-update j-open-modal-update-usuario' idusuario='" + novoUsuario.idusuario + "'><i class='glyphicon glyphicon-edit'></i></button> " +
                            "<button class='btn btn-danger btn-xs open-delete'><i class='glyphicon glyphicon-trash'></i></button>" +
                            "</td>" +
                            "</tr>"
                            );
                    setTimeout(function () {
                        $("tr[id='" + novoUsuario.idusuario + "']:first").removeClass("animated zoomInDown");
                    }, 1000);
                }
            }
        });

//        RETURN É A FUNÇÃO PARA NÃO PERMITIR QUE O FORMULÁRIO GERE AÇÃO: 
        return false;
    });

//FUNÇÃO RESPONSÁVEL POR DELETAR REGISTROS DE USUÁRIOS NO BANCO DE DADOS.
    $('html').on('click', '.j-btn-del-usuario', function () {
        var delButton = $(this);
        var idusuario = $(delButton).attr('idusuario');
        var Dados = {callback: 'delete-usuario', idusuario: idusuario};
        $.ajax({
            url: "Controllers/controller.usuario.php",
            data: Dados,
            type: 'POST',
            dataType: 'json',
            beforeSend: function (xhr) {
            },
            success: function (data) {
                if (data.delete) {
                    $('html').find("tr[id='" + data.idusuario + "']").addClass("animated zoomOutDown").fadeOut(720);
                }
            }
        });
    });
    
    //FUNÇÃO PARA PREENCHER A DIV DE ATUALIZAÇÃO DE CADASTRO COM OS DADOS DE CADA USUÁRIO:
    $('html').on('click', '.j-open-modal-update-usuario', function () {
        var button = $(this);
        var idusuario = $(button).attr('idusuario');
        var dados_edit = {callback: 'povoar-edit', idusuario: idusuario};
        $.ajax({
            url: "Controllers/controller.usuario.php",
            data: dados_edit,
            type: 'POST',
            dataType: 'json',
            beforeSend: function (xhr) {

            },
            success: function (data) {
                var Form = $('.j-form-update-usuario');
                $.each(data, function (key, value) {
                    Form.find("input[name='" + key + "'], select[name='" + key + "'], textarea[name='" + key + "']").val(value);
                });
            }
        });
    });
});