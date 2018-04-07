//INICIAR JQUERY:
$(function () {

    //A FUNÇÃO ABAIXO EVITA QUE AO TECLAR ENTER O INPUT DE PESQUISA FAÇA UMA NOVA REQUISIÇÃO HTTP
    $('.pesquisar-exercicio').on('keypress', function (e) {
        return e.which !== 13;
    });

    //FUNÇÃO RESPONSÁVEL POR FAZER CONSULTAS DE ACORDO COM PESQUISAS DO USUÁRIO:
    $(".pesquisar-exercicio").keyup(function () {
        var termo = $(".pesquisar-exercicio").val();
        if (termo === '') {
            termo = '0';
        }
        $.ajax({
            url: "Controllers/controller.exercicio.php",
            data: termo,
            type: 'POST',
            dataType: 'json',
            beforeSend: function (xhr) {

            },
            success: function (data) {
                $(".j-result-exercicios").html('');
                $(data).each(function (index, value) {
                    $(".j-result-exercicios").append(
                            "<tr id='" + value.idexercicios + "'>" +
                            "<td>" + value.idexercicios + "</td>" +
                            "<td>" + value.descricao_exe + "</td>" +
                            "<td>" + value.grupo_muscular_exe + "</td>" +
                            "<td align='right'>" +
                            "<button class='btn btn-success btn-xs open-modal-update j-open-modal-update-exercicio' idexercicios='" + value.idexercicios + "'><i class='glyphicon glyphicon-edit'></i></button> " +
                            "</td>" +
                            "</tr>"
                            );
                });
            }
        });
    });


//    SELECIONAR O FORMULARIO AO SER SUBMETIDO USANDO UMA CLASSE PARA IDENTIFICAR O FORMULÁRIO:
    $(".j-form-create-exercicio").submit(function () {
//        VARIAVEL FORM RECEBE O PROPRIO FORMULARIO USANDO O METODO DO JQUERY "THIS":
        var Form = $(this);
//        VARIAVEL ACTION RECEBE O VALOR DO CALLBACK QUE É UM INPUT ESCONDIDO NO FORMULARIO ESSE CALLBACK SERVE COMO GATILHO PARA CONDIÇÕES:
        var Action = Form.find('input[name="callback"]').val();
//        VARIAVEL DATA RECEBE UMA MATRIZ COM OS DADOS DO FORMULARIO (FORM) INDICE E VALOR:
        var Data = Form.serialize();

//        INICIAÇÃO DO AJAX - PARA ENVIAR E RECEBER DADOS:
        $.ajax({
//            URL É O CAMINHO QUE ESTÁ A CONTROLLER, ONDE SERÃO ENVIADOS OS DADOS DO FORMULARIO (FORM -> DATA):
            url: "Controllers/controller.exercicio.php",
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

                if (data.novoexercicio) {
                    var novoExercicio = data.novoexercicio;
                    $('.j-result-exercicios').prepend(
                            "<tr id='" + novoExercicio.idexercicios + "' class='animated zoomInDown'>" +
                            "<td>" + novoExercicio.idexercicios + "</td>" +
                            "<td>" + novoExercicio.descricao_exe + "</td>" +
                            "<td>" + novoExercicio.grupo_muscular_exe + "</td>" +
                            "<td align='right'>" +
                            "<button class='btn btn-success btn-xs open-modal-update j-open-modal-update-exercicio' idexercicios='" + novoExercicio.idexercicios + "'><i class='glyphicon glyphicon-edit'></i></button> " +
                            "</td>" +
                            "</tr>"
                            );
                    setTimeout(function () {
                        $("tr[id='" + novoExercicio.idexercicios + "']:first").removeClass("animated zoomInDown");
                    }, 1000);
                }
            }
        });

//        RETURN É A FUNÇÃO PARA NÃO PERMITIR QUE O FORMULÁRIO GERE AÇÃO: 
        return false;
    });

    //    FUNÇÃO RESPONSÁVEL POR ATUALIZAR OS DADOS DE UMA EXERCICIO NO BANCO DE DADOS:
    $('.j-form-update-exercicio').submit(function () {
        var Form = $(this);
        var Data = Form.serialize();

        $.ajax({
            url: "Controllers/controller.exercicio.php",
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
                    var exercicioEditado = data.content;
                    //FUNÇÃO RESPONSÁVEL POR OCULTAR DO DOM O REGISTRO QUE FOI EDITADO COM EFEITO ANIMATE E POIS FADEOUT, POIS O EFEITO DO ANIMTE GERA UM CSS COMO 'display: hidden' E NÃO 'display: none', E DEIXA ESPAÇO NO HTML, POR ISSO O USO DA FUNÇÃO 'fadeOut()' POSTERIORMENTE.
                    $('html').find("tr[id='" + exercicioEditado.idexercicios + "']").addClass("animated zoomOutDown").fadeOut(720);
                    //FUNÇÃO RESPONSÁVEL POR INSERIR NO DOM O NOVO ALUNO CADASTRADO. *IMPORTANTE USAR O PARÂMETRO ':first' PARA QUE O JQUERY COLOQUE O NOVO ALUNO ACIMA DO ANTIGO REGISTRO, CASO NÃO TENHA O PARÂMETRO O MESMO ALUNO EDITADO PODERÁ SER INSERIDO NO DOM MAIS DE UMA VEZ.
                    $("tr[id='" + exercicioEditado.idexercicios + "']:first").before(
                            "<tr id='" + exercicioEditado.idexercicios + "' class='animated zoomInDown'>" +
                            "<td>" + exercicioEditado.idexercicios + "</td>" +
                            "<td>" + exercicioEditado.descricao_exe + "</td>" +
                            "<td>" + exercicioEditado.grupo_muscular_exe + "</td>" +
                            "<td align='right'>" +
                            "<button class='btn btn-success btn-xs open-modal-update j-update-exercicio j-open-modal-update-exercicio' idexercicios='" + exercicioEditado.idexercicios + "'><i class='glyphicon glyphicon-edit'></i></button> " +
                            "</td>" +
                            "</tr>"
                            );
                    //ESSA FUNÇÃO EVITA QUE AO ADICIONAR UM NOVO USUÁRIO DIFERENTE GERE EFEITOS EM ELEMENTOS QUE JÁ FORAM CADASTRADOS ANTES.
                    setTimeout(function () {
                        $("tr[id='" + exercicioEditado.idexercicios + "']:first").removeClass("animated zoomInDown");
                    }, 1000);
                }
            }
        });

        return false;
    });


    //FUNÇÃO PARA PREENCHER A DIV DE ATUALIZAÇÃO DE CADASTRO COM OS DADOS DE CADA EXERCICIO:
    $('html').on('click', '.j-open-modal-update-exercicio', function () {
        var button = $(this);
        var idexercicios = $(button).attr('idexercicios');
        var dados_edit = {callback: 'povoar-edit', idexercicios: idexercicios};
        $.ajax({
            url: "Controllers/controller.exercicio.php",
            data: dados_edit,
            type: 'POST',
            dataType: 'json',
            beforeSend: function (xhr) {

            },
            success: function (data) {
                var Form = $('.j-form-update-exercicio');
                $.each(data, function (key, value) {
                    Form.find("input[name='" + key + "'], select[name='" + key + "'], textarea[name='" + key + "']").val(value);
                });
            }
        });
    });

});


