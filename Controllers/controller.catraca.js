//FUNÇÃO PARA ATUALIZAR A PAGINA A CADA 30 SEGUNDOS:

//window.onload = function(){
   // setTimeout('location.reload();', 30000);
//};

//INICIAR JQUERY
$(function () {
    
    //FUNÇÃO RESPONSAVEL POR CADASTRAR UM NOVO REGISTRO:
    $(".j-form-create-registro").submit(function () {
        //VARIAVEL FORM QUE RECEBE O PROPRIO FORMULÁRIO USANDO O METODO DO JQUERY 'THIS':
        var Form = $(this);
        //VARIAVEL ACTION RECEBE O VALOR DO CALLBACK QUE É UM INPUT ESCONDIDO NO FORMULÁRIO, ESSE CALLBACK SERVE COMO UM GATILHO PARA CONDIÇÕES:
        var Action = Form.find('input[name="callback"]').val();
        //VARIAVEL DATA RECEBE UMA MATRIZ COM OS DADOS DO FORMULÁRIO (FORM) INDICE DE VALOR:
        var Data = Form.serialize();

        //INICIAÇÃO DO AJAX - PARA ENVIAR E RECEBER DADOS:
        $.ajax({
            url: "Controllers/controller.catraca.php",
            data: Data,
            type: 'POST',
            dataType: 'json',
            beforeSend: function (xhr) {

            },
            success: function (data) {
                if (data.sucesso) {
                    $('.alert-success').fadeIn();
                }
                setTimeout(function () {
                        $('.alert-success').fadeOut();
                    }, 3000);
                if (data.informacao) {
                    $('.alert-info').fadeIn();
                }
                setTimeout(function () {
                        $('.alert-info').fadeOut();
                    }, 3000);
                if (data.erro) {
                    $('.alert-danger').fadeIn();
                }
                setTimeout(function () {
                        $('.alert-danger').fadeOut();
                    }, 3000);
                if (data.alerta) {
                    $('.alert-warning').fadeIn();
                }
                setTimeout(function () {
                        $('.alert-warning').fadeOut();
                    }, 3000);
                if (data.insesistente) {
                    $('.alert-inesistente').fadeIn();
                }
                setTimeout(function () {
                        $('.alert-inesistente').fadeOut();
                    }, 3000);
                if (data.clear) {
                    Form.trigger('reset');
                }
            }
        });
        return false;
    });
    
    //FUNÇÃO PARA REGISTRAR SAIDA NO SISTEMA DE CATRACA:
    $(".j-form-update-registro").submit(function (){
        
        var Form = $(this);
        var Data = Form.serialize();
        
        $.ajax({
            url: "http://localhost/academia/Controllers/controller.catraca.php",
            data: Data,
            type: 'POST',
            dataType: 'json',
            beforeSend: function (xhr){
                
            },
            success: function (data){
                if (data.saiu) {
                    $('.alert-saiu').fadeIn();
                }
                setTimeout(function () {
                        $('.alert-saiu').fadeOut();
                    }, 3000);
                if (data.fora) {
                    $('.alert-fora').fadeIn();
                }
                setTimeout(function () {
                        $('.alert-fora').fadeOut();
                    }, 3000);
                if(data.clear){
                    Form.trigger('reset');
                }
            }
        });
        return false;
    });
    
    //A FUNÇÃO ABAIXO EVITA QUE AO TECLAR ENTER O INPUT DE PESQUISA FAÇA UMA NOVA REQUISIÇÃO HTTP
    $('.pesquisar-histC').on('keypress', function (e) {
        return e.which !== 13;
    });
    
    $(".pesquisar-histC").keyup(function () {
        var termo = $(".pesquisar-histC").val();
        if (termo === '') {
            termo = '0';
        }
        $.ajax({
            url: "Controllers/controller.catraca.php",
            data: termo,
            type: 'POST',
            dataType: 'json',
            beforeSend: function (xhr) {

            },
            success: function (data) {
                $('.j-result-historicoC').html('');
                $(data).each(function (index, value) {
                    $('.j-result-historicoC').append(
                            "<tr id='" + value.idregistros_catraca + "'>" +
                            "<td>" + value.idregistros_catraca + "</td>" +
                            "<td>" + value.idalunos_cliente + "</td>" +
                            "<td>" + value.nome_aluno + "</td>" +
                            "<td>" + value.hr_entrada_catraca + "</td>" +
                            "<td>" + value.hr_saida_catraca + "</td>" +
                            "<td>" + value.data_registro + "</td>" +
                            "</tr>"
                            );
                });
            }
        });
    });
        
});

