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
            url: "http://localhost/academia/Controllers/controller.catraca.php",
            data: Data,
            type: 'POST',
            dataType: 'json',
            beforeSend: function (xhr) {

            },
            success: function (data) {
                if(data.sucesso){
                    $('.alert-success').fadeIn();
                }
                if(data.erro){
                    $('.alert-danger').fadeIn();
                }
                if(data.alerta){
                    $('.alert-warning').fadeIn();
                }
                if(data.clear){
                    Form.trigger('reset');
                }
            }
        });
        return false;
    });

});

